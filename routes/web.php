<?php

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Google\Client;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;
use Revolution\Google\Sheets\Sheets;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any("/webhook", function (Request $request){
    Log::info("test");
    Log::info("request=>".print_r($request->all(), true));
    $id = $request->data["FIELDS"]["ID"] ?? null;

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
            $contact = $bitrix->getContact($contactId)["result"];

            $phone = $contact["PHONE"][0]["value"] ?? null;

            $comment = $contact["COMMENTS"] ?? null;

            $name = ($contact["LAST_NAME"] ?? "") . " " . ($contact["NAME"] ?? "") . " " . ($contact["SECOND_NAME"] ?? "");

            $client = \App\Models\Client::query()
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

            'delivery_terms' => '',
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

});
//Route::any("/webhook-deal-update", [\App\Http\Controllers\CalcController::class, 'webhookDealUpdateHandler']);
//Route::any("/webhook-deal-create", [\App\Http\Controllers\CalcController::class, 'webhookDealCreateHandler']);

Route::get("/bitrix-contact/{contactId?}", function ($contactId) {
    $bitrix = new \App\Services\BitrixService();


    $contact = $bitrix->getContact($contactId)["result"];

    $phone = $contact["PHONE"][0]["value"] ?? null;

    $name = ($contact["LAST_NAME"] ?? "") . " " . ($contact["NAME"] ?? "") . " " . ($contact["SECOND_NAME"] ?? "");



    return $contact;
});

Route::get("/bitrix-field/{dealId?}", function ($dealId = null) {
    $bitrix = new \App\Services\BitrixService();

    if (!is_null($dealId))
        $deal = $bitrix->getDeal($dealId);

    return (object)[
        "selected_deal" => $deal ?? null,
        "lead" => $bitrix->getLeadFields(),
        "deal" => $bitrix->getLeadDealFields(),
        "leads" => $bitrix->getLeads(),
        "contacts" => $bitrix->getContacts(),
        "statuses" => $bitrix->getStatusList()
    ];
});

Route::get("/2test", function () {
    $bitrix = new \App\Services\BitrixService();

    return $bitrix->getContacts();


});

Route::get("/test", function () {
    $path = storage_path() . "\\app";

    //  $fileName = $workWithNds == 1?"договор с ООО.docx":"договор с ИП.docx";

    /* dd([
         "file_exist"=>file_exists($path . "/$fileName"),
         "filename"=>$fileName,
         "path"=>$path
     ]);*/


    try {
        $templateProcessor = new TemplateProcessor($path . "\\demo.docx");
        $templateProcessor->setValue('name', "1231231");
        $templateProcessor->setValue('email', "dasdasd");
        $templateProcessor->setValue('phone', "!23123");
        $templateProcessor->setValue('order_id', "1");
        $templateProcessor->setValue('info', "3123");
        $templateProcessor->setValue('total_price', 1313);
        $templateProcessor->setValue('total_count', 44);
        $templateProcessor->setValue('current_payed', 44);
        $templateProcessor->setValue('payed_percent', 5);
        $templateProcessor->setValue('delivery_terms', "test");


        $templateProcessor->saveAs($path . "/test.docx");


    } catch (CopyFileException $e) {
        dd($e);
    } catch (CreateTemporaryFileException $e) {
        dd($e);
    }


});


Route::get('/login/google/callback', [GoogleLoginController::class, 'callback'])->name('login.google-callback');
Route::get('/login/google/service-callback', [GoogleLoginController::class, 'serviceCallback'])->name('login.google-callback.test');


Route::get('/open-calc', function (\Illuminate\Http\Request $request) {
    $params = $request->get("settings") ?? null;

    $test = base64_encode(json_encode([
        "bgColor" => "#f8f9fa"
    ]));

    if (!is_null($params))
        $params = json_decode(base64_decode($params));

    Inertia::setRootView("open-app");
    return Inertia::render('OpenCalcPage', [
        "params" => $params
    ]);
})->name('open.calc.page');


Route::get('/', function () {
    return Inertia::render('Landing', [  //Welcome
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/permissions', function () {
    return Inertia::render('Permissions/Index');
})->middleware(['auth', 'verified'])->name('permissions.index');


Route::get('/permissions/create', function () {
    return Inertia::render('Permissions/Create');
})->middleware(['auth', 'verified'])->name('permissions.create');

Route::get('/permissions/edit', function () {
    return Inertia::render('Permissions/Edit');
})->middleware(['auth', 'verified'])->name('permissions.edit');

Route::get('/calc', function () {
    return Inertia::render('CalcPage');
})->middleware(['auth', 'verified'])->name('calc');

Route::get('/documents', function () {
    return Inertia::render('Admin/DocumentsPage');
})->middleware(['auth', 'verified'])->name('documents');


Route::get('/clients', function () {
    return Inertia::render('Admin/ClientsPage');
})->middleware(['auth', 'verified'])->name('clients');


Route::get('/orders', function () {
    return Inertia::render('Admin/OrdersPage');
})->middleware(['auth', 'verified'])->name('orders');


Route::get('/basket', function () {
    return Inertia::render('CartPage');
})->middleware(['auth', 'verified'])->name('basket');

Route::get('/link/{orderId}', function ($orderId) {
    $order = Order::query()
        ->with(["details"])
        ->where("id", $orderId)
        ->first();

    if (is_null(Auth::user()->id ?? null)) {
        return Inertia::render('OrderInfo', [
            "order" => $order->toArray(),
            "doors" => $order->details
        ]);
    }
    return Inertia::render('OrderEditor', [
        "order" => $order->toArray(),
        "doors" => $order->details
    ]);
})->name('order.info');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix("/calc")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\CalcController::class)
    ->group(function () {
        Route::post("/checkout", "checkout")->name('checkout');
        Route::post("/contract-processing", "contractProcessing")->name('contract-processing');
        Route::post("/download-excel", "downloadCartExcel")->name('download.cart.excel');
    });


Route::prefix("/documents")
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/config', [DocumentController::class, 'getConfig']); // Получить текущий конфиг
        Route::post('/config', [DocumentController::class, 'updateConfig']); // Обновить конфиг или отдельные поля
    });


Route::prefix("/materials")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\MaterialController::class)
    ->group(function () {
        Route::get("/", "index")->name('materials');
        Route::post("/", "getMaterialList");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/door-variants")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\DoorVariantController::class)
    ->group(function () {
        Route::get("/", "index")->name('door-variants');
        Route::post("/", "getDoorVariantList");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/services")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\ServiceController::class)
    ->group(function () {
        Route::get("/", "index")->name('services');
        Route::post("/", "getServiceList");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });


Route::prefix("/colors")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\ColorController::class)
    ->group(function () {
        Route::get("/", "index")->name('colors');
        Route::post("/", "getColorList");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/hinges")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\HingeController::class)
    ->group(function () {
        Route::get("/", "index")->name('hinges');
        Route::post("/", "getHingeList");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/handles")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\HandleController::class)
    ->group(function () {
        Route::get("/", "index")->name('handles');
        Route::post("/", "getHandleList");
        Route::post("/store", "store");
        Route::post("/fast-store", "fastStore");
        Route::post('/import-from-google', [GoogleLoginController::class, 'getGoogleLink']);
        Route::post('/import-from-excel', "import");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/roles")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\RolesController::class)
    ->group(function () {
        Route::get("/", "index")->name('roles');
        Route::post("/", "getRolesList");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/permissions")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\PermissionsController::class)
    ->group(function () {
        Route::get("/", "index")->name('permissions');
        Route::post("/", "getPermissionsList");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/promo-codes")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\PromoCodeController::class)
    ->group(function () {
        Route::get("/", "index")->name('promo-codes');
        Route::post("/", "getPromoCodesList");
        Route::post("/store", "store");
        Route::post("/find-promo", "findPromo");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/orders")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\OrderController::class)
    ->group(function () {
        Route::get("/", "index")->name('orders');
        Route::get("/download-order-excel/{id}", "downloadOrderExcel");
        Route::get("/download-filtered-orders", "downloadFilteredOrdersExcel");
        Route::get("/download-contract", "downloadContract");
        Route::get("/download-template", "downloadTemplate");
        Route::post("/", "getOrderList");
        Route::post("/update-contract-templates", "updateContractTemplates");
        Route::post("/store", "store");
        Route::post("/edit-door-in-order", "editDoorInOrder");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/order-details")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\OrderDetailController::class)
    ->group(function () {
        Route::get("/", "index")->name('order-details');
        Route::post("/", "getOrderDetailList");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });

Route::prefix("/clients")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\ClientController::class)
    ->group(function () {
        Route::get("/", "index")->name('clients');
        Route::post("/", "getClientList");
        Route::get("/self-list", "getSelfClientList");
        Route::post("/request-by-inn", "getDataByInn");
        Route::post("/request-by-bik", "getDataByBik");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });


Route::prefix("/sizes")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\SizeController::class)
    ->group(function () {
        Route::get("/", "index")->name('sizes');
        Route::post("/", "getSizeList");
        Route::get("/export-prices", [\App\Http\Controllers\SizeController::class, "exportPrices"]);
        Route::post("/recount", "recountPrice");
        Route::post("/formatted", "getFormatted");
        Route::post("/prepared-prices", "getPreparedPrices");
        Route::post("/generate", "generateSizes");
        Route::get("/duplicate/{id}", "duplicate");
        Route::post("/store", "store");
        Route::post("/import", "import");
        Route::post("/update-param", "updateParam");
        Route::post('/import-from-google', [GoogleLoginController::class, 'getGoogleLink'])->name('login.google-redirect');
        Route::delete("/{id}", "destroy");

    });

Route::prefix("/users")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\UsersController::class)
    ->group(function () {
        Route::get("/", "index")->name('users');
        Route::post("/", "getUsersList");
        Route::post("/store", "store");
        Route::delete("/{id}", "destroy");
    });


Route::prefix("/")
    ->controller(App\Http\Controllers\LandingController::class)
    ->group(function () {

        Route::post("/sendReqCallToBot", "sendReqCallToBot")->name('sendReqCallToBot');


    });


Route::resource('opening-variant', App\Http\Controllers\OpeningVariantController::class);


