<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UssdController;
use App\Http\Controllers\AdminPobController;
use App\Http\Controllers\PricingApiController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Eric\AirportMailController;
use App\Http\Controllers\Admin\PhysicalPobController;
use App\Http\Controllers\MobileAPI\CustomerController;
use App\Http\Controllers\MobileAPI\UserAuthController;
use App\Http\Controllers\Admin\DispatchInvoiceController;
use App\Http\Controllers\Eric\Register\EmsMailTransferController;
use App\Http\Controllers\Eric\Register\PercelMailTransferController;
use App\Http\Controllers\Eric\Register\OrdinaryMailTransferController;
use App\Http\Controllers\Eric\Register\OrdinaryLetterTransferController;
use App\Http\Controllers\Eric\Register\RegisteredMailTransferController;
use App\Http\Controllers\Eric\Register\RegisteredLetterTransferController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/ussd', [UssdController::class, 'ussd']);
Route::post('/virtual-pobox', [UssdController::class, 'virtual_pob']);
Route::post('/physical-pobox', [UssdController::class, 'physical_pob']);
Route::post('/pobox-mail', [UssdController::class, 'mail']);

Route::post("/meter", [App\Http\Controllers\TestEUCLController::class, 'testTestCheckMete'])->name("test.meter");
Route::post("/buy", [App\Http\Controllers\TestEUCLController::class, 'testTestBuy'])->name("test.buy");

// Route::controller(UserAuthController::class)->prefix('driver')->group(function () {
//     Route::post('/login', 'login');
// });
// Route::controller(CustomerController::class)->prefix('customer')->group(function () {
//     Route::post('/login', 'login');
//     Route::post('/register', 'register');
// });

// employee routes in employee controller
Route::controller(EmployeeController::class)->prefix('employee')->group(function () {
    Route::get('/', 'api')->name('employee.api');
    Route::get('/active', 'activeApi')->name('employee.activeApi');
    Route::get('/inactive', 'inactiveApi')->name('employee.inactiveApi');
    Route::get('/deactivate', 'deactivateApi')->name('employee.deactivateApi');
});


// PhysicalPobController
Route::controller(PhysicalPobController::class)->prefix('physicalPob')->name('physicalPob.')->group(function () {
    Route::get('/{id}', 'pobApi')->name('pobApi');
});
Route::controller(AdminPobController::class)->prefix('adminPhysicalPob')->name('admin.physicalPob.')->group(function () {
    Route::get('/{id}', 'pobApi')->name('pobApi');
});
Route::controller(AdminPobController::class)->prefix('adminVirtualPob')->name('admin.virtualPob.')->group(function () {
    Route::get('vitualPob/{id}', 'vitualPobApi')->name('pobApi');
});

Route::controller(DispatchInvoiceController::class)->name('dispatchInvoice.')->group(function () {
    Route::get('/dispatchInvoice', 'api')->name('api');
});




Route::get('/branches', [BranchController::class, 'api'])->name('branches.api');

Route::controller(AirportMailController::class)->prefix('airportDispach')->name('airportDispach.')->group(function () {
    Route::get('/', 'dispachApi')->name('dispachApi');
});
Route::controller(PricingApiController::class)->prefix('price')->name('price.')->group(function () {
    // Route::get('/get_price', 'getPrice')->name('getPrice');
    Route::post('/get_price', 'getPrice')->name('getPrice');
    Route::post('/get_single_country_price', 'getSingleCountryPrice')->name('getSingleCountryPrice');
    Route::post('/get_continent_price', 'getContinentPrice')->name('getContinentPrice');
});
Route::controller(RegisteredMailTransferController::class)->prefix('RegisteredApi')->name('RegisteredApi.')->group(function () {
    Route::get('/{id}/{user}', 'RegApi')->name('RegApi');
});
Route::controller(PercelMailTransferController::class)->prefix('PercelApi')->name('PercelApi.')->group(function () {
    Route::get('/{id}/{user}', 'PerApi')->name('PerApi');
});
Route::controller(OrdinaryMailTransferController::class)->prefix('OrdinaryApi')->name('OrdinaryApi.')->group(function () {
    Route::get('/{id}/{user}', 'OrdApi')->name('OrdApi');
});
Route::controller(EmsMailTransferController::class)->prefix('EmsApi')->name('EmsApi.')->group(function () {
    Route::get('/{id}/{user}', 'emApi')->name('emApi');
});
Route::controller(RegisteredLetterTransferController::class)->prefix('RegistereLetterApi')->name('RegistereLetterApi.')->group(function () {
    Route::get('/{id}/{user}', 'regletterapi')->name('regletterapi');
});
Route::controller(OrdinaryLetterTransferController::class)->prefix('OrdinaryLetterApi')->name('OrdinaryLetterApi.')->group(function () {
    Route::get('/{id}/{user}', 'ordletterapi')->name('ordletterapi');
});

// end Eric




Route::get('/customerMails/{id}', function ($customer_id) {

    $boxes = App\Models\Box::where('customer_id', $customer_id)->select('pob', 'branch_id')->get();
    $inboxing = [];
    foreach ($boxes as $box) {
        $inboxing[] = App\Models\Eric\Inboxing::where('pob', $box->pob)->where('pob_bid', $box->branch_id)->where('instatus', '3')
            ->select('id', 'instatus', 'inname')->get();
    }

    return response()->json([
        'data' => $inboxing,
    ]);
});

Route::get('/customerHomeDelivery/{id}', function ($customer_id) {

    $homedelivery = App\Models\HomeDelivery::where('customer', $customer_id)->with('curier')->get();

    return response()->json([
        'data' => $homedelivery,
    ]);
});

Route::get('/driverHomeDelivery/{id}', function ($postAgent) {

    $homedelivery = App\Models\HomeDelivery::where('postAgent', $postAgent)->with(['curier', 'box'])->get();

    return response()->json([
        'data' => $homedelivery,
    ]);
});





