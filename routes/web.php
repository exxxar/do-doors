<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Illuminate\Foundation\Application;
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

Route::get("/bitrix-field", function () {
    $bitrix = new \App\Services\BitrixService();

    return (object)[
        "lead" => $bitrix->getLeadFields(),
        "deal" => $bitrix->getLeadDealFields()
    ];
});

Route::get("/2test", function () {
    $bitrix = new \App\Services\BitrixService();

    return $bitrix->getLeadFields();

    $leadData = [
        'TITLE' => 'ADADASDASD',
        'NAME' => 'Иван',
        'SECOND_NAME' => 'Иванов',
        'LAST_NAME' => 'Тестовый',
        'COMMENTS' => 'Комментарий к заказу',
        'SOURCE_ID' => 'OTHER',
        'SOURCE_DESCRIPTION' => env("SOURCE_DESCRIPTION"),
        'STATUS_ID' => 'NEW',//NEW, IN_PROCESS, PROCESSED, JUNK, CONVERTED
        'PHONE' => [['VALUE' => '+79991234561', 'VALUE_TYPE' => 'WORK']],
        'EMAIL' => [['VALUE' => 'exxxar@gmail.com', 'VALUE_TYPE' => 'WORK']]
    ];

    $leadId = $bitrix->createLead($leadData)["result"] ?? null;


    // $result = $bitrix->getLeads();
    $productData = [
        'NAME' => "LINK1522123123",
        'CURRENCY_ID' => 'RUB',
        'PRICE' => 100.0,
        'DESCRIPTION' => "https://do-doors.online/link/15",
        'MEASURE' => 6,
        'QUANTITY' => 100 // Единица измерения (шт.)
    ];
    $response = $bitrix->addProduct($productData);
    //dd($response);


    $response = $bitrix->addProductToLead($leadId, [
        [
            "PRODUCT_ID" => $response["result"] ?? null,
            "PRICE" => 3000,
            "QUANTITY" => 1,
        ],
    ]);

    //$response = $bitrix->getLeadProducts(2);
    //$response = $bitrix->addProduct($productData);


    $response = $bitrix->addDocumentToLead($leadId, "test.xlsx", base64_encode(file_get_contents(storage_path() . "\\app\\public\\documents\\3b29367f-1bca-465a-bfa6-b2f7815a4ba4.xlsx", "3b29367f-1bca-465a-bfa6-b2f7815a4ba4.xlsx")));
    $response = $bitrix->getLeads();
    //$response = $bitrix->getLeadFields();
    //  $response = $bitrix->getFolders(1);
    // $response = $bitrix->uploadDocument(1,storage_path()."\\app\\public\\documents\\3b29367f-1bca-465a-bfa6-b2f7815a4ba4.xlsx","3b29367f-1bca-465a-bfa6-b2f7815a4ba4.xlsx");
    return $response;
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


