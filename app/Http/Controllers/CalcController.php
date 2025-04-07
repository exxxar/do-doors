<?php

namespace App\Http\Controllers;

use App\Classes\DocumentLogic;
use App\Enums\OrderStatusEnum;
use App\Exports\Cart\MultiSheetsCartExport;
use App\Exports\CartExport;
use App\Mail\KPMail;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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


    public function webhookDealHandler(Request $request)
    {
        Log::info("test");
        Log::info("request=>" . print_r($request->all(), true));
        $id = $request->all()["data"]["FIELDS"]["ID"] ?? null;

        $bitrix = new \App\Services\BitrixService();

        Log::info("test id=>".print_r($id, true));

        if (is_null($id))
            return;

        $deal = $bitrix->getDeal($id)["result"] ?? null;

        if (is_null($deal))
            return;

        $leadData = [];


        if ($deal["STAGE_ID"] == env("BITRIX24_NEW_STAGE_ID")) {
            $order = Order::query()
                ->where("bitrix24_lead_id", $id)
                ->first();


            $contactId = $deal["CONTACT_ID"] ?? null;

            if (!is_null($contactId)) {
                $contact = $bitrix->getContact($contactId)["result"];

                $phone = $contact["PHONE"][0]["value"] ?? null;

                $email = $contact["EMAIL"][0]["value"] ?? null;

                $comment = $contact["COMMENTS"] ?? null;

                $name = ($contact["LAST_NAME"] ?? "") . " " . ($contact["NAME"] ?? "") . " " . ($contact["SECOND_NAME"] ?? "");

                $client = Client::query()
                    ->where("phone", $phone)
                    ->first();

                if (is_null($client))
                    $client = Client::query()->create([
                        'status' => "new_client",
                        'phone' => $phone,
                        'email' => $email ?? null,
                        'user_id' => null,
                        'title' => $name,
                    ]);
            }

            if (is_null($order))
                $order = Order::query()->create([
                    'contract_number' => null,
                    'contract_date' => Carbon::now(),
                    'completion_at' => null,
                    'client_id' => $client->id ?? null,
                    'status' => OrderStatusEnum::NewOrder,
                    'source' => "crm",
                    'contact_person' => $name ?? '-',
                    'phone' => $phone ?? '-',
                    'organizational_form' => $client->status ?? 'new_client',
                    'contract_amount' => 0,
                    'work_days' => 0,
                    'paid' => 0,
                    'debt' => 0,
                    'profit' => 0,
                    'bitrix24_lead_id' => $id,
                    'delivery_terms' => null,
                    'info' => $comment ?? '',
                    'total_price' => 0,
                    'total_count' => 0,
                    'current_payed' => 0,
                    'payed_percent' => 0,

                ]);

            $leadData["UF_CRM_1742035413778"] = env("APP_URL") . "/link/" . $order->id;

        }

        //прошла оплата
        if ($deal["STAGE_ID"] == env("BITRIX24_PAYMENT_STAGE_ID")) {
            $order = Order::query()
                ->where("bitrix24_lead_id", $id)
                ->first();

            $workDays = $order->work_days ?? 0;
            $deliveryTerms = $order->delivery_terms ?? '';

            $leadData["UF_CRM_1733302582"] = (strlen($deliveryTerms) > 3 ? Carbon::parse($deliveryTerms) :
                Carbon::now()->addDays($workDays ?? 7))->format('d.m.Y'); //Предпологаемая дата сдачи, срок изготовления

        }

        if ($deal["STAGE_ID"] == env("BITRIX24_CONTRACT_SPECIFICATION_STAGE_ID")) {
            $order = Order::query()
                ->where("bitrix24_lead_id", $id)
                ->first();

            $leadData["UF_CRM_1733302797738"] = $order->id ?? '';
        }

        $deal = $bitrix->updateDeal($id, $leadData);


    }

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

        $action = explode(",", $request->action ?? '0'); //0 - отправить в crm, 1 - отправить кп на почту клиента, 2 - отправить кп в телеграм, 3 - сохранить


        $currentPayed = $request->current_payed ?? 0;
        $payedPercent = $request->payed_percent ?? 0;
        $payedPercentType = $request->payed_percent_type ?? 0;
        $ascentFloor = ($request->ascent_floor ?? false) == "true";
        $deliveryTerms = $request->delivery_terms ?? null;
        $deliveryType = $request->delivery_type ?? 0;

        $designer = json_decode($request->designer ?? '[]');
        $installation = json_decode($request->installation ?? '[]');

        $designerWorkType = ($designer->is_fix ?? false) == "true" ? 1 : 0;
        $designerValue = $designer->value ?? 0;
        $designerPrice = $designer->price ?? 0;
        $installPrice = $installation->price ?? 0;
        $installCount = $installation->count ?? 0;
        $installRecountType = $installation->recount_type ?? 0;
        $needInstall = ($installation->need_door_install ?? false) == true;


        $workWithNds = $request->work_with_nds ?? 1;

        $clientId = $request->id ?? null;

        $name = $request->name;
        $email = $request->email ?? 'не указано';
        $phone = $request->phone;
        $passport = $request->passport ?? 'не указано';
        $work_days = $request->work_days ?? 0;
        $passport_issued = $request->passport_issued ?? 'не указано';
        $info = $request->info ?? 'не указан';
        $totalPrice = $request->total_price ?? 0;
        $totalCount = $request->total_count ?? 1;
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

        if (in_array(0, $action) && !in_array(3, $action)) {
            $bitrix = new \App\Services\BitrixService();
            $contactData = [
                'NAME' => $client->getFName() ?? $name,
                'SECOND_NAME' => $client->getSName() ?? '',
                'LAST_NAME' => $client->getLName() ?? '',
                'TYPE_ID' => "CLIENT",
                'PHONE' => [['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']],
                'EMAIL' => [['VALUE' => $email, 'VALUE_TYPE' => 'WORK']]
            ];

            $contact = $bitrix->upsertContact($contactData);

            Log::info("contact=>" . print_r($contact, true));

            $leadData = $client->getBitrix24DealData();
            $leadData["TITLE"] = $name;
            if (isset($contact["result"]))
                $leadData["CONTACT_IDS"] = [$contact["result"]];
            $leadData["COMMENTS"] = $info;
            $leadData["UF_CRM_1733302797738"] = 'Еще не указан';//$order->id;
            $leadData["TYPE_ID"] = [93, 93, 91][$workWithNds]; //91 - физ, 93 - юр, 95 - дилер, 97 - дистребьютор, 99 - Юр. лицо, дистрибьютор и менеджер
            $leadData["UF_CRM_1733302313"] = [47, 45, 49][$payedPercentType ?? 1]; //45 - 70\30, 47 - 50 \ 50, 49 - 100% предоплата
            $leadData["UF_CRM_1733302527"] = $ascentFloor ? 59 : 61; //59 - нужен, 61 - не нужен
            $leadData["UF_CRM_1733302565"] = ($request->delivery_city ?? '') . ', ' . ($request->delivery_address ?? '');
            /*     $leadData["UF_CRM_1733302582"] = (strlen($deliveryTerms) > 3 ? Carbon::parse($deliveryTerms) :
                     Carbon::now()->addDays($request->work_days ?? 7))->format('d.m.Y'); //Предпологаемая дата сдачи, срок изготовления*/
            $leadData["UF_CRM_1733302597"] = Carbon::now()->addDays(5)->format('d.m.Y');//Срок актуальности КП
            $leadData["UF_CRM_1733302818544"] = Carbon::now()->format('d.m.Y');//Дата договора
            $leadData["UF_CRM_1733302846046"] = [65, 63, 155][$workWithNds];//ООО - 63 ИП - 65 ФИЗ - 155
            $leadData["UF_CRM_1733302866734"] = $request->delivery_city ?? '-';
            $leadData["UF_CRM_1733302493"] = [51, 53, 55, 57][$deliveryType]; //51 - доставка до адреса, 53 - самовывоз, 55 - тк, 57 - доставка до проходной
            $leadData["UF_CRM_1733302917133"] = $currentPayed;//Аванс, руб
            $leadData["UF_CRM_1733302937139"] = $totalPrice;//Окончательны платеж, руб.
            $leadData["UF_CRM_1733302958322"] = $totalPrice - $currentPayed;//Долг, руб.
            $leadData["UF_CRM_1733302997393"] = 0.0; //мотивация менеджера
            $leadData["UF_CRM_1733305761683"] = $request->delivery_price ?? 0;
            $leadData["UF_CRM_1742035413778"] = env("APP_URL") . "/link/" . $order->id;

            $leadData["UF_CRM_1742976788"] = [2125, 2125, 2123][$workWithNds]; //Организация 2123 - дудорс ооо, 2125 - ИП

            $leadData["UF_CRM_1733303016351"] = 0;//Прибыль, руб.
            $leadData["UF_CRM_1733306662836"] = 0;//Комиссия менеджеру-партнеру, руб.
            $leadData["UF_CRM_1733306683779"] = $designerWorkType ? $designerValue : $designerPrice;;//Комиссия дизайнеру, руб.
            $leadData["UF_CRM_1733306708610"] = $designerWorkType ? 0 : $designerValue;//Процент дизайнера, %
            $leadData["UF_CRM_1733310041523"] = 0;//Сумма рекламации, руб.
            /*
                        $leadData["UF_CRM_674F4188D6C91"] = "UF_CRM_674F4188D6C91";
                        $leadData["UF_CRM_674F4188DC365"] = "UF_CRM_674F4188DC365";
                        $leadData["UF_CRM_674F4188E087D"] = "UF_CRM_674F4188E087D";
                        $leadData["UF_CRM_674F4188E5672"] = "UF_CRM_674F4188E5672";
                        $leadData["UF_CRM_674F4188EB8BC"] = "UF_CRM_674F4188EB8BC";
                        $leadData["UF_CRM_1733304526"] = "UF_CRM_1733304526"; //имя и контакт водителя
                        $leadData["UF_CRM_1733309976"] = "UF_CRM_1733309976"; //ПРИЧИНА рекламаци
                        $leadData["UF_CRM_67934C319A189"] = "UF_CRM_67934C319A189";
                        $leadData["UF_CRM_67934C31A75C8"] = "UF_CRM_67934C31A75C8";
                        $leadData["UF_CRM_67934C31CD377"] = "UF_CRM_67934C31CD377";
                        $leadData["UF_CRM_67934C31D5CB7"] = "UF_CRM_67934C31D5CB7";
                        $leadData["UF_CRM_67934C31DC8FA"] = "UF_CRM_67934C31DC8FA";
                        $leadData["UF_CRM_1738691309292"] = "UF_CRM_1738691309292";//замерщик установщик
                        $leadData["UF_CRM_67D21B6040E41"] = "UF_CRM_67D21B6040E41";
                        $leadData["UF_CRM_67DCECB80FA2A"] = "UF_CRM_67DCECB80FA2A";
                        $leadData["UF_CRM_67DCECB81ECA5"] = "UF_CRM_67DCECB81ECA5";
                        $leadData["UF_CRM_67DCECB82B021"] = "UF_CRM_67DCECB82B021";
                        $leadData["UF_CRM_67DCECB837CC6"] = "UF_CRM_67DCECB837CC6";
                        $leadData["UF_CRM_67DCECB840804"] = "UF_CRM_67DCECB840804";
                        $leadData["UF_CRM_67DCECB8499AB"] = "UF_CRM_67DCECB8499AB";*/

            $deal = $bitrix->createDeal($leadData);

            $leadId = $deal["result"] ?? null;

            $order->bitrix24_lead_id = $leadId;
            $order->save();
        }

        $productsForBitrix = [];
        foreach ($items as $item) {

            /*    $bitrixProductTitle = sprintf(
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
                );*/

            $shorts = ['Комплект двери скрытого монтажа' => 'КДС'];
            $doorDescription = "DoDoors: " . (in_array($item->product->door_type->title, $shorts) ? $shorts[$item->product->door_type->title] : ($item->product->door_type->title ?? 'КДС')) . " " .
                (($item->product->need_upper_jumper ?? false) == "true" ? '' : 'без верх. перемычки ') .
                ($item->product->height ?? 0) . "х" . ($item->product->width ?? 0) . ", " .
                "открывание " . ($item->product->opening_type->title ?? 'не указано') . ", " .
                "петли " . ($item->product->loops->title ?? 'не указано') . ". " .
                ($item->product->front_side_finish_color->title ?? 'Грунт') . "/" .
                ($item->product->back_side_finish_color->title ?? 'Грунт') . ". " .
                "Цвет короба и полотна: " . ($item->product->box_and_frame_color->title ?? 'не указано') . ". " .
                "Цвет фурнитуры: " . ($item->product->fittings_color->title ?? 'не указано') . ". " .
                "Толщина профиля " . ($item->product->depth ?? 'не указано') . " мм. " .
                (($item->product->need_automatic_doorstep ?? false) == "true" ? 'Автоматический порог ' : '') .
                (($item->product->need_hidden_stopper ?? false) == "true" ? 'Скрытый стопор ' : '') .
                (($item->product->need_hidden_door_closer ?? false) == "true" ? 'Скрытый доводчик ' : '') .
                (($item->product->need_hidden_skirting_board ?? false) == "true" ? 'Скрытый плинтус ' : '') .
                (($item->product->need_door_install ?? false) == "true" ? 'Установка двери ' : '') .
                (($item->product->need_handle_holes ?? false) == "true" ? 'Ручка в комплекте ' : '');

            $productData = [
                'NAME' => $doorDescription,
                'CURRENCY_ID' => 'RUB',
                'PRICE' => $item->product->price ?? 0,
                'DESCRIPTION' => $doorDescription,
                'MEASURE' => 6,
                'QUANTITY' => $item->product->count ?? 1 // Единица измерения (шт.)
            ];

            $bitrixProductId = $bitrix->addProduct($productData)["result"] ?? null;

            OrderDetail::query()->create([
                'order_id' => $order->id,
                'door_type' => $item->product->title ?? null,
                'count' => $item->product->count ?? 1,
                'price' => $item->product->price ?? 0,
                'comment' => $item->product->comment ?? null,
                'purpose' => $item->product->purpose ?? null,
                'door' => $item->product,
                'bitrix24_product_id' => $bitrixProductId
            ]);

            $productsForBitrix[] = [
                "PRODUCT_ID" => $bitrixProductId,
                "PRICE" => $item->product->price ?? 0,
                "QUANTITY" => $item->product->count ?? 1,
            ];

        }

        if ($needInstall) {
            $installDoorsData = [
                'NAME' => "Установка комплекта дверей: " . ($installRecountType == 0 ? "суммарно за все двери ($installCount)" : "цена за установку одной двери"),
                'CURRENCY_ID' => 'RUB',
                'PRICE' => $installPrice,
                'DESCRIPTION' => $installRecountType == 0 ? "Суммарно за все двери ($installCount)" : "Цена за установку одной двери",
                'MEASURE' => 0,
                'QUANTITY' => $installRecountType == 0 ? 1 : $installCount
            ];

            $bitrixProductId = $bitrix->addProduct($installDoorsData)["result"] ?? null;

            $productsForBitrix[] = [
                "PRODUCT_ID" => $bitrixProductId,
                "PRICE" => $installPrice,
                "QUANTITY" => $installRecountType == 0 ? 1 : $installCount,
            ];
        }

        if (($request->delivery_type ?? 0) == 0) {
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

        if (in_array(0, $action) && !in_array(3, $action)) {
            $result = $bitrix->addProductToDeal($leadId, $productsForBitrix);
        }


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


        Excel::store(new MultiSheetsCartExport($items, $buyerData, true), $excelFileName);

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


        if (in_array(0, $action) && !in_array(3, $action))
            $R = $bitrix->addDocumentsToDeal($leadId, $bitrixFiles, env('DOCUMENT_FILED_CODE_SPECIFICATION'));

        if (in_array(2, $action) && !in_array(3, $action)) {

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

        if (in_array(1, $action) && !in_array(3, $action)) {
            $attachments = [
                $path . $newName,
                storage_path('app/' . $newName),
                Storage::get("$excelFileName"),
            ];

            Mail::to($email)->send(new KPMail($name, $attachments));
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
            throw  new HttpException(404, "Заказ не найден в системе");

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

        $buyerData = $client->getBueryData();

        $passport = $client->client_data["passport"] ?? '';
        $passport_issued = $client->client_data["passport_issued"] ?? '';

        if (file_exists($path . "/$fileName")) {
            try {
                $templateProcessor = new TemplateProcessor($path . "/$fileName");
                $templateProcessor->setValue('date_doc', Carbon::now()->format('d-m-Y'));
                $templateProcessor->setValue('numb_doc', $order->contract_number);
                $templateProcessor->setValue('title', $client->name);
                $templateProcessor->setValue('member', $client->fio ?? '-');
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
                $deal["UF_CRM_1733302797738"] = $order->contract_number;
                $bitrix->updateDeal($order->bitrix24_lead_id, $deal);
                $r = $bitrix->addDocumentToDeal($order->bitrix24_lead_id, $newName, base64_encode(file_get_contents($path . $newName)), env('DOCUMENT_FILED_CODE_CONTRACT'));


                // $bitrixFiles[] = ["name" => $newName, "path" => base64_encode(file_get_contents($path . $newName))];

            } catch (CopyFileException $e) {

            } catch (CreateTemporaryFileException $e) {

            }


        }

        return response()->noContent();
    }
}
