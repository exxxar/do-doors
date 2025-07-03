<?php

namespace App\Http\Controllers;

use App\Classes\DocumentLogic;
use App\Enums\OrderStatusEnum;
use App\Exports\Cart\MultiSheetsCartExport;
use App\Exports\CommercialProposal\MultiSheetsCart2Export;
use App\Exports\OrderExport;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Mail\KPMail;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use MessageFormatter;
use Mpdf\Mpdf;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;

class OrderController extends Controller
{
    use Utility;

    /**
     * @throws \HttpException
     */
    protected function preparedOrderData($orderId, $config = [])
    {

        $sendToBitrix = $config["send_to_bitrix"] ?? false;
        $sendToMail = $config["send_to_email"] ?? false;
        $sendToTelegram = $config["send_to_telegram"] ?? false;

        $order = Order::query()
            ->with(["details"])
            ->find($orderId);

        if (is_null($order))
            throw new \HttpException("Заказ не найден", 404);

        $client = $order->client ?? null;
        $buyerData = !is_null($client) ? $client->getBuyerData() : [];

        $leadId = $order->bitrix24_lead_id ?? null;

        $info = $order->info ?? '';
        $workWithNds = $order->config["work_with_nds"] ?? $client->status ?? 1;
        $payedPercentType = $order->config["payed_percent_type"] ?? 2;
        $ascentFloor = $order->config["ascent_floor"] ?? 0;
        $deliveryType = $order->config["delivery_type"] ?? 0;
        $designerWorkType = $order->config["designer_work_type"] ?? 0;
        $designerValue = $order->config["designer_value"] ?? 0;
        $designerPrice = $order->config["designer_price"] ?? 0;
        $needInstall = $order->config["need_install"] ?? false;
        $installRecountType = $order->config["install_recount_type"] ?? 0;
        $deliveryPrice = $order->config["delivery_price"] ?? 0;;
        $deliveryCity = $order->config["delivery_city"] ?? '';
        $deliveryAddress = $order->config["delivery_address"] ?? '';
        $installPrice = $order->config["install_price"] ?? 0;

        $currentPayed = $order->current_payed ?? 0;
        $totalPrice = $order->total_price ?? 0;
        $totalCount = $order->total_count ?? 0;
        $installCount = $totalCount;

        $name = $client->fio ?? $client->title ?? 'Без названия';
        $phone = $client->phone ?? null;
        $email = $client->email ?? null;


        $contactData = [
            'NAME' => $client->title,
            'TYPE_ID' => 'CLIENT',
            'PHONE' => [['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']],
            'EMAIL' => [['VALUE' => $email !== 'не указано' ? $email : '', 'VALUE_TYPE' => 'WORK']],
        ];

        $bitrix = new \App\Services\BitrixService();

        if ($sendToBitrix) try {
            $contact = $bitrix->upsertContact($contactData);
        } catch (Exception $e) {
            Log::error('Bitrix contact creation failed: ' . $e->getMessage());
        }

        $leadData = $client->getBitrix24DealData();
        $leadData = array_merge($leadData, [
            'TITLE' => $name,
            'CONTACT_IDS' => !empty($contact['result']) ? [$contact['result']] : [],
            'COMMENTS' => $info,
            'UF_CRM_1733302797738' => $order->id,
            'TYPE_ID' => [93, 93, 91][$workWithNds] ?? 91,
            'UF_CRM_1733302313' => [47, 45, 49][$payedPercentType] ?? 49,
            'UF_CRM_1733302527' => $ascentFloor ? 59 : 61,
            'UF_CRM_1733302565' => $deliveryCity . ', ' . $deliveryAddress,
            'UF_CRM_1733302597' => Carbon::now()->addDays(5)->format('d.m.Y'),
            'UF_CRM_1733302818544' => Carbon::now()->format('d.m.Y'),
            'UF_CRM_1733302846046' => [65, 63, 155][$workWithNds] ?? 155,
            'UF_CRM_1733302866734' => $deliveryCity,
            'UF_CRM_1733302493' => [51, 53, 55, 57][$deliveryType] ?? 51,
            'UF_CRM_1733302917133' => $currentPayed,
            'UF_CRM_1733302937139' => $totalPrice,
            'UF_CRM_1733302958322' => $totalPrice - $currentPayed,
            'UF_CRM_1733302997393' => 0.0,
            'UF_CRM_1733305761683' => $deliveryPrice,
            'UF_CRM_1742035413778' => env('APP_URL') . '/link/' . $order->id,
            'UF_CRM_1742976788' => [2125, 2125, 2123][$workWithNds] ?? 2123,
            'UF_CRM_1733303016351' => 0,
            'UF_CRM_1733306662836' => 0,
            'UF_CRM_1733306683779' => $designerWorkType ? $designerValue : $designerPrice,
            'UF_CRM_1733306708610' => $designerWorkType ? 0 : $designerValue,
            'UF_CRM_1733310041523' => 0,
        ]);

        if ($sendToBitrix) try {
            $deal = $leadId ? $bitrix->updateDeal($leadId, $leadData) : $bitrix->createDeal($leadData);
            $leadId = $deal['result'] ?? null;
            if ($leadId) {
                $order->bitrix24_lead_id = $leadId;
                $order->save();
            }
        } catch (Exception $e) {
            Log::error('Bitrix deal operation failed: ' . $e->getMessage());
        }

        // Process items for Bitrix
        $productsForBitrix = [];
        $otherProducts = [];

        $items = $order->details ?? [];

        foreach ($items as $item) {

            $product = $item->door ?? null;
            if (is_null($product))
                continue;

            $product = json_decode(json_encode($product));

            $priceType = $product->price_type->key ?? 'retail';

            $shorts = ['Комплект двери скрытого монтажа' => 'КДС'];
            $doorDescription = sprintf(
                'DoDoors: %s %s%dx%d, открывание %s, петли %s. %s %s/%s %s. Цвет короба и полотна: %s. Цвет фурнитуры: %s. Толщина профиля %s мм. %s%s%s%s',
                $shorts[$product->door_type->title ?? null] ?? ($product->door_type->title ?? 'КДС'),
                filter_var($product->need_upper_jumper ?? false, FILTER_VALIDATE_BOOLEAN) ? '' : 'без верх. перемычки ',
                $product->height ?? 0,
                $product->width ?? 0,
                $product->opening_type->title ?? 'не указано',
                $product->loops->title ?? 'не указано',
                $product->front_side_finish->title ?? 'материал',
                $product->front_side_finish_color->title ?? 'Грунт',
                $product->back_side_finish->title ?? 'материал',
                $product->back_side_finish_color->title ?? 'Грунт',
                $product->box_and_frame_color->title ?? 'не указано',
                $product->fittings_color->title ?? 'не указано',
                $product->depth ?? 'не указано',
                filter_var($product->need_automatic_doorstep ?? false, FILTER_VALIDATE_BOOLEAN) ? 'Автоматический порог ' : '',
                filter_var($product->need_hidden_stopper ?? false, FILTER_VALIDATE_BOOLEAN) ? 'Скрытый стопор ' : '',
                filter_var($product->need_hidden_door_closer ?? false, FILTER_VALIDATE_BOOLEAN) ? 'Скрытый доводчик ' : '',
                filter_var($product->need_hidden_skirting_board ?? false, FILTER_VALIDATE_BOOLEAN) ? 'Скрытый плинтус ' : ''
            );

            $productData = [
                'NAME' => $doorDescription,
                'CURRENCY_ID' => 'RUB',
                'PRICE' => (float)($product->price ?? 0),
                'DESCRIPTION' => $doorDescription . '. Комментарий к двери: ' . ($product->comment ?? '-'),
                'MEASURE' => 6,
                'QUANTITY' => (int)($product->count ?? 1),
            ];

            try {

                $bitrixProductId = $sendToBitrix ? $bitrix->addProduct($productData)['result'] ?? null : null;

                if (!is_null($bitrixProductId)) {
                    $productsForBitrix[] = [
                        'PRODUCT_ID' => $bitrixProductId,
                        'PRICE' => (float)($product->price ?? 0),
                        'QUANTITY' => (int)($product->count ?? 1),
                    ];
                }
            } catch (Exception $e) {
                Log::error('Failed to add product to Bitrix: ' . $e->getMessage());
            }

            // Handle door handles
            if (!is_null($product->handle_holes_type ?? null)) try {
                $handle = (object)$product->handle_holes_type;
                $price = (array)($handle->price ?? []);
                $installDoorsData = [
                    'NAME' => 'Ручка: ' . ($handle->title ?? '-'),
                    'CURRENCY_ID' => 'RUB',
                    'PRICE' => (float)($price[$priceType] ?? 0),
                    'DESCRIPTION' => 'Цена комплекта ручек у поставщика',
                    'MEASURE' => 0,
                    'QUANTITY' => (int)($product->count ?? 1),
                ];
                $bitrixProductId = $bitrix->addProduct($installDoorsData)['result'] ?? null;
                if ($bitrixProductId) {
                    $productsForBitrix[] = [
                        'PRODUCT_ID' => $bitrixProductId,
                        'PRICE' => (float)($price[$priceType] ?? 0),
                        'QUANTITY' => (int)($product->count ?? 1),
                    ];

                    $otherProducts[] = (object)[
                        'title' => 'Ручка: ' . ($handle->title ?? '-'),
                        'description' => 'Цена комплекта ручек у поставщика',
                        'price' => (float)($price[$priceType] ?? 0),
                        'count' => (int)($product->count ?? 1),
                    ];
                }
            } catch (Exception $e) {
                Log::error('Failed to add handle product to Bitrix: ' . $e->getMessage());
            }

            // Handle wrappers
            if (!is_null($product->handle_wrapper_type ?? null)) try {
                $wrapper = (object)$product->handle_wrapper_type;
                $price = (array)($wrapper->price ?? []);
                $handleDoorsData = [
                    'NAME' => 'Завертка: ' . ($wrapper->title ?? '-'),
                    'CURRENCY_ID' => 'RUB',
                    'PRICE' => (float)($price[$priceType] ?? 0),
                    'DESCRIPTION' => 'Цена завертки поставщика',
                    'MEASURE' => 0,
                    'QUANTITY' => (int)($product->count ?? 1),
                ];

                $otherProducts[] = (object)[
                    'title' => 'Завертка: ' . ($wrapper->title ?? '-'),
                    'description' => 'Цена завертки поставщика',
                    'price' => (float)($price[$priceType] ?? 0),
                    'count' => (int)($product->count ?? 1),
                ];

                $bitrixProductId = $sendToBitrix ? $bitrix->addProduct($handleDoorsData)['result'] ?? null : null;

                if (!is_null($bitrixProductId)) {
                    $productsForBitrix[] = [
                        'PRODUCT_ID' => $bitrixProductId,
                        'PRICE' => (float)($price[$priceType] ?? 0),
                        'QUANTITY' => (int)($product->count ?? 1),
                    ];


                }
            } catch (Exception $e) {
                Log::error('Failed to add wrapper product to Bitrix: ' . $e->getMessage());
            }
        }


        if ($needInstall) try {

            $otherProducts[] = (object)[
                'title' => 'Установка комплекта дверей: ' . ($installRecountType == 0 ? "суммарно за все двери ($installCount)" : 'цена за установку одной двери'),
                'description' => $installRecountType == 0 ? "Суммарно за все двери ($installCount)" : 'Цена за установку одной двери',
                'price' => (float)$installPrice,
                'count' => $installRecountType == 0 ? 1 : $installCount,
            ];

            $handleInstallDoorsData = [
                'NAME' => 'Установка комплекта дверей: ' . ($installRecountType == 0 ? "суммарно за все двери ($installCount)" : 'цена за установку одной двери'),
                'CURRENCY_ID' => 'RUB',
                'PRICE' => (float)$installPrice,
                'DESCRIPTION' => $installRecountType == 0 ? "Суммарно за все двери ($installCount)" : 'Цена за установку одной двери',
                'MEASURE' => 0,
                'QUANTITY' => $installRecountType == 0 ? 1 : $installCount,
            ];


            $bitrixProductId = $sendToBitrix ? $bitrix->addProduct($handleInstallDoorsData)['result'] ?? null : null;

            if (!is_null($bitrixProductId)) {
                $productsForBitrix[] = [
                    'PRODUCT_ID' => $bitrixProductId,
                    'PRICE' => (float)$installPrice,
                    'QUANTITY' => $installRecountType == 0 ? 1 : $installCount,
                ];
            }


        } catch (Exception $e) {
            Log::error('Failed to add installation product to Bitrix: ' . $e->getMessage());
        }


        // Handle delivery
        if ($deliveryType == 0) try {

            $otherProducts[] = (object)[
                'title' => 'Доставка комплекта дверей ',
                'description' => $deliveryCity . ', ' . $deliveryAddress,
                'price' => $deliveryPrice,
                'count' => 1
            ];

            $deliveryProductData = [
                'NAME' => 'Доставка комплекта дверей',
                'CURRENCY_ID' => 'RUB',
                'PRICE' => $deliveryPrice,
                'DESCRIPTION' => $deliveryCity . ', ' . $deliveryAddress,
                'MEASURE' => 0,
                'QUANTITY' => 1,
            ];

            $bitrixProductId = $sendToBitrix ? $bitrix->addProduct($deliveryProductData)['result'] ?? null : null;

            if (!is_null($bitrixProductId)) {
                $productsForBitrix[] = [
                    'PRODUCT_ID' => $bitrixProductId,
                    'PRICE' => $deliveryPrice,
                    'QUANTITY' => 1,
                ];


            }
        } catch (Exception $e) {
            Log::error('Failed to add delivery product to Bitrix: ' . $e->getMessage());
        }


        $templateName = ["договор с ИП.docx", "договор с ООО.docx", "договор с ФЛ.docx"][$workWithNds] ?? "договор с ИП.docx";
        $statusClient = $client->getShortClientStatus();

        $newName = "/договор с клиентом №" . $client->id . " " . ($statusClient) . " от" . (Carbon::now()->format('Y-m-d h-i-s')) . ".docx";
        $famInitial = $client->status === 'individual' ? ($client->fio ?? "Клиент №{$client->id}") : ($client->title ?? "Клиент №{$client->id}");

        $buyerData["status"] = ['individual', 'legal_entity', 'phys'][$workWithNds] ?? 'individual';

        $data = [
            'date_doc' => Carbon::now()->format('d-m-Y'),
            'numb_doc' => $order->id,
            'member' => $client->fio ?? '-',
            'client_id' => $client->id,
            'title' => $client->title,
            'fio' => $client->fio,
            'statusClient' => $buyerData["status"],
            'order_id' => $order->id,
            'name' => 'значение name',
            'famInitial' => $famInitial, // Может быть null
            'email' => $client->email,
            'phone' => $client->phone,
            'fact_address' => $client->fact_address ?? null, // Может быть null
            'law_address' => $client->law_address ?? null, // Может быть null
            'inn' => $client->inn ?? null, // Может быть null
            'ogrn' => $client->ogrn ?? null, // Может быть null
            'kpp' => $client->kpp ?? null, // Может быть null
            'okpo' => $client->okpo ?? null, // Может быть null
            'info' => $order->info ?? null,
            'total_price' => $order->total_price ?? 0,
            'total_count' => $order->total_count ?? 0,
            'delivery' => ($order->config["delivery_type"] ?? 1) == 0 ? "входит" : "не входит",
            'install' => ($order->config["need_install"] ?? 1) == 1 ? "входит" : "не входит",
            'current_payed' => $order->current_payed ?? 0,
            'payed_percent' => $order->payed_percent ?? 0,
            'delivery_terms' => $order->delivery_terms ?? null, // Может быть null
            'workDays' => $order->work_days ?? 7,
            'buyerData' => [
                'buyer_bank_bic' => $buyerData['buyer_bank_bic'] ?? '-',
                'buyer_correspondent_account' => $buyerData['buyer_correspondent_account'] ?? '-',
                'buyer_checking_account' => $buyerData['buyer_checking_account'] ?? '-',
                'buyer_bank_name' => $buyerData['buyer_bank_name'] ?? '-',

            ],
            'passport' => $client->client_data["passport"] ?? '',
            'passport_issued' => $client->client_data["passport_issued"] ?? '',
            'workWithNds' => $workWithNds == 1,
        ];

        $fullPath = $this->generateContractDocument($templateName, $data);

        if ($sendToBitrix && $leadId) try {
            $deal["UF_CRM_1733302797738"] = $order->contract_number;
            $bitrix->updateDeal($order->bitrix24_lead_id, $deal);

            $bitrix->addProductToDeal($leadId, $productsForBitrix);
            $bitrix->addDocumentToDeal($leadId, $newName, base64_encode(file_get_contents($fullPath)), env('DOCUMENT_FILED_CODE_CONTRACT'));
        } catch (Exception $e) {
            Log::error('Failed to add products to deal: ' . $e->getMessage());
        }

        $timeFragment = Carbon::now('+3:00')->format('Y-m-d-H-i-s');
        // Generate PDF
        try {
            $mpdf = new Mpdf(['format' => 'A4-P']);
            $currentDate = Carbon::now('+3:00')->format('Y-m-d H:i:s');

            $mpdf->WriteHTML(view('pdf.order-v2', [
                'name' => $name,
                'order_id' => $order->id,
                'current_date' => $currentDate,
                'email' => $email,
                'phone' => $phone,
                'info' => $info,
                'total_price' => $totalPrice,
                'total_count' => $totalCount,
                'items' => $items,
            ]));

            $file = $mpdf->Output("order-$timeFragment.pdf", \Mpdf\Output\Destination::STRING_RETURN);
        } catch (Exception $e) {
            Log::error('PDF generation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }

        // Generate Excel files

        $excelFileName1 = "spec-$timeFragment.xls";
        $excelFileName2 = "cp-$timeFragment.xls";

        try {
            Excel::store(new MultiSheetsCartExport($items, $buyerData, $otherProducts, true), $excelFileName1);
            Excel::store(new MultiSheetsCart2Export($items, $buyerData, $otherProducts, true), $excelFileName2);
        } catch (Exception $e) {
            Log::error('Excel generation failed: ' . $e->getMessage());
        }

        $bitrixFiles = [
            [
                'name' => "спецификация от $timeFragment.xls",
                'path' => base64_encode(Storage::get($excelFileName1)),
            ],
            [
                'name' => "коммерческое предложение от $timeFragment.xls",
                'path' => base64_encode(Storage::get($excelFileName2)),
            ],
            [
                'name' => "информация о заказе от $timeFragment.pdf",
                'path' => base64_encode($file),
            ],
        ];

        if ($leadId && $sendToBitrix) try {
            $bitrix->addDocumentsToDeal($leadId, $bitrixFiles, env('DOCUMENT_FILED_CODE_SPECIFICATION'));
        } catch (Exception $e) {
            Log::error('Failed to upload documents to Bitrix: ' . $e->getMessage());
        }


        if ($sendToTelegram) {
            try {
                $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
                $telegram->sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID'),
                    'text' => "#заказ\nПоступил новый заказ!\n" .
                        "Имя клиента: $name\n" .
                        "E-mail: $email\n" .
                        "Телефон: $phone\n" .
                        "Доп.инфо: $info\n" .
                        "Общее кол-во товара: $totalCount ед.\n" .
                        "Цена товара: $totalPrice руб.\n",
                    'parse_mode' => 'HTML',
                ]);

                sleep(1);
                $telegram->sendDocument([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID'),
                    'document' => InputFile::createFromContents(Storage::get($excelFileName1), $excelFileName1),
                    'parse_mode' => 'HTML',
                ]);
                sleep(1);
                $telegram->sendDocument([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID'),
                    'document' => InputFile::createFromContents(Storage::get($excelFileName2), $excelFileName2),
                    'parse_mode' => 'HTML',
                ]);
                sleep(1);
                $telegram->sendDocument([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID'),
                    'document' => InputFile::createFromContents($file, "order-$timeFragment.pdf"),
                    'parse_mode' => 'HTML',
                ]);
                sleep(1);
                if (file_exists($fullPath)) {
                    $telegram->sendDocument([
                        'chat_id' => env('TELEGRAM_CHANNEL_ID'),
                        'document' => InputFile::create($fullPath),
                        'parse_mode' => 'HTML',
                    ]);
                }
            } catch (Exception $e) {
                Log::error('Telegram notification failed: ' . $e->getMessage());
            }
        }


        // Send email


        try {
            $attachments = [
                storage_path("app/$excelFileName1"),
                storage_path("app/$excelFileName2"),
            ];

            if ($sendToMail)
                Mail::to($email)
                    ->send(new KPMail($name, $attachments));


        } catch (Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
        }


        // Clean up
        Storage::delete([$excelFileName1, $excelFileName2]);
    }

    /**
     * @throws \HttpException
     */
    public function sendToBitrix(Request $request)
    {
        $request->validate([
            "order_id" => "required",
        ]);

        $sendToBitrix = $request->send_to_bitrix ?? false;
        $sendToTelegram = $request->send_to_telegram ?? false;
        $sendToMail = $request->send_to_email ?? false;

        $this->preparedOrderData($request->order_id, [
            "send_to_bitrix" => $sendToBitrix,
            "send_to_email" => $sendToMail,
            "send_to_telegram" => $sendToTelegram,
        ]);

        return response()->json(['message' => 'Order processed successfully'], 200);
    }

    /**
     * @throws \HttpException
     */
    public function editOrderInBitrix(Request $request)
    {
        $request->validate([
            "id" => "required",
        ]);

        $orderId = $request->id;

        $sendToBitrix = $request->send_to_bitrix ?? false;
        $sendToTelegram = $request->send_to_telegram ?? false;
        $sendToMail = $request->send_to_email ?? false;

        $order = Order::query()
            ->with(["details"])
            ->find($orderId);

        $client = $order->client ?? null;
        $config = $order->config ?? [];

        $phone = $request->phone ?? $client->phone ?? null;
        $name = $request->name ?? $client->fio ?? null;
        $totalPrice = $request->total_price ?? $order->total_price ?? 0;
        $totalCount = $request->total_count ?? $order->total_count ?? 0;
        $payedPercent= $request->payed_percent ?? $order->payed_percent ?? 0;
        $currentPayed= $request->current_payed ?? $order->current_payed ?? 0;

        $workDays = $request->work_days ?? $order->work_days ?? 1;
        $deliveryTerms = $request->delivery_terms ?? $order->delivery_terms ?? null;
        $info = $request->info ?? $order->info ?? null;

        $deliveryType= $request->delivery_type ?? $order->config["delivery_type"] ?? 0;
        $deliveryCity= $request->delivery_city ?? $order->config["delivery_city"] ?? '';
        $deliveryAddress= $request->delivery_address ?? $order->config["delivery_address"] ?? '';
        $deliveryPrice= $request->delivery_price ?? $order->config["delivery_price"] ?? 0;
        $ascentFloor= $request->ascent_floor ?? $order->config["ascent_floor"] ?? '';
        $payedPercentType= $request->payed_percent_type ?? $order->config["payed_percent_type"] ?? 1;
        $workWithNds= $request->work_with_nds ?? $order->config["work_with_nds"] ?? 0;

        $installation = json_decode($request->installation??'[]');
        $needInstall= $installation->need_door_install ?? $order->config["need_install"] ?? false;
        $installPrice = $installation->price ?? $order->config["install_price"] ?? 0;
        $installRecountType = $installation->recount_type ?? $order->config["recount_type"] ?? 0;

        $designer = json_decode($request->designer??'[]');
        $designerWorkType= $designer->is_fix  ?? $order->config["designer_work_type"] ?? 1;
        $designerValue= $designer->designer_value ?? $order->config["designer_value"] ?? 0;
        $designerPrice= $designer->designer_price ?? $order->config["designer_price"] ?? 0;

        $discountData = json_decode($request->discount_data??'[]');
        $discountValue = $discountData->discount_value ?? 0;
        $discountPercent = $discountData->discount_percent ?? 0;

        $tmpData = [
            'contract_date' => Carbon::now(),
            'contact_person' => $name,
            'phone' => $phone,
            'organizational_form' => $client->status ?? 'new_client',
            'contract_amount' => $totalPrice,
            'work_days' => $workDays,
            'delivery_terms' => $deliveryTerms,
            'info' => $info,
            'total_price' => $totalPrice,
            'total_count' => $totalCount,
            'current_payed' => $currentPayed,
            'payed_percent' => $payedPercent,
            'config' => (object)[
                "delivery_type" => $deliveryType == 0 ? 0 : 1,
                "delivery_city" => $deliveryCity,
                "delivery_address" => $deliveryAddress,
                "need_install" => $needInstall ? 1 : 0,
                "work_with_nds" => $workWithNds,
                "payed_percent_type" => $payedPercentType,
                "ascent_floor" => $ascentFloor,
                "designer_work_type" => $designerWorkType ?? 1,
                "designer_value" => $designerValue ?? 0,
                "designer_price" => $designerPrice ?? 0,
                "install_recount_type" => $installRecountType ?? 0,
                "delivery_price" => $deliveryPrice,
                "install_price" => $installPrice ?? 0,
            ],
            'discount' => (object)[
                'amount' => $discountValue,
                'percent' => $discountPercent
            ]
        ];

        $order->update($tmpData);

        $items = json_decode($request->items ?? '[]');
        foreach ($items as $item) {

            $id = $item->id ?? null;

            $tmp = [
                'order_id' => $order->id,
                'door_type' => $item->door_type ?? null,
                'count' => (int)($product->count ?? 1),
                'price' => (float)($product->price ?? 0),
                'comment' => $product->comment ?? null,
                'purpose' => $product->purpose ?? null,
                'door' => $item['product'],
                ];

            $detail = OrderDetail::query()
                ->find($id);

            if (is_null($detail))
                $detail =  OrderDetail::query()
                    ->create($detail);
            else
                $detail->update($tmp);

        }

        $this->preparedOrderData($orderId, [
            "send_to_bitrix" => $sendToBitrix,
            "send_to_email" => $sendToMail,
            "send_to_telegram" => $sendToTelegram,
        ]);

        return response()->json(['message' => 'Order processed successfully'], 200);
    }

    public function downloadDemo(Request $request)
    {
        $request->validate([
            "type" => "required",
        ]);

        $path = storage_path() . "/app";


        $type = $request->type ?? 0;

        switch ($type) {
            default:
            case 0:
                $name = "договор с ИП.docx";
                $generatedName = "договор с ИП DEMO.docx";

                break;
            case 1:
                $name = "договор с ООО.docx";
                $generatedName = "договор с ООО DEMO.docx";
                break;
            case 2:
                $name = "договор с ФЛ.docx";
                $generatedName = "договор с ФЛ DEMO.docx";
                break;

        }

        $preparedRequisites = "Получатель: DEMO" .
            " Счет получателя: 40178100000000000000" .
            " БИК: 044525225" .
            " Наименование банка: ОАО «Банк Санкт-Петербург»" .
            " Корреспондентский счет: 301 01 810 6 0000 0000601" .
            " ИНН: 781633333333" .
            " КПП: 773601001";

        if (!file_exists($path . "/" . $name)) {
            return view("error", [
                "message" => "Не найден шаблон договора!"
            ]);
        }

        $work_days_string = "7 (" . (new MessageFormatter('ru-RU', '{n, spellout}'))->format(['n' => 7]) . ")";

        $templateProcessor = new TemplateProcessor($path . "/$name");

        $templateProcessor->setValue('date_doc', '25-04-2025'); // текущая дата
        $templateProcessor->setValue('numb_doc', "1");
        $templateProcessor->setValue('title', "ООО 'ТЕСТ'");
        $templateProcessor->setValue('member', "Иванов Иван Иванович");
        $templateProcessor->setValue('fio', "Иванов И.И.");
        $templateProcessor->setValue('email', "ivanov@example.com");
        $templateProcessor->setValue('phone', "+7 (900) 123-45-67");
        $templateProcessor->setValue('fact_address', "ул. Пушкина, д. 10, кв. 5");
        $templateProcessor->setValue('law_address', "г. Москва, ул. Ленина, д. 1");
        $templateProcessor->setValue('inn', "1234567890");
        $templateProcessor->setValue('ogrn', "1234567890123");
        $templateProcessor->setValue('kpp', "123456789");
        $templateProcessor->setValue('okpo', "12345678");

        $templateProcessor->setValue('order_id', 1001);
        $templateProcessor->setValue('info', "Заказ на поставку оборудования");
        $templateProcessor->setValue('total_price', 500000.00);
        $templateProcessor->setValue('total_count', 10);
        $templateProcessor->setValue('current_payed', 200000.00);
        $templateProcessor->setValue('payed_percent', 40);
        $templateProcessor->setValue('last_payment', 300000.00);
        $templateProcessor->setValue('delivery_terms', "Доставка до терминала транспортной компании");
        $templateProcessor->setValue('work_days', $work_days_string);


        $templateProcessor->setValue('bik', "044525225");
        $templateProcessor->setValue('ksch', "30101810400000000225");
        $templateProcessor->setValue('rsch', "40802810400000123456");
        $templateProcessor->setValue('bank_name', "ПАО Сбербанк");
        $templateProcessor->setValue('passport', '1234 567890');
        $templateProcessor->setValue('passport_issued', 'Отделением УФМС России по г. Москва, ЦАО');

        if (!is_null($preparedRequisites))
            $templateProcessor->setValue('requisites', $preparedRequisites);

        $doc = new DocumentLogic();
        $sellerParams = $doc->getAllSellerParameters($type);

        foreach ($sellerParams as $key => $value)
            $templateProcessor->setValue($key, $value);

        $templateProcessor->saveAs($path . "/$generatedName");

        $headers = array(
            'Content-Type:  application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        );
        $file = $path . "/$generatedName";

        return response()->download($file, $generatedName, $headers);
    }

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/OrdersPage');
    }

    /**
     * @throws \HttpException
     */
    public function editDoorInOrder(Request $request): OrderDetailResource
    {
        $request->validate([
            "id"=>"required"
        ]);

        $detail = OrderDetail::query()
            ->find($request->id);

        if (is_null($detail))
            throw new \HttpException("Дверь не найдена в системе!");

        $doorType = json_decode($request->door_type??'[]');

        $tmp = [
            'door_type' => $doorType->title ?? null,
            'count' => (int)($request->count ?? 1),
            'price' => (float)($request->price ?? 0),
            'comment' => $request->comment ?? null,
            'purpose' => $request->purpose ?? null,
            'door' => $request->all(),
        ];

       $detail->update($tmp);

       return new OrderDetailResource($detail);
    }

    public function updateContractTemplates(Request $request)
    {

        $request->validate([
            "type" => "required",
            "file" => "required"
        ]);

        $path = storage_path('app/');

        $type = $request->type ?? 0;
        $file = $request->file ?? null;

        if (is_null($file))
            return response()->noContent(400);

        $name = $type == 0 ? "договор с ИП.docx" : ($type == 1 ? "договор с ООО.docx" : "договор с ФЛ.docx");

        if (file_exists($path . "/" . $name))
            unlink($path . "/" . $name);
        $file->move($path, $name);

        return response()->noContent(200);
    }

    public function downloadFilteredOrdersExcel(Request $request)
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $type = $request->type ?? null;
        $ids = $request->ids ?? null;

        if (!is_null($ids))
            $ids = explode(',', $ids);

        $df = $request->df ?? null;
        $dt = $request->dt ?? null;

        $orders = Order::query();

        if (!is_null($search))
            $orders = $orders
                ->where("contract_number", 'like', "%$search%")
                ->orWhere("phone", 'like', "%$search%")
                ->orWhere("contract_amount", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        if ($type == "multiply") {
            $orders = $orders
                ->whereIn("id", $ids);
        }

        if (!is_null($df) && !is_null($dt))
            $orders = $orders
                ->whereBetween("contract_date", [
                    Carbon::createFromTimestamp(substr($df, 0, strlen($df) - 3))->format('Y-m-d H:i:s'),
                    Carbon::createFromTimestamp(substr($dt, 0, strlen($df) - 3))->format('Y-m-d H:i:s'),
                ]);

        $orders = $orders->orderBy($order, $direction)
            ->get();

        if (count($orders) == 0)
            return view("error", [
                "message" => "Заказы с указанным идентификатором не найдены"
            ]);

        $ids = array_values($orders->pluck("id")->toArray());

        $details = OrderDetail::query()
            ->with(["order"])
            ->whereIn("order_id", $ids)
            ->get();

        return Excel::download(new OrderExport(
            $orders,
            $details,
        ), "filtered-orders-tasks.xlsx");
    }

    public function downloadOrderExcel(Request $request, $id)
    {

        $order = Order::query()
            ->where("id", $id)
            ->first();

        $details = OrderDetail::query()
            ->where("order_id", $id)
            ->get();

        if (is_null($order ?? null))
            return view("error", [
                "message" => "Заказ с указанным идентификатором не найден"
            ]);

        $client = Client::query()
            ->where("id", $order->client_id)
            ->first();


        $buyerData = $client->getBuyerData();


        $items = [];

        foreach ($details as $detail) {
            $door = (object)$detail->door;
            $items[] = $door;

        }

        return Excel::download(new MultiSheetsCartExport($items, $buyerData), "заказ $id.xlsx");

        /*return Excel::download(new OrderExport(
            $orders,
            $details,
        ), "orders-tasks-$id.xlsx");*/
    }

    public function getOrderList(Request $request): OrderCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');
        $df = $request->df ?? null;
        $dt = $request->dt ?? null;


        $orders = Order::query()
            ->with(['details']);

        if (!is_null($search))
            $orders = $orders
                ->where("contract_number", 'like', "%$search%")
                ->orWhere("phone", 'like', "%$search%")
                ->orWhere("contract_amount", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        if (!is_null($df) && !is_null($dt))
            $orders = $orders
                ->whereBetween("contract_date", [
                    Carbon::parse($df)->format('Y-m-d H:i:s'),
                    Carbon::parse($dt)->format('Y-m-d H:i:s'),
                ]);

        $orders = $orders->orderBy($order, $direction);

        return new OrderCollection($orders->paginate($size));
    }

    public function downloadTemplate(Request $request)
    {
        $request->validate([
            "type" => "required",
        ]);

        switch ($request->type ?? 0) {
            case 0:
                $name = "договор с ИП.docx";
                break;
            case 1:
                $name = "договор с ООО.docx";
                break;
            case 2:
                $name = "договор с ФЛ.docx";
                break;

        }

        $headers = array(
            'Content-Type:  application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        );

        $path = storage_path() . "/app";
        $file = $path . "/$name";

        return response()->download($file, $name, $headers);
    }

    public function downloadContract(Request $request)
    {
        $request->validate([
            "id" => "required"
        ]);

        $path = storage_path() . "/app";

        $orderId = $request->o ?? $request->id ?? null;
        $neededType = $request->type ?? null;


        $order = Order::query()->find($orderId);
        $client = $order->client ?? null;


        if (is_null($client))
            return view("error", [
                "message" => "Такой клиент не найден в системе!"
            ]);

        if (is_null($order))
            return view("error", [
                "message" => "Такой заказ не найден в системе!"
            ]);


        if (is_null($neededType) || $neededType == -1)
            $nds = ($order->organizational_form ?? 'legal_entity') == 'legal_entity' ? 1 : 0;
        else
            $nds = $neededType;

        $title = str_replace('"', "", $client->title);
        $title = str_replace("'", "", $title);

        switch ($nds) {
            default:
            case 0:
                $name = "договор с ИП.docx";
                $generatedName = "договор с ИП $title.docx";

                break;
            case 1:
                $name = "договор с ООО.docx";
                $generatedName = "договор с ООО $title.docx";
                break;
            case 2:
                $name = "договор с ФЛ.docx";
                $generatedName = "договор с ФЛ $title.docx";
                break;

        }


        $preparedRequisites = null;

        if (is_array($client->requisites) && count($client->requisites) === 1) {
            $tmp = (object)$client->requisites[0];
            $preparedRequisites = "Получатель: " . ($client->title ?? '-') .
                " Счет получателя:" . ($tmp->checking_account ?? '-') .
                " БИК: " . ($tmp->bik ?? '-') .
                " Наименование банка: " . ($tmp->bank ?? '-') .
                " Корреспондентский счет: " . ($tmp->correspondent_account ?? '-') .
                " ИНН: " . ($client->inn ?? '-') .
                " КПП:" . ($client->kpp ?? '-');
        }

        if (is_array($client->requisites) && count($client->requisites) > 1) {
            $tmp = (object)Collection::make($client->requisites)->where("is_main", true)->first();

            if (is_null($tmp ?? null))
                $tmp = (object)$client->requisites[0];

            $preparedRequisites = "Получатель: " . ($client->title ?? '-') .
                " Счет получателя:" . ($tmp->checking_account ?? '-') .
                " БИК: " . ($tmp->bik ?? '-') .
                " Наименование банка: " . ($tmp->bank ?? '-') .
                " Корреспондентский счет: " . ($tmp->correspondent_account ?? '-') .
                " ИНН: " . ($client->inn ?? '-') .
                " КПП:" . ($client->kpp ?? '-');
        }

        if (!file_exists($path . "/" . $name)) {
            return view("error", [
                "message" => "Не найден шаблон договора!"
            ]);
        }
        $buyerData = $client->getBuyerData();

        $work_days_string = $order->work_days . "(" . (new MessageFormatter('ru-RU', '{n, spellout}'))->format(['n' => $order->work_days]) . ")";

        $templateProcessor = new TemplateProcessor($path . "/$name");

        $templateProcessor->setValue('date_doc', Carbon::now()->format('d-m-Y'));
        $templateProcessor->setValue('numb_doc', $order->id);
        $templateProcessor->setValue('title', $client->title ?? '-');
        $templateProcessor->setValue('member', $client->fio ?? '-');
        $templateProcessor->setValue('fio', $client->fio ?? '-');
        $templateProcessor->setValue('email', $client->email ?? '-');
        $templateProcessor->setValue('phone', $client->phone ?? '-');
        $templateProcessor->setValue('fact_address', $client->fact_address ?? '-');
        $templateProcessor->setValue('law_address', $client->law_address ?? '-');
        $templateProcessor->setValue('inn', $client->inn ?? '-');
        $templateProcessor->setValue('ogrn', $client->ogrn ?? '-');
        $templateProcessor->setValue('kpp', $client->kpp ?? '-');
        $templateProcessor->setValue('okpo', $client->okpo ?? '-');

        $templateProcessor->setValue('order_id', $order->id);
        $templateProcessor->setValue('info', $order->info ?? '-');
        $templateProcessor->setValue('total_price', $order->total_price ?? 0);
        $templateProcessor->setValue('total_count', $order->total_count ?? 0);
        $templateProcessor->setValue('current_payed', $order->current_payed ?? 0);
        $templateProcessor->setValue('payed_percent', $order->payed_percent ?? 0);
        $templateProcessor->setValue('last_payment', floatval($order->total_price) - floatval($order->current_payed));
        $templateProcessor->setValue('delivery_terms', $order->delivery_terms ?? '-');
        $templateProcessor->setValue('work_days', $work_days_string);

        ///delivery и install поля
        $templateProcessor->setValue('delivery', ($order->config["delivery_type"] ?? 1) == 0 ? "входит" : "не входит");
        $templateProcessor->setValue('install', ($order->config["need_install"] ?? 0) == 1 ? "входит" : "не входит");
        ///
        ///
        // requisites
        $templateProcessor->setValue('bik', $buyerData["buyer_bank_bic"]);
        $templateProcessor->setValue('ksch', $buyerData["buyer_correspondent_account"]);
        $templateProcessor->setValue('rsch', $buyerData["buyer_checking_account"]);
        $templateProcessor->setValue('bank_name', $buyerData["buyer_bank_name"]);
        /*    $templateProcessor->setValue('passport', $passport);
            $templateProcessor->setValue('passport_issued', $passport_issued);*/
        if (!is_null($preparedRequisites))
            $templateProcessor->setValue('requisites', $preparedRequisites);

        $doc = new DocumentLogic();
        $sellerParams = $doc->getAllSellerParameters($nds == 1);

        foreach ($sellerParams as $key => $value)
            $templateProcessor->setValue($key, $value);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $templateProcessor->saveAs($path . "/$generatedName");

        $headers = array(
            'Content-Type:  application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        );
        $file = $path . "/$generatedName";

        return response()->download($file, $generatedName, $headers);
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required"
        ]);

        $variants = json_decode($request->variants ?? '[]');
        $imageInfo = json_decode($request->uploaded_image_info ?? '[]');


        $tmp = $this->uploadPhotos(
            $request->hasFile('uploaded_variants_image') ?
                $request->file('uploaded_variants_image') : null, true);

        foreach ($tmp as $item)
            foreach ($imageInfo as $key => $info) {
                $info = (object)$info;
                if ($item->original == ($info->image_name ?? null)) {
                    $info->uuid = Str::uuid()->toString();
                    $info->image = $item->current ?? '-';
                    unset($info->image_name);
                }
            }

        $variants = [...$variants, ...$imageInfo];


        $id = $request->id ?? null;

        if (is_null($id))
            $order = Order::query()
                ->create([
                    "title" => $request->title ?? null,
                    'price' => $request->price ?? 0,
                    'color' => $request->color ?? null,
                    'variants' => $variants
                ]);
        else {
            $order = Order::query()->find($id);

            if (is_null($order))
                return response()->noContent(404);

            $order->update([
                "title" => $request->title ?? null,
                'price' => $request->price ?? 0,
                'color' => $request->color ?? null,
                'variants' => $variants
            ]);

        }

        return new OrderResource($order);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $order = Order::query()->find($id);

        if (is_null($order))
            return response()->noContent(404);

        $order->delete();

        return response()->noContent(200);
    }
}
