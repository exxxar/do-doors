<?php

namespace App\Http\Controllers;

use App\Classes\DocumentLogic;
use App\Enums\OrderStatusEnum;
use App\Exports\Cart\MultiSheetsCartExport;
use App\Exports\CartExport;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use MessageFormatter;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;

use nomelodic\NCL\NCLNameCaseRu;


class CalcController extends Controller
{

    public function downloadCartExcel(Request $request)
    {
        $request->validate([
            "items" => "required",
        ]);


        $items = json_decode($request->items ?? '[]');


        return Excel::download(new CartExport($items), "cart.xls");
    }

    /**
     * @throws TelegramSDKException
     * @throws MpdfException
     */
    public function checkout(Request $request)
    {
        ini_set('max_execution_time', 30000);

        $request->validate([
            "name" => "required",
            "phone" => "required",
            "items" => "required",
        ]);

        $currentPayed = $request->current_payed ?? 0;
        $payedPercent = $request->payed_percent ?? 0;
        $deliveryTerms = $request->delivery_terms ?? null;

        $workWithNds = $request->work_with_nds ?? 1;

        $clientId = $request->id ?? null;

        $name = $request->name;
        $email = $request->email ?? 'не указано';
        $phone = $request->phone;
        $passport = $request->passport ?? 'не указано';
        $work_days = $request->work_days ?? 0;
        $passport_issued = $request->passport_issued ?? 'не указано';
        $info = $request->info ?? 'не указана';
        $totalPrice = $request->total_price ?? 0;
        $totalCount = $request->total_count ?? 0;
        $items = json_decode($request->items ?? '[]');

        if (is_null($clientId)) {
            $client = Client::query()
                ->where("phone", $phone)
                ->first();
            if (is_null($client))
                $client = Client::query()->create([
                    'status' => "new_client",
                    'phone' => $phone,
                    'email' => $email ?? null,
                    'user_id' => Auth::user()->id,
                    'title' => $name,
                ]);
        } else
            $client = Client::query()->find($clientId);

        $buyerData = $client->getBueryData();
        $fam_initial = $client->getInitials();

        $order = Order::query()->create([
            'contract_number' => null,
            'contract_date' => Carbon::now(),
            'completion_at' => null,
            'client_id' => $client->id,
            'status' => OrderStatusEnum::NewOrder,
            'source' => $request->source ?? "crm",
            'contact_person' => $name,
            'phone' => $phone,
            'organizational_form' => $client->status ?? 'new_client',
            'contract_amount' => $totalPrice,
            'work_days' => $work_days,
            'paid' => 0,
            'debt' => 0,
            'profit' => 0,

            'delivery_terms' => $deliveryTerms,
            'info' => $info,
            'total_price' => $totalPrice,
            'total_count' => $totalCount,
            'current_payed' => $currentPayed,
            'payed_percent' => $payedPercent,

        ]);

        $bitrix = new \App\Services\BitrixService();

        $leadData = $client->getBitrix24LeadData();
        $leadData["TITLE"] = $name;
        $leadData["COMMENTS"] = $info;
        $leadData["UF_CRM_1733302565"] = "ул. Тестовая";
        $leadData["UF_CRM_1733302582"] = "25.05.2025";
        $leadData["UF_CRM_1733302597"] = "20.05.2025";
        $leadData["UF_CRM_1733302797738"] = "Договор №1";
        $leadData["UF_CRM_1733302818544"] = "14.05.2025";
        $leadData["UF_CRM_1733302846046"] = 63;
        $leadData["UF_CRM_1733302866734"] = "Тестовый город";
        $leadData["UF_CRM_1733302917133"] = 1000.0;
        $leadData["UF_CRM_1733302937139"] = 20000.0;
        $leadData["UF_CRM_1733302958322"] = 19000.0;
        $leadData["WEB"] = [['VALUE' => env("APP_URL") . "/link/" . $order->id, 'VALUE_TYPE' => 'OTHER']];
        $leadId = $bitrix->createDeal($leadData)["result"] ?? null;

        $order->bitrix24_lead_id = $leadId;
        $order->save();

        $productsForBitrix = [];
        foreach ($items as $item) {

            $bitrixProductTitle = sprintf(
                "DoDoors: %s, %s, петли %s.
    Отделка с передней стороны: %s.
    Отделка с задней стороны: %s.
    Цвет короба и полотна: %s.
    Цвет фурнитуры: %s.
    Размер: %sx%s мм.
    Количество: %s шт.
    Стоимость за комплект: %s руб.
    Итоговая стоимость: %s руб.",
                $item->product->door_type->title ?? 'не указано',
                $item->product->opening_type->title ?? 'не указано',
                $item->product->loops->title ?? 'не указано',
                $item->product->front_side_finish->title ?? 'не указано',
                $item->product->back_side_finish->title ?? 'не указано',
                $item->product->box_and_frame_color->title ?? 'не указано',
                $item->product->fittings_color->title ?? 'не указано',
                $item->product->height ?? 0,
                $item->product->width ?? 0,
                $item->quantity ?? 0,
                $item->product->price ?? 0,
                ($item->product->price ?? 0) * ($item->quantity ?? 0)
            );

            $productData = [
                'NAME' => "Комплект дверей \"" . ($item->product->purpose ?? '-') . "\"",
                'CURRENCY_ID' => 'RUB',
                'PRICE' => $item->product->price ?? 0,
                'DESCRIPTION' => $bitrixProductTitle,
                'MEASURE' => 6,
                'QUANTITY' => $item->product->count ?? 0 // Единица измерения (шт.)
            ];

            $bitrixProductId = $bitrix->addProduct($productData)["result"] ?? null;

            OrderDetail::query()->create([
                'order_id' => $order->id,
                'door_type' => $item->product->title ?? null,
                'count' => $item->product->count ?? 0,
                'price' => $item->product->price ?? 0,
                'comment' => $item->product->comment ?? null,
                'purpose' => $item->product->purpose ?? null,
                'door' => $item->product,
                'bitrix24_product_id' => $bitrixProductId
            ]);

            $productsForBitrix[] = [
                "PRODUCT_ID" => $bitrixProductId,
                "PRICE" => $item->product->price ?? 0,
                "QUANTITY" => $item->product->count ?? 0,
            ];

        }

        if ($request->need_delivery ?? false) {
            $deliveryProductData = [
                'NAME' => "Доставка комплекта дверей",
                'CURRENCY_ID' => 'RUB',
                'PRICE' => $request->delivery_price ?? 0,
                'DESCRIPTION' => ($request->delivery_city ?? '') . ", " . ($request->delivery_address ?? ''),
                'MEASURE' => 0,
                'QUANTITY' => 1
            ];

            $bitrixProductId = $bitrix->addProduct($deliveryProductData)["result"] ?? null;

            $productsForBitrix[] = [
                "PRODUCT_ID" => $bitrixProductId,
                "PRICE" => $request->delivery_price ?? 0,
                "QUANTITY" => 1,
            ];
        }

        $result = $bitrix->addProductToDeal($leadId, $productsForBitrix);


        $mpdf = new Mpdf(['format' => 'A4-P']);
        $current_date = Carbon::now("+3:00")->format("Y-m-d H:i:s");

        $number = Str::uuid();

        $mpdf->WriteHTML(view("pdf.order-v2", [
            "name" => $name,
            "order_id" => $number,
            "current_date" => $current_date,
            "email" => $email,
            "phone" => $phone,
            "info" => $info,
            "total_price" => $totalPrice,
            "total_count" => $totalCount,
            "items" => $items
        ]));

        $file = $mpdf->Output("order-$number.pdf", \Mpdf\Output\Destination::STRING_RETURN);

        $excelFileName = Str::uuid() . ".xls";

        $timeFragment = Carbon::now("+3:00")->format("Y-m-d-H-i-s");


        Excel::store(new MultiSheetsCartExport($items, $buyerData), $excelFileName);

        $bitrixFiles = [
            [
                "name" => "спецификация от " . $timeFragment . ".xls", "path" => base64_encode(file_get_contents(storage_path("app/$excelFileName"))),
            ],
            [
                "name" => "информация о заказе от " . $timeFragment . ".pdf", "path" => base64_encode($file),
            ]
        ];


        $path = storage_path() . "/app";

        $fileName = $client->status == 'individual' ? "договор с ФЛ.docx" : ($workWithNds == 1 ? "договор с ООО.docx" : "договор с ИП.docx");
        $statusClient = $client->getShortClientStatus();


        $newName = "/договор с клиентом №" . $client->id . " " . ($statusClient) . " от" . (Carbon::now()->format('Y-m-d h-i-s')) . ".docx";

        $work_days_string = $work_days . "(" . (new MessageFormatter('ru-RU', '{n, spellout}'))->format(['n' => $work_days]) . ")";

 /*       $nc = new NCLNameCaseRu();
        $member = $nc->q($client->fio, NCLNameCaseRu::$RODITLN);*/

        if (file_exists($path . "/$fileName")) {
            try {
                $templateProcessor = new TemplateProcessor($path . "/$fileName");
                $templateProcessor->setValue('date_doc', Carbon::now()->format('d-m-Y'));
                $templateProcessor->setValue('numb_doc', $order->id);
                $templateProcessor->setValue('title', $name);
                $templateProcessor->setValue('member', $client->fio ?? '-');
                $templateProcessor->setValue('fio', $fam_initial ?? '-');
                $templateProcessor->setValue('email', $email);
                $templateProcessor->setValue('phone', $phone);
                $templateProcessor->setValue('fact_address', $client->fact_address ?? '-');
                $templateProcessor->setValue('law_address', $client->law_address ?? '-');
                $templateProcessor->setValue('inn', $client->inn ?? '-');
                $templateProcessor->setValue('ogrn', $client->ogrn ?? '-');
                $templateProcessor->setValue('kpp', $client->kpp ?? '-');
                $templateProcessor->setValue('okpo', $client->okpo ?? '-');

                $templateProcessor->setValue('order_id', $order->id);
                $templateProcessor->setValue('info', $info);
                $templateProcessor->setValue('total_price', $totalPrice);
                $templateProcessor->setValue('total_count', $totalCount);
                $templateProcessor->setValue('current_payed', $currentPayed);
                $templateProcessor->setValue('payed_percent', $payedPercent);
                $templateProcessor->setValue('last_payment', floatval($totalPrice) - floatval($currentPayed));
                $templateProcessor->setValue('delivery_terms', $deliveryTerms);
                $templateProcessor->setValue('work_days', $work_days_string);

                // requisites
                $templateProcessor->setValue('bik', $buyerData["buyer_bank_bic"]);
                $templateProcessor->setValue('ksch', $buyerData["buyer_correspondent_account"]);
                $templateProcessor->setValue('rsch', $buyerData["buyer_checking_account"]);
                $templateProcessor->setValue('bank_name', $buyerData["buyer_bank_name"]);
                $templateProcessor->setValue('passport', $passport);
                $templateProcessor->setValue('passport_issued', $passport_issued);

                $doc = new DocumentLogic();
                $sellerParams = $doc->getAllSellerParameters($workWithNds);

                foreach ($sellerParams as $key => $value)
                    $templateProcessor->setValue($key, $value);

                $templateProcessor->saveAs($path . $newName);

                $bitrix->addDocumentToDeal($leadId, $newName, base64_encode(file_get_contents($path . $newName)), env('DOCUMENT_FILED_CODE_CONTRACT'));
                // $bitrixFiles[] = ["name" => $newName, "path" => base64_encode(file_get_contents($path . $newName))];

            } catch (CopyFileException $e) {

            } catch (CreateTemporaryFileException $e) {

            }

        }
        $R = $bitrix->addDocumentToDeal($leadId, $bitrixFiles, env('DOCUMENT_FILED_CODE_SPECIFICATION'));

        if (env("SEND_DOCS_TO_TELEGRAM_CHANNEL") ?? false) {

            $tmp = [
                'chat_id' => env("TELEGRAM_CHANNEL_ID"),
                "text" => "#заказ\nПоступил новый заказ!\n"
                    . "Имя клиент: $name\n"
                    . "E-mail: $email\n"
                    . "Телефон: $phone\n"
                    . "Доп.инфо: $info\n"
                    . "Общее кол-во товара: $totalCount ед.\n"
                    . "Цена товара: $totalPrice руб.\n",
                "parse_mode" => "HTML",
            ];

            $telegram = new Api(env("TELEGRAM_BOT_TOKEN"));
            $telegram->sendMessage($tmp);
            sleep(1);
            $telegram->sendDocument([
                'chat_id' => env("TELEGRAM_CHANNEL_ID"),
                "document" => InputFile::createFromContents(Storage::get("$excelFileName"), "order-" . $timeFragment . ".xls"),
                "parse_mode" => "HTML",
            ]);
            sleep(1);
            $telegram->sendDocument([
                'chat_id' => env("TELEGRAM_CHANNEL_ID"),
                "document" => InputFile::createFromContents($file, "order-" . $timeFragment . ".pdf"),
                "parse_mode" => "HTML",
            ]);
            sleep(1);
            if (file_exists($path . $newName))
                $telegram->sendDocument([
                    'chat_id' => env("TELEGRAM_CHANNEL_ID"),
                    "document" => InputFile::create($path . $newName),
                    "parse_mode" => "HTML",
                ]);

        }

        Storage::delete($excelFileName);
        // Storage::delete($path . $newName);

        return response()->download(storage_path('app/' . $newName));

    }


    public function contractProcessing(Request $request)
    {
        $request->validate([
            "contract_number" => "required",
            "id" => "required",

        ]);

        $workWithNds = $request->work_with_nds ?? 1;

        $order = Order::query()
            ->find($request->id);

        if (is_null($order))
            throw  new HttpException( 404, "Заказ не найден в системе");

        $order->contract_number = $request->contract_number ?? null;
        $order->save();


        $client = Client::query()->find($order->client_id);

        if (is_null($client))
            throw new HttpException(404, "Клиент не найден в системе");

        $path = storage_path() . "/app";

        $fileName = $workWithNds == 1 ? "договор с ООО.docx" : "договор с ИП.docx";
        $statusClient = $client->getShortClientStatus();


        $newName = "/договор с клиентом №" . $client->id . " " . ($statusClient) . " от" . (Carbon::now()->format('Y-m-d h-i-s')) . ".docx";

        $work_days = ($order->work_days ?? 7);
        $work_days_string = $work_days . "(" . (new MessageFormatter('ru-RU', '{n, spellout}'))->format(['n' => $work_days]) . ")";

        $nc = new NCLNameCaseRu();
        $member = $nc->q($client->fio, NCLNameCaseRu::$RODITLN);

        $buyerData = $client->getBueryData();

        $passport = $client->client_data["passport"] ?? '';
        $passport_issued = $client->client_data["passport_issued"] ?? '';

        if (file_exists($path . "/$fileName")) {
            try {
                $templateProcessor = new TemplateProcessor($path . "/$fileName");
                $templateProcessor->setValue('date_doc', Carbon::now()->format('d-m-Y'));
                $templateProcessor->setValue('numb_doc', $order->contract_number);
                $templateProcessor->setValue('title', $client->name);
                $templateProcessor->setValue('member', $member ?? '-');
                $templateProcessor->setValue('fio', $fam_initial ?? '-');
                $templateProcessor->setValue('email', $client->email);
                $templateProcessor->setValue('phone', $client->phone);
                $templateProcessor->setValue('fact_address', $client->fact_address ?? '-');
                $templateProcessor->setValue('law_address', $client->law_address ?? '-');
                $templateProcessor->setValue('inn', $client->inn ?? '-');
                $templateProcessor->setValue('ogrn', $client->ogrn ?? '-');
                $templateProcessor->setValue('kpp', $client->kpp ?? '-');
                $templateProcessor->setValue('okpo', $client->okpo ?? '-');

                $templateProcessor->setValue('order_id', $order->id);
                $templateProcessor->setValue('info', $order->info ?? '');
                $templateProcessor->setValue('total_price', $order->total_price ?? '');
                $templateProcessor->setValue('total_count', $order->total_count ?? '');
                $templateProcessor->setValue('current_payed', $order->current_payed ?? '');
                $templateProcessor->setValue('payed_percent', $order->payed_percent ?? '');
                $templateProcessor->setValue('last_payment', floatval($order->total_price ?? 0) - floatval($order->current_payed ?? 0));
                $templateProcessor->setValue('delivery_terms', $order->delivery_terms ?? '');
                $templateProcessor->setValue('work_days', $work_days_string);

                // requisites
                $templateProcessor->setValue('bik', $buyerData["buyer_bank_bic"]);
                $templateProcessor->setValue('ksch', $buyerData["buyer_correspondent_account"]);
                $templateProcessor->setValue('rsch', $buyerData["buyer_checking_account"]);
                $templateProcessor->setValue('bank_name', $buyerData["buyer_bank_name"]);
                $templateProcessor->setValue('passport', $passport);
                $templateProcessor->setValue('passport_issued', $passport_issued);

                $doc = new DocumentLogic();
                $sellerParams = $doc->getAllSellerParameters($workWithNds);

                foreach ($sellerParams as $key => $value)
                    $templateProcessor->setValue($key, $value);

                $templateProcessor->saveAs($path . $newName);


                $bitrix = new \App\Services\BitrixService();
                $r = $bitrix->addDocumentToLead($order->bitrix24_lead_id, $newName, base64_encode(file_get_contents($path . $newName)), env('DOCUMENT_FILED_CODE_CONTRACT'));


                // $bitrixFiles[] = ["name" => $newName, "path" => base64_encode(file_get_contents($path . $newName))];

            } catch (CopyFileException $e) {

            } catch (CreateTemporaryFileException $e) {

            }


        }

        return response()->noContent();
    }
}
