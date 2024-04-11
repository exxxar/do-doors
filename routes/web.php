<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::get('/open-calc', function (\Illuminate\Http\Request $request) {
    $params = $request->get("settings") ?? null;

    $test = base64_encode(json_encode([
        "bgColor"=>"#f8f9fa"
    ]));

    if (!is_null($params))
        $params = json_decode(base64_decode($params));

    Inertia::setRootView("open-app");
    return Inertia::render('OpenCalcPage',[
        "params"=>$params
    ]);
})->name('open.calc.page');

Route::get('/', function () {
    return Inertia::render('Welcome', [
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

Route::get('/clients', function () {
    return Inertia::render('Admin/ClientsPage');
})->middleware(['auth', 'verified'])->name('clients');



Route::get('/orders', function () {
    return Inertia::render('Admin/OrdersPage');
})->middleware(['auth', 'verified'])->name('orders');


Route::get('/basket', function () {
    return Inertia::render('CartPage');
})->middleware(['auth', 'verified'])->name('basket');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix("/calc")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\CalcController::class)
    ->group(function(){
        Route::post("/checkout","checkout")->name('checkout');
        Route::post("/download-excel","downloadCartExcel")->name('download.cart.excel');
    });


Route::prefix("/materials")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\MaterialController::class)
    ->group(function () {
        Route::get("/","index")->name('materials');
        Route::post("/","getMaterialList");
        Route::post("/store","store");
        Route::delete("/{id}","destroy");
    });

Route::prefix("/handles")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\HandleController::class)
    ->group(function () {
        Route::get("/","index")->name('handles');
        Route::post("/","getHandleList");
        Route::post("/store","store");
        Route::delete("/{id}","destroy");
    });

Route::prefix("/sizes")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\SizeController::class)
    ->group(function () {
        Route::get("/","index")->name('sizes');
        Route::post("/","getSizeList");
        Route::get("/export-prices", [\App\Http\Controllers\SizeController::class,"exportPrices"]);
        Route::post("/recount","recountPrice");
        Route::post("/formatted","getFormatted");
        Route::post("/prepared-prices","getPreparedPrices");
        Route::post("/generate","generateSizes");
        Route::get("/duplicate/{id}","duplicate");
        Route::post("/store","store");
        Route::post("/import","import");
        Route::post("/update-param","updateParam");
        Route::delete("/{id}","destroy");

    });

Route::prefix("/users")
    ->middleware(['auth', 'verified'])
    ->controller(App\Http\Controllers\UsersController::class)
    ->group(function () {
        Route::get("/","index")->name('users');
        Route::post("/","getUsersList");
        Route::post("/store","store");
        Route::delete("/{id}","destroy");
    });



