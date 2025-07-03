<?php

namespace App\Http\Controllers;

use App\Classes\DocumentLogic;
use App\Enums\OrderStatusEnum;
use App\Exports\Cart\MultiSheetsCartExport;
use App\Exports\CartExport;
use App\Exports\CommercialProposal\MultiSheetsCart2Export;
use App\Mail\KPMail;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

use Exception;
use Illuminate\Http\Request;

use Illuminate\Mail\Attachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use MessageFormatter;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;

use nomelodic\NCL\NCLNameCaseRu;


class CalcController extends Controller
{


    public function webhookDealHandler(Request $request)
    {

        $id = $request->all()["data"]["FIELDS"]["ID"] ?? null;
        $bitrix = new \App\Services\BitrixService();

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
                $contact = $bitrix->getContact($contactId)["result"] ?? null;

                if (!is_null($contact)) {
                    $phone = $contact["PHONE"][0]["value"] ?? null;

                    $email = $contact["EMAIL"][0]["value"] ?? null;

                    // $comment = $contact["COMMENTS"] ?? null;

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
                    'info' => '',
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

        // Validate request data
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string',
                'items' => 'required|string', // Assuming items is JSON string
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }


        $sendToBitrix = $request->input("send_to_bitrix") ?? false;
        $sendToMail = $request->input("send_to_mail") ?? false;
        $sendToTelegram = $request->input("send_to_telegram") ?? false;
        $sendToSelf = $request->input("send_to_self_mail") ?? false;
        $selfMail = $request->input("self_email") ?? null;

        // Initialize variables with defaults
        $orderId = $request->input('order_id');
        $currentPayed = (float)$request->input('current_payed', 0);
        $payedPercent = (float)$request->input('payed_percent', 0);
        $payedPercentType = (int)$request->input('payed_percent_type', 0);
        $ascentFloor = filter_var($request->input('ascent_floor', false), FILTER_VALIDATE_BOOLEAN);
        $deliveryTerms = $request->input('delivery_terms');
        $deliveryType = (int)$request->input('delivery_type', 0);
        $deliveryPrice = (float)($request->input('delivery_price', 0));

        $discountPercent = 0;
        $discountValue = 0;
        if (!is_null($request->discount_data ?? null)) {
            $discountData = json_decode($request->discount_data ?? '[]');
            $discountPercent = $discountData->discount_percent ?? 0;
            $discountValue = $discountData->discount_amount ?? 0;
        }

        // Decode JSON inputs with error handling
        try {
            $designer = json_decode($request->input('designer', '[]'), true, 512, JSON_THROW_ON_ERROR);
            $installation = json_decode($request->input('installation', '[]'), true, 512, JSON_THROW_ON_ERROR);
            $items = json_decode($request->input('items', '[]'), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return response()->json(['error' => 'Invalid JSON data'], 400);
        }

        // Extract designer and installation data with null checks
        $designerWorkType = isset($designer['is_fix']) && filter_var($designer['is_fix'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $designerValue = (float)($designer['value'] ?? 0);
        $designerPrice = (float)($designer['price'] ?? 0);
        $installPrice = (float)($installation['price'] ?? 0);
        $installCount = (int)($installation['count'] ?? 0);
        $installRecountType = (int)($installation['recount_type'] ?? 0);
        $needInstall = isset($installation['need_door_install']) && filter_var($installation['need_door_install'], FILTER_VALIDATE_BOOLEAN);

        $bitrix = new \App\Services\BitrixService();
        $workWithNds = (int)$request->input('work_with_nds', 1);
        $clientId = $request->input('id');

        // Gather other request data
        $name = $request->input('name');
        $email = $request->input('email', 'не указано');
        $phone = $request->input('phone');
        $passport = $request->input('passport', 'не указано');
        $workDays = (int)$request->input('work_days', 0);
        $passportIssued = $request->input('passport_issued', 'не указано');
        $info = $request->input('info', 'не указан');
        $totalPrice = (float)$request->input('total_price', 0);
        $totalCount = (int)$request->input('total_count', 1);

        $deliveryCity = $request->input('delivery_city', '');
        $deliveryAddress = $request->input('delivery_address', '');

        // Handle client creation/update
        $client = Client::query()->where('phone', $phone)->first();
        if (!$client && !$clientId) {
            $client = Client::create([
                'status' => ['individual', 'legal_entity', 'phys'][$workWithNds] ?? 'individual',
                'phone' => $phone,
                'email' => $email === 'не указано' ? null : $email,
                'user_id' => Auth::id(),
                'title' => $name,
            ]);
        } elseif ($clientId) {
            $client = Client::find($clientId);
            if (!$client) {
                return response()->json(['error' => 'Client not found'], 404);
            }
        }

        $buyerData = $client->getBuyerData();
        $famInitial = $client->status === 'individual' ? ($client->fio ?? "Клиент №{$client->id}") : ($client->title ?? "Клиент №{$client->id}");

        $buyerData["status"] = ['individual', 'legal_entity', 'phys'][$workWithNds] ?? 'individual';
        // Prepare order data
        $tmpData = [
            'contract_date' => Carbon::now(),
            'client_id' => $client->id,
            'status' => OrderStatusEnum::NewOrder,
            'source' => $request->input('source', 'crm'),
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

        // Create or update order
        $order = $orderId ? Order::find($orderId) : null;
        if ($order) {
            $order->update($tmpData);
        } else {
            $order = Order::create($tmpData);
        }

        $leadId = $order->bitrix24_lead_id;

        // Handle Bitrix integration
        if ($sendToBitrix) {
            $contactData = [
                'NAME' => $client->title ?? $name,
                'TYPE_ID' => 'CLIENT',
                'PHONE' => [['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']],
                'EMAIL' => [['VALUE' => $email !== 'не указано' ? $email : '', 'VALUE_TYPE' => 'WORK']],
            ];

            try {
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
                'UF_CRM_1733302565' => ($request->input('delivery_city', '') . ', ' . $request->input('delivery_address', '')),
                'UF_CRM_1733302597' => Carbon::now()->addDays(5)->format('d.m.Y'),
                'UF_CRM_1733302818544' => Carbon::now()->format('d.m.Y'),
                'UF_CRM_1733302846046' => [65, 63, 155][$workWithNds] ?? 155,
                'UF_CRM_1733302866734' => $request->input('delivery_city', '-'),
                'UF_CRM_1733302493' => [51, 53, 55, 57][$deliveryType] ?? 51,
                'UF_CRM_1733302917133' => $currentPayed,
                'UF_CRM_1733302937139' => $totalPrice,
                'UF_CRM_1733302958322' => $totalPrice - $currentPayed,
                'UF_CRM_1733302997393' => 0.0,
                'UF_CRM_1733305761683' => $request->input('delivery_price', 0),
                'UF_CRM_1742035413778' => env('APP_URL') . '/link/' . $order->id,
                'UF_CRM_1742976788' => [2125, 2125, 2123][$workWithNds] ?? 2123,
                'UF_CRM_1733303016351' => 0,
                'UF_CRM_1733306662836' => 0,
                'UF_CRM_1733306683779' => $designerWorkType ? $designerValue : $designerPrice,
                'UF_CRM_1733306708610' => $designerWorkType ? 0 : $designerValue,
                'UF_CRM_1733310041523' => 0,
            ]);

            try {
                $deal = $leadId ? $bitrix->updateDeal($leadId, $leadData) : $bitrix->createDeal($leadData);
                $leadId = $deal['result'] ?? null;
                if ($leadId) {
                    $order->bitrix24_lead_id = $leadId;
                    $order->save();
                }
            } catch (Exception $e) {
                Log::error('Bitrix deal operation failed: ' . $e->getMessage());
            }
        }

        // Process items for Bitrix
        $productsForBitrix = [];
        $otherProducts = [];

        foreach ($items as $item) {
            if (!isset($item['product'])) {
                continue;
            }

            $product = (object)$item['product'];
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
                $bitrixProductId = $bitrix->addProduct($productData)['result'] ?? null;


                OrderDetail::create([
                    'order_id' => $order->id,
                    'door_type' => $product->door_type->title ?? null,
                    'count' => (int)($product->count ?? 1),
                    'price' => (float)($product->price ?? 0),
                    'comment' => $product->comment ?? null,
                    'purpose' => $product->purpose ?? null,
                    'door' => $item['product'],
                    'bitrix24_product_id' => $bitrixProductId,
                ]);

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
            if (!is_null($product->handle_holes_type ?? null)) {
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

                try {
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
            }

            Log::info("ЕСТЬ ЛИ ЗАВЕРТКА? (РУЧКА)" . print_r($product->handle_wrapper_type ?? null, true));
            // Handle wrappers
            if (!is_null($product->handle_wrapper_type ?? null)) {
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
                Log::info("ДА, ЕСТЬ? (РУЧКА)" . print_r($handleDoorsData, true));
                try {
                    $bitrixProductId = $bitrix->addProduct($handleDoorsData)['result'] ?? null;
                    Log::info("ЗАВЕРТКА: " . print_r($bitrixProductId, true));
                    if (!is_null($bitrixProductId)) {
                        $productsForBitrix[] = [
                            'PRODUCT_ID' => $bitrixProductId,
                            'PRICE' => (float)($price[$priceType] ?? 0),
                            'QUANTITY' => (int)($product->count ?? 1),
                        ];

                        $otherProducts[] = (object)[
                            'title' => 'Завертка: ' . ($wrapper->title ?? '-'),
                            'description' => 'Цена завертки поставщика',
                            'price' => (float)($price[$priceType] ?? 0),
                            'count' => (int)($product->count ?? 1),
                        ];
                    }
                } catch (Exception $e) {
                    Log::error('Failed to add wrapper product to Bitrix: ' . $e->getMessage());
                }
            }
        }


        if ($needInstall) {
            $handleInstallDoorsData = [
                'NAME' => 'Установка комплекта дверей: ' . ($installRecountType == 0 ? "суммарно за все двери ($installCount)" : 'цена за установку одной двери'),
                'CURRENCY_ID' => 'RUB',
                'PRICE' => (float)$installPrice,
                'DESCRIPTION' => $installRecountType == 0 ? "Суммарно за все двери ($installCount)" : 'Цена за установку одной двери',
                'MEASURE' => 0,
                'QUANTITY' => $installRecountType == 0 ? 1 : $installCount,
            ];

            try {
                $bitrixProductId = $bitrix->addProduct($handleInstallDoorsData)['result'] ?? null;
                Log::info("УСТАНОВКА: " . print_r($bitrixProductId, true));
                if (!is_null($bitrixProductId)) {
                    $productsForBitrix[] = [
                        'PRODUCT_ID' => $bitrixProductId,
                        'PRICE' => (float)$installPrice,
                        'QUANTITY' => $installRecountType == 0 ? 1 : $installCount,
                    ];

                    $otherProducts[] = (object)[
                        'title' => 'Установка комплекта дверей: ' . ($installRecountType == 0 ? "суммарно за все двери ($installCount)" : 'цена за установку одной двери'),
                        'description' => $installRecountType == 0 ? "Суммарно за все двери ($installCount)" : 'Цена за установку одной двери',
                        'price' => (float)$installPrice,
                        'count' => $installRecountType == 0 ? 1 : $installCount,
                    ];
                }
            } catch (Exception $e) {
                Log::error('Failed to add installation product to Bitrix: ' . $e->getMessage());
            }
        }

        // Handle delivery
        if ($deliveryType == 0) {
            $deliveryProductData = [
                'NAME' => 'Доставка комплекта дверей',
                'CURRENCY_ID' => 'RUB',
                'PRICE' => $deliveryPrice,
                'DESCRIPTION' => $deliveryCity . ', ' . $deliveryAddress,
                'MEASURE' => 0,
                'QUANTITY' => 1,
            ];

            try {
                $bitrixProductId = $bitrix->addProduct($deliveryProductData)['result'] ?? null;
                Log::info("ДОСТАВКА: " . print_r($bitrixProductId, true));
                if (!is_null($bitrixProductId)) {
                    $productsForBitrix[] = [
                        'PRODUCT_ID' => $bitrixProductId,
                        'PRICE' => $deliveryPrice,
                        'QUANTITY' => 1,
                    ];

                    $otherProducts[] = (object)[
                        'title' => 'Доставка комплекта дверей ',
                        'description' => $deliveryCity . ', ' . $deliveryAddress,
                        'price' => $deliveryPrice,
                        'count' => 1
                    ];
                }
            } catch (Exception $e) {
                Log::error('Failed to add delivery product to Bitrix: ' . $e->getMessage());
            }
        }

        // Add products to deal
        if ($sendToBitrix) {
            try {
                $bitrix->addProductToDeal($leadId, $productsForBitrix);
            } catch (Exception $e) {
                Log::error('Failed to add products to deal: ' . $e->getMessage());
            }
        }

        $timeFragment = Carbon::now('+3:00')->format('Y-m-d-H-i-s');
        // Generate PDF
        try {
            $mpdf = new Mpdf(['format' => 'A4-P']);
            $currentDate = Carbon::now('+3:00')->format('Y-m-d H:i:s');
            $number = Str::uuid();

            $mpdf->WriteHTML(view('pdf.order-v2', [
                'name' => $name,
                'order_id' => $number,
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


        $excelFileName1 = "spec-$timeFragment.xls";
        $excelFileName2 = "cp-$timeFragment.xls";

        try {
            Excel::store(new MultiSheetsCartExport($items, $buyerData, $otherProducts, true), $excelFileName1);
            Excel::store(new MultiSheetsCart2Export($items, $buyerData, $otherProducts, true), $excelFileName2);
        } catch (Exception $e) {
            Log::error('Excel generation failed: ' . $e->getMessage());
        }

        // Prepare Bitrix files
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

        // Handle contract document
        $path = storage_path('app');
        $fileName = ['договор с ИП.docx', 'договор с ООО.docx', 'договор с ФЛ.docx'][$workWithNds] ?? 'договор с ФЛ.docx';
        $statusClient = $client->getShortClientStatus();
        $newName = "/договор с клиентом №{$client->id} {$statusClient} от" . Carbon::now()->format('Y-m-d h-i-s') . '.docx';
        $workDaysString = $workDays . ' (' . (new MessageFormatter('ru-RU', '{n, spellout}'))->format(['n' => $workDays]) . ')';

        if (file_exists("$path/$fileName")) {
            try {
                $templateProcessor = new TemplateProcessor("$path/$fileName");
                $templateProcessor->setValue('date_doc', Carbon::now()->format('d-m-Y'));
                $templateProcessor->setValue('numb_doc', $order->id);
                $templateProcessor->setValue('title', $name);
                $templateProcessor->setValue('member', $client->fio ?? '-');
                $templateProcessor->setValue('fio', $famInitial);
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
                ///delivery и install поля
                $templateProcessor->setValue('delivery', $deliveryType == 0 ? "входит" : "не входит");
                $templateProcessor->setValue('install', $needInstall ? "входит" : "не входит");
                ///
                $templateProcessor->setValue('current_payed', $currentPayed);
                $templateProcessor->setValue('payed_percent', $payedPercent);
                $templateProcessor->setValue('last_payment', $totalPrice - $currentPayed);
                $templateProcessor->setValue('delivery_terms', $deliveryTerms ?? '-');
                $templateProcessor->setValue('work_days', $workDaysString);
                $templateProcessor->setValue('bik', $buyerData['buyer_bank_bic'] ?? '-');
                $templateProcessor->setValue('ksch', $buyerData['buyer_correspondent_account'] ?? '-');
                $templateProcessor->setValue('rsch', $buyerData['buyer_checking_account'] ?? '-');
                $templateProcessor->setValue('bank_name', $buyerData['buyer_bank_name'] ?? '-');
                $templateProcessor->setValue('passport', $passport);
                $templateProcessor->setValue('passport_issued', $passportIssued);

                $doc = new DocumentLogic();
                foreach ($doc->getAllSellerParameters($workWithNds) as $key => $value) {
                    $templateProcessor->setValue($key, $value);
                }

                $templateProcessor->saveAs($path . $newName);

                if ($leadId) {
                    $bitrix->addDocumentToDeal($leadId, $newName, base64_encode(file_get_contents($path . $newName)), env('DOCUMENT_FILED_CODE_CONTRACT'));
                }
            } catch (Exception $e) {
                Log::error('Document processing failed: ' . $e->getMessage());
            }
        }

        // Upload documents to Bitrix
        if ($sendToBitrix) {
            try {
                $bitrix->addDocumentsToDeal($leadId, $bitrixFiles, env('DOCUMENT_FILED_CODE_SPECIFICATION'));
            } catch (Exception $e) {
                Log::error('Failed to upload documents to Bitrix: ' . $e->getMessage());
            }
        }

        // Send to Telegram

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
                if (file_exists($path . $newName)) {
                    $telegram->sendDocument([
                        'chat_id' => env('TELEGRAM_CHANNEL_ID'),
                        'document' => InputFile::create($path . $newName),
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

            if ($sendToSelf)
                Mail::to($selfMail)
                    ->send(new KPMail($name, $attachments));

        } catch (Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
        }


        // Clean up
        Storage::delete([$excelFileName1, $excelFileName2]);

        // Return response
        if (file_exists($path . $newName)) {
            return response()->download($path . $newName)->deleteFileAfterSend(true);
        }

        return response()->json(['message' => 'Order processed successfully'], 200);
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

        $buyerData = $client->getBuyerData();

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
