<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\TarifController;
use App\Http\Controllers\Admin\IncomesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ReportingController;
use App\Http\Controllers\Branch\OutboxingController;
use App\Http\Controllers\Admin\IncomeTypesController;
use App\Http\Controllers\Admin\ExpenseTypesController;
use App\Http\Controllers\Branch\BranchOrderController;
use App\Http\Controllers\Branch\SellingPostelController;
use App\Http\Controllers\Admin\BranchReportingController;
use App\Http\Controllers\Branch\PercelOutboxingController;
use App\Http\Controllers\Branch\TembleOutboxingController;
use App\Http\Controllers\Branch\RegisteredOutboxingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::group(['middleware' => 'auth'], function () {
Route::name('admin.')->middleware('auth')->group(function () {
    //    Admin Dashboard

    Route::controller(TarifController::class)->name('tarif.')->group(function () {
        Route::get('/tarif/zone', 'zone')->name('zone')->middleware('can:Manage Tarif');
        Route::get('/tarif/continent', 'continent')->name('continent')->middleware('can:Manage Tarif');
        Route::get('/tarif/country', 'country')->name('country')->middleware('can:Manage Tarif');
        // Route::post('/employees', 'store')->name('store');
        // Route::put('/employees/{id}', 'update')->name('update');
        // Route::delete('/employees/{id}', 'destroy')->name('destroy');
        // #employee profile
        // Route::get('/employees/profile/{id}', 'profile')->name('profile')->middleware('can:read employee');
    });
    //    Employees



    Route::controller(SupplierController::class)->prefix('products')->name('supplier.')->group(function () {
        Route::get('/supplier', 'index')->name('index')->middleware('can:read supplier');
        Route::post('/supplier', 'store')->name('store');
        Route::put('/supplier/{id}', 'update')->name('update');
        Route::delete('/supplier/{id}', 'destroy')->name('destroy');
        // #employee profile
        Route::get('/supplier/profile/{id}', 'profile')->name('profile')->middleware('can:read supplier');
    });
    Route::controller(CategoryController::class)->name('category.')->group(function () {
        Route::get('/category', 'index')->name('index')->middleware('can:read category');
        Route::post('/category', 'store')->name('store');
        Route::put('/category/{id}', 'update')->name('update');
        Route::delete('/category/{id}', 'destroy')->name('destroy');
        // #employee profile
        Route::get('/category/profile/{id}', 'profile')->name('profile')->middleware('can:read category');
    });
    Route::controller(ItemController::class)->prefix('products')->name('item.')->group(function () {
        Route::get('/item', 'index')->name('index')->middleware('can:read items');
        Route::post('/item', 'store')->name('store');
        Route::put('/item/{id}', 'update')->name('update');
        Route::delete('/item/{id}', 'destroy')->name('destroy');
        // #employee profile
        Route::get('/item/profile/{id}', 'profile')->name('profile')->middleware('can:read items');
    });
    Route::controller(PurchaseController::class)->name('purchase.')->prefix('products')->group(function () {
        Route::get('/purchase', 'index')->name('index')->middleware('can:read purchase');
        Route::post('/purchase', 'store')->name('store');
        Route::get('/purchase/list', 'list')->name('list')->middleware('can:read purchase');
        Route::get('/purchase/report', 'report')->name('report')->middleware('can:read purchase');
        Route::get('/stock/report', 'stock')->name('stock')->middleware('can:read purchase');
        Route::get('/purchase/view/{id}', 'view')->name('view')->middleware('can:read purchase');
        Route::put('/purchase/update', 'update')->name('update')->middleware('can:read purchase');
        Route::delete('/purchase/{id}', 'destroy')->name('destroy')->middleware('can:read purchase');
        // Route::put('/item/{id}', 'update')->name('update');
        // Route::delete('/item/{id}', 'destroy')->name('destroy');
        // // #employee profile
        // Route::get('/item/profile/{id}', 'profile')->name('profile')->middleware('can:read items');
    });



    //    expense Types
    Route::controller(ExpenseTypesController::class)->name('expense_types.')->group(function () {
        Route::get('/expense_types', 'index')->name('index')->middleware('can:read expense types');
        Route::post('/expense_types', 'store')->name('store');
        Route::put('/expense_types/{id}', 'update')->name('update');
        Route::delete('/expense_types/{id}', 'destroy')->name('destroy');
    });

    //   End expense Types
    //    expense
    Route::controller(ExpensesController::class)->name('expenses.')->group(function () {
        Route::get('/expenses', 'index')->name('index')->middleware('can:read expense');
        Route::post('/expenses', 'store')->name('store');
        Route::put('/expenses/{id}', 'update')->name('update');
        Route::put('/expenses/app/{id}', 'approve')->name('approve');
        Route::put('/expenses/rej/{id}', 'reject')->name('reject');
        Route::delete('/expenses/{id}', 'destroy')->name('destroy');
        Route::get('/expenses/history', 'history')->name('history')->middleware('can:create expense');
        Route::get('/expenses/pending', 'pending')->name('pending')->middleware('can:read expense');
        Route::get('/expenses/rejected', 'rejected')->name('rejected')->middleware('can:read expense');
        Route::get('/expenses/approved', 'approved')->name('approved')->middleware('can:read expense');
    });


    Route::controller(IncomeTypesController::class)->name('income_types.')->group(function () {
        Route::get('/income_types', 'index')->name('index')->middleware('can:read income types');
        Route::post('/income_types', 'store')->name('store');
        Route::put('/income_types/{id}', 'update')->name('update');
        Route::delete('/income_types/{id}', 'destroy')->name('destroy');
    });
    Route::controller(IncomesController::class)->name('income.')->group(function () {
        Route::get('/incomes', 'index')->name('index')->middleware('can:read income');
        Route::get('/incomesreportbranch', 'report')->name('incomesreportbranch')->middleware('can:read income');
        Route::get('/Homedelireportbranch', 'homereport')->name('Homedelireportbranch');
        Route::post('/incomes', 'store')->name('store');
        Route::put('/incomes/{id}', 'update')->name('update');
        Route::put('/incomes/app/{id}', 'approve')->name('approve');
        Route::put('/incomes/rej/{id}', 'reject')->name('reject');
        Route::delete('/incomes/{id}', 'destroy')->name('destroy');
        Route::get('/incomes/history', 'history')->name('history')->middleware('can:create income');
        Route::get('/incomes/pending', 'pending')->name('pending')->middleware('can:read income');
        Route::get('/incomes/rejected', 'rejected')->name('rejected')->middleware('can:read income');
        Route::get('/incomes/approved', 'approved')->name('approved')->middleware('can:read income');
        Route::get('transactionotherincome/{pdate}', 'transactionotheri')->name('transactionotherincome');
    });
    //   End expense Types

    Route::controller(ReportingController::class)->name('reporting.')->prefix('reporting')->group(function () {
        // INBOXING MAILS
        Route::get('/inboxing-ems', 'inboxing_ems')->name('inboxing_ems')->middleware('can:read summarized report');
        Route::get('/inboxing-ordinary', 'inboxing_ordinary')->name('inboxing_ordinary')->middleware('can:read summarized report');
        Route::get('/inboxing-registered', 'inboxing_registered')->name('inboxing_registered')->middleware('can:read summarized report');
        Route::get('/inboxing-parcel', 'inboxing_percel')->name('inboxing_percel')->middleware('can:read summarized report');

        // OUTBOXING MAILS
        Route::get('/outboxing-ems', 'outboxing_ems')->name('outboxing_ems')->middleware('can:read summarized report');
        Route::get('/outboxing-registered', 'outboxing_registered')->name('outboxing_registered')->middleware('can:read summarized report');
        Route::get('/outboxing-parcel', 'outboxing_percel')->name('outboxing_percel')->middleware('can:read summarized report');
        Route::get('/outboxing-stamps', 'outboxing_stamps')->name('outboxing_stamps')->middleware('can:read summarized report');
        // P.O.BOX INCOME
        Route::get('/physical-pobox', 'physical_pobox')->name('physical_pobox')->middleware('can:read summarized report');
        Route::get('/virtual-pobox', 'virtual_pobox')->name('virtual_pobox')->middleware('can:read summarized report');

        Route::get('/other-revenue', 'other_revenue')->name('other_revenue')->middleware('can:read summarized report');
        Route::get('/home-delivery', 'home_delivery')->name('home_delivery')->middleware('can:read summarized report');

        Route::get('/daily-income', 'daily')->name('daily')->middleware('can:read summarized report');
        Route::get('/daily-income/details', 'daily_details')->name('daily_details')->middleware('can:read summarized report');
        Route::get('/monthly-income', 'monthly')->name('monthly')->middleware('can:read summarized report');
        Route::get('/monthly-income/details', 'monthly_details')->name('monthly_details')->middleware('can:read summarized report');

        Route::get('/daily-expenses', 'daily_expense')->name('daily_expense')->middleware('can:read summarized report');
        Route::get('/daily-expenses/details', 'daily_expense_details')->name('daily_expense_details')->middleware('can:read summarized report');
        Route::get('/monthly-expenses', 'monthly_expense')->name('monthly_expense')->middleware('can:read summarized report');
        Route::get('/monthly-expenses/details', 'monthly_expense_details')->name('monthly_expense_details')->middleware('can:read summarized report');


        Route::get('/products/report', 'index')->name('index')->middleware('can:read summarized report');
        Route::get('/expenses/report', 'expenses')->name('expenses')->middleware('can:read summarized report');
        Route::get('/registered/report', 'registered')->name('registered')->middleware('can:read summarized report');
        Route::get('/percel/report', 'percel')->name('percel')->middleware('can:read summarized report');
        Route::get('/temble/report', 'temble')->name('temble')->middleware('can:read summarized report');
        Route::get('/postel/report', 'postel')->name('postel')->middleware('can:read summarized report');

        Route::get('/monthly/profit/report', 'profit')->name('profit')->middleware('can:read summarized report');
    });

});

Route::name('branch.')->middleware('auth')->group(function () {
    Route::controller(BranchOrderController::class)->name('order.')->prefix('order')->group(function () {
        Route::get('/new', 'index')->name('index')->middleware('can:make branchorder');
        Route::get('/approved', 'approved')->name('approved')->middleware('can:Approved History');
        Route::get('/rejected', 'rejected')->name('rejected')->middleware('can:Rejected History');
        Route::get('/requests', 'history')->name('history')->middleware('can:read branchorder');
        Route::get('/status', 'status')->name('status')->middleware('can:make branchorder');
        Route::post('/new', 'store')->name('store')->middleware('can:make branchorder');
        Route::get('/view/{id}', 'view')->name('view');
        Route::put('/update/{id}', 'update')->name('update')->middleware('can:update branchorder');
        Route::put('/approve/{id}', 'approve')->name('approve')->middleware('can:approve branchorder');
        Route::put('/reject/{id}', 'reject')->name('reject')->middleware('can:reject branchorder');
    });
    Route::controller(OutboxingController::class)->name('outboxing.')->prefix('outboxing')->group(function () {
        Route::get('/new', 'index')->name('index')->middleware('can:read outboxing');
        Route::get('/list', 'list')->name('list')->middleware('can:read outboxing');
        Route::get('/tranfered-mails', 'tranfered')->name('tranfered')->middleware('can:read outboxing');
        Route::get('/create', 'create')->name('create')->middleware('can:read outboxing');
        Route::get('/print-out/{id}', 'print_out')->name('print_out')->middleware('can:read outboxing');
        Route::get('/edit/{id}', 'edit')->name('edit')->middleware('can:read outboxing');
        Route::put('/update/{id}', 'update2')->name('update2')->middleware('can:read outboxing');
        Route::delete('/destroy/{id}', 'destroy2')->name('destroy2')->middleware('can:read outboxing');
        Route::post('/store2', 'store2')->name('store2')->middleware('can:make outboxing');
        Route::get('/items', 'items')->name('items');
        Route::post('/save', 'store')->name('store')->middleware('can:make outboxing');
        Route::get('/history', 'history')->name('history')->middleware('can:make outboxing');
        Route::get('/view/{id}', 'view')->name('view')->middleware('can:make outboxing');
        Route::put('/view/{id}', 'update')->name('update')->middleware('can:make outboxing');
        Route::put('/newss', 'updatetraems')->name('updatetraems')->middleware('can:make outboxing');
        Route::get('/report', 'report')->name('report')->middleware('can:make outboxing');
        Route::delete('/delete/{id}', 'destroy')->name('destroy')->middleware('can:make outboxing');
        Route::get('/Emsinvoice/invoiceems/{out_id}' , 'invoiceems')->name('invoiceems');
        Route::get('transactionomailems/{pdate}', 'transactionouems')->name('transactionomailems');
    });
    Route::controller(RegisteredOutboxingController::class)->name('registeredoutboxing.')->prefix('registeredoutboxing')->group(function () {
        Route::get('/new', 'index')->name('index')->middleware('can:read outboxing');
        Route::post('/save', 'store')->name('store')->middleware('can:make outboxing');
        Route::get('/history', 'history')->name('history')->middleware('can:read outboxing');
        Route::get('/view/{id}', 'view')->name('view')->middleware('can:make outboxing');
        Route::put('/view/{id}', 'update')->name('update')->middleware('can:make outboxing');
        Route::get('/report', 'report')->name('report')->middleware('can:make outboxing');
        Route::delete('/delete/{id}', 'destroy')->name('destroy')->middleware('can:make outboxing');
        Route::get('/registerednvoice/invoicereg/{out_id}' , 'invoicer')->name('invoicer');
        Route::get('transactionregistered/{pdate}', 'transactionregi')->name('transactionregistered');
    });

    Route::controller(PercelOutboxingController::class)->name('perceloutboxing.')->prefix('perceloutboxing')->group(function () {
        Route::get('/new', 'index')->name('index')->middleware('can:read outboxing');
        Route::post('/save', 'store')->name('store')->middleware('can:make outboxing');
        Route::get('/history', 'history')->name('history')->middleware('can:make outboxing');
        Route::get('/view/{id}', 'view')->name('view')->middleware('can:make outboxing');
        Route::get('/transfer/percel', 'index1')->name('index1')->middleware('can:make outboxing');
        Route::put('/view/{id}', 'update')->name('update')->middleware('can:make outboxing');
        Route::get('/report', 'report')->name('report')->middleware('can:make outboxing');
        Route::delete('/delete/{id}', 'destroy')->name('destroy')->middleware('can:make outboxing');
        Route::put('/newssss', 'updatetraper')->name('updatetraper')->middleware('can:make outboxing');
        Route::get('/percelnvoice/invoiceems/{out_id}' , 'invoicep')->name('invoicepercel');
        Route::get('transactionpercel/{pdate}', 'transactionper')->name('transactionpercel');
    });
    Route::controller(TembleOutboxingController::class)->name('tembleoutboxing.')->prefix('stampsoutboxing')->group(function () {
        Route::get('/new', 'index')->name('index')->middleware('can:read outboxing');
        Route::get('/transfer/temble', 'index1')->name('index1')->middleware('can:make outboxing');
        Route::post('/save', 'store')->name('store')->middleware('can:make outboxing');
        Route::get('/history', 'history')->name('history')->middleware('can:make outboxing');
        Route::get('/view/{id}', 'view')->name('view')->middleware('can:make outboxing');
        Route::put('/view/{id}', 'update')->name('update')->middleware('can:make outboxing');
        Route::get('/report', 'report')->name('report')->middleware('can:make outboxing');
        Route::delete('/delete/{id}', 'destroy')->name('destroy')->middleware('can:make outboxing');
        Route::put('/newsssss', 'updatetratemble')->name('updatetratemble')->middleware('can:make outboxing');
        Route::get('/Emsitemblenvoice/invoiceems/{out_id}' , 'invoiceemst')->name('invoiceemstemble');
        Route::get('transactiontemble/{pdate}', 'transactiontemb')->name('transactiontemble');
    });
    Route::controller(SellingPostelController::class)->name('sellingpostel.')->prefix('sellingpostel')->group(function () {
        Route::get('/new', 'index')->name('index')->middleware('can:read outboxing');
        Route::get('/create', 'create')->name('create')->middleware('can:read outboxing');
        Route::get('/edit/{id}', 'edit')->name('edit')->middleware('can:read outboxing');
        Route::post('/save', 'store')->name('store')->middleware('can:make outboxing');
        Route::get('/history', 'history')->name('history')->middleware('can:make outboxing');
        Route::get('/report', 'report')->name('report')->middleware('can:make outboxing');
        Route::put('/update/{id}', 'update')->name('update')->middleware('can:make outboxing');
        Route::get('/update/{id}', 'modify')->name('modify')->middleware('can:make outboxing');
        Route::delete('/delete/{id}', 'destroy')->name('destroy')->middleware('can:make outboxing');
    });
    //changed
    Route::controller(BranchReportingController::class)->name('breporting.')->prefix('branch-reporting')->group(function () {
        Route::get('/products/report', 'index')->name('index');
        Route::get('/daily-incomes', 'daily')->name('daily');
        Route::get('/daily-incomes/details', 'daily_details')->name('daily_details');
        Route::get('/monthly-incomes', 'monthly')->name('monthly');
        Route::get('/monthly-incomes/details', 'monthly_details')->name('monthly_details');

        Route::get('/daily-expenses', 'daily_expenses')->name('daily_expenses');
        Route::get('/daily-expenses/details', 'daily_expenses_details')->name('daily_expenses_details');

        Route::get('/monthly-expenses', 'monthly_expenses')->name('monthly_expenses');
        Route::get('/monthly-expenses/details', 'monthly_expenses_details')->name('monthly_expenses_details');

    });





});
// });
