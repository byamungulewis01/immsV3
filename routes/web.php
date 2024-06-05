<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EuclController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalletContoller;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminPobController;
use App\Http\Controllers\Admin\BoxController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\EuclReportsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DPOIntegrationController;
use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Admin\SendDispatchController;
use App\Http\Controllers\Admin\AdminAddressingController;
use App\Http\Controllers\Admin\DispatchInvoiceController;

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

Route::group(['middleware' => 'guest'], function () {
    // Customer Login
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/ussd', [HomeController::class, 'ussd'])->name('ussd');
    Route::get('/register', [HomeController::class, 'register'])->name('register');

    Route::prefix('customer')->name('customer.')->group(function () {
        // Route::get('/login', [HomeController::class, 'customer_login'])->name('login');
        // Route::get('/register', [HomeController::class, 'customer_register'])->name('register');
        #customer register on CustomerAuthController controller
        Route::controller(CustomerAuthController::class)->group(function () {
            Route::post('/login', 'login')->name('loginAuth');
            Route::post('/register', 'register')->name('registerAuth');
        });
    });

    // Admin Login
    Route::controller(AdminAuthController::class)->name('admin.')->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login')->name('loginAuth');
        Route::get('/reset-password', 'resetPassword')->name('resetPassword');
    });

    Route::get('/payment_test', [PaymentController::class, 'index'])->name('payment_test.index');
    Route::post('payment_test/', [PaymentController::class, 'store_payment'])->name('payment_test.store');
    Route::get('payment_test/callback', [PaymentController::class, 'callback'])->name('payment_test.callback');
    Route::get('payment_test/webhook', [PaymentController::class, 'webhook'])->name('payment_test.webhook');
});

// Route::group(['middleware' => 'auth'], function () {
Route::name('admin.')->middleware('auth')->group(function () {
    //    Admin Dashboard
    Route::get('/dashboard', [AdminDashController::class, 'index'])->name('dashboard');
    //    Employees
    Route::controller(EmployeeController::class)->name('employee.')->group(function () {
        Route::get('/employees', 'index')->name('index')->middleware('can:read employee');
        Route::get('/employees/active', 'active')->name('active')->middleware('can:read employee');
        Route::get('/employees/inactive', 'inactive')->name('inactive')->middleware('can:read employee');
        Route::get('/employees/deactivate', 'deactivate')->name('deactivate')->middleware('can:read employee');
        Route::put('/employees/activate/{id}', 'activate')->name('activate');
        Route::post('/employees', 'store')->name('store');
        Route::put('/employees/{id}', 'update')->name('update');
        Route::delete('/employees/{id}', 'destroy')->name('destroy');
        #employee profile
        Route::get('/employees/profile/{id}', 'profile')->name('profile');
        Route::get('/employees/profile', 'profileEdit')->name('profileEdit');
        Route::put('/employees/profile/update', 'profileUpdate')->name('profileUpdate');
        Route::put('/employees/profile/change-password', 'changePassword')->name('changePassword');
        Route::put('/employees/profile/change-password2/{id}', 'changePassword2')->name('changePassword2');
    });

    Route::controller(BranchController::class)->name('branch.')->group(function () {
        Route::get('/branch', 'index')->name('index')->middleware('can:read branch');
        Route::post('/branch', 'store')->name('store');
        Route::put('/branch/{id}', 'update')->name('update');
        Route::delete('/branch/{id}', 'destroy')->name('destroy');
    });
    //   End Branche

    //    POBbox
    Route::controller(BoxController::class)->name('box.')->group(function () {
        Route::get('/box', 'index')->name('index');
        Route::post('/box', 'store')->name('store');
        Route::put('/box/{id}', 'update')->name('update');
        Route::delete('/box/{id}', 'destroy')->name('destroy');
    });
    //   End POBbox

    //  addressings
    Route::controller(AdminAddressingController::class)->name('addressing.')->group(function () {
        Route::get('/addressing/individual', 'individual')->name('individual');
        Route::get('/addressing/company', 'company')->name('company');
        Route::get('/addressing/company/{id}', 'members')->name('members');
        Route::get('/addressing/map', 'map')->name('map');
    });

    //    Roles
    Route::controller(RolesController::class)->name('roles.')->group(function () {
        Route::get('/roles', 'index')->name('index')->middleware('can:read roles');
        Route::post('/roles', 'store')->name('store');
        Route::put('/roles/{id}', 'assignRole')->name('assignRole');
        Route::delete('/roles/{id}', 'destroy')->name('destroy');
    });
    //   End Roles

    //    Permissions
    Route::controller(PermissionsController::class)->name('permissions.')->group(function () {
        Route::get('/permissions', 'index')->name('index')->middleware('can:read permission');
        Route::post('/permissions', 'store')->name('store');
        Route::put('/permissions/{id}', 'update')->name('update');
        Route::delete('/permissions/{id}', 'destroy')->name('destroy');
    });
    //   End Permissions
    //    Settings
    Route::controller(SettingController::class)->name('setting.')->group(function () {
        Route::get('/setting', 'index')->name('index')->middleware('can:read setting');
        Route::prefix('setting')->group(function () {
            Route::post('/activity', 'activityStore')->name('store');
            Route::put('/activity/{id}', 'activityUpdate')->name('update');
            Route::delete('/activity/{id}', 'activityDestroy')->name('destroy');
        });
    });
    //   End Settings

    //  SendDispatchController
    Route::controller(SendDispatchController::class)->name('sendDispatch.')->group(function () {
        Route::get('/createDispatch/{id}', 'index')->name('index');
        Route::post('/createDispatch', 'store')->name('store');
        Route::get('/createDispatch/show/{id}', 'show')->name('show');
        Route::delete('/sendDispatch/{id}', 'destroy')->name('destroy');
        Route::post('/createDispatch/show', 'showStore')->name('showStore');
        Route::delete('/createDispatch/show/{id}', 'showDestroy')->name('showDestroy');
        Route::get('/viewDispatch', 'viewDispatch')->name('viewDispatch');
        Route::get('/sentDispatch', 'sentDispatch')->name('sentDispatch');
        Route::get('/recievedDispatch', 'recievedDispatch')->name('recievedDispatch');
        Route::put('/sentDispatch/{id}', 'sentDispatchUpdate')->name('sentDispatchUpdate');
        Route::get('/mails/list/{id}', 'mailsList')->name('mailsList');
    });

    // dispatchInvoiceController
    Route::controller(DispatchInvoiceController::class)->name('dispatchInvoice.')->group(function () {
        Route::get('/dispatchInvoice', 'index')->name('index');
        Route::get('/dispatchInvoice/show/{id}', 'show')->name('show');
        Route::post('/dispatchInvoice', 'store')->name('store');
        Route::get('/dispatchInvoice/showInvoice/{id}', 'showInvoice')->name('showInvoice');
        Route::post('/dispatchInvoice/notification/{id}', 'notificationStore')->name('notificationStore');
        Route::get('/dispatchInvoice/download/{id}', 'download')->name('download');
    });

    Route::controller(AdminPobController::class)->prefix('admin')->group(function () {
        Route::get('/physicalPob', 'index')->name('physicalPob.index');
        Route::get('/virtualPob', 'index_virtualPob')->name('virtualPob.index');
    });

    Route::controller(TransactionController::class)->prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/api', 'api')->name('api');
        Route::get('/print-reciept/{id}', 'printReceipt')->name('printReceipt');
        Route::post('/store', 'store')->name('store');
        Route::get('/fetch-meter-number', 'fetchMeterFromEUCL')->name('fetch-meter-from-eucl');
        Route::get('/reports', 'reports')->name('reports');
        Route::get('/reportsApi', 'reportsApi')->name('reportsApi');
    });
    Route::controller(WalletContoller::class)->prefix('wallet')->name('wallet.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/reports', 'reports')->name('reports');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::put('/approval/{id}', 'approval')->name('approval');
        Route::put('/reject/{id}', 'reject')->name('reject');
    });

    // Eucl Controller
    Route::controller(EuclController::class)->prefix('eucl-service')->name('eucl-service.')->group(function () {
        Route::get("/", 'index')->name("index");
        Route::get("/account-sammary", 'accountSammary')->name("sammary");
        Route::get("/account/meterHistory", 'meterHistory')->name("meterHistory");
        Route::get("/account-history", 'accountHistory')->name("history");
        Route::get("/account-historyApi", 'accountHistoryApi')->name("historyApi");
        Route::get("/payment-retry/{id}", 'paymentRetry')->name("paymentRetry");
        Route::get("/payment-copy/{id}", 'paymentCopy')->name("paymentCopy");
        Route::get("/payment-login", 'login')->name("login");
        Route::get("/change-password", 'changePassword')->name("changePassword");
    });
    // Eucl Reports
    Route::controller(EuclReportsController::class)->prefix('admin-reports')->name('eucl-reports.')->group(function () {
        Route::get("/daily-balance", 'daily_balance')->name("daily_balance");
        Route::get("/daily-activities", 'daily_activities')->name("daily_activities");
        Route::get("/daily-print-activities", 'print_daily_activities')->name("print_daily_activities");
        Route::get("/daily-transactions/{branch}", 'daily_transactions')->name("daily_transactions");
        Route::get("/daily-all-transactions", 'daily_all_transactions')->name("daily_all_transactions");
        Route::get("/monthly-activities", 'monthly_activities')->name("monthly_activities");
        Route::get("/monthly-branches-activities", 'monthly_branches_activities')->name("monthly_branches_activities");
        Route::get("/monthly-transactions/{branch}", 'monthly_transactions')->name("monthly_transactions");
        Route::get("/monthly-all-transactions", 'monthly_all_transactions')->name("monthly_all_transactions");
    });




    // change password
    Route::get('/change-password', [AdminAuthController::class, 'changePassword'])->name('changePassword');
    Route::put('/change-password/{id}', [AdminAuthController::class, 'changePasswordStore'])->name('changePasswordStore');

    //    Logout
    Route::get('/logout', [LogoutController::class, 'adminLogout'])->name('logout');







    Route::controller(DPOIntegrationController::class)->name('dpo.')->prefix('dpo-integration')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/success', 'success')->name('success');
        Route::get('/fail', 'fail')->name('fail');
        Route::post('/', 'store')->name('store');

    });
});

Route::get('/test_sms', function () {
   $sent = (new NotificationController)->send_sms("Testing Now","0785436135");
    return $sent;
});

// });
