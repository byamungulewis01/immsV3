<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Customer\AddressingController;
use App\Http\Controllers\Customer\MyContactsController;
use App\Http\Controllers\Customer\ApplicationController;
use App\Http\Controllers\Customer\CustomerPobController;
use App\Http\Controllers\Customer\CustomerDashController;
use App\Http\Controllers\Customer\NationalMailController;
use App\Http\Controllers\Customer\MailsController;

Route::middleware('customer')->group(function () {
    Route::get('/dashboard', [CustomerDashController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LogoutController::class, 'customerLogout'])->name('logout');
    #Application controller
    Route::controller(ApplicationController::class)->name('application.')->group(function () {
        Route::get('/application', 'index')->name('index');
        Route::post('/application', 'store')->name('store');
        Route::put('/application/{id}', 'update')->name('update');
        Route::delete('/application/{id}', 'destroy')->name('destroy');
        Route::get('/application/getAvailablePob/{branch}', 'getAvailablePob')->name('getAvailablePob');
        Route::get('/application/getTakenPob/{branch}', 'getTakenPob')->name('getTakenPob');
        Route::get('/application/gePobInfo/{id}', 'getPobInfo')->name('getPobInfo');
    });
    Route::controller(CustomerPobController::class)->group(function () {
        Route::get('/physical-pob', 'physicalPob')->name('physicalPob');
        Route::put('/physical-pob/{id}', 'physicalPobUpdate')->name('physicalPob.update');
        Route::get('/physical-pob/download/{id}', 'downloadAttachment')->name('physicalPob.download');
        Route::get('/physical-pob/{id}', 'physicalPobDetails')->name('physicalPob.details');
        Route::get('/preforma/{id}', 'preforma')->name('preforma');
        Route::get('/invoice/{id}', 'invoice')->name('invoice');

        Route::post('/virtualPayment', 'virtualPayment')->name('virtualPayment');
        Route::post('/physicalPayment', 'physicalPayment')->name('physicalPayment');


        Route::get('/contract/{id}', 'contract')->name('contract');
        Route::get('/virtual-pob', 'virtualPob')->name('virtualPob');
        Route::get('/virtual-pob/{id}', 'virtualPobDetails')->name('virtualPob.details');
        Route::put('/virtual-pob/{id}', 'virtualPobUpdate')->name('virtualPob.update');
    });

    // Addressing Controller
    Route::controller(AddressingController::class)->name('addressing.')->group(function () {
        Route::get('/addressing/{id}', 'index')->name('index');
        Route::put('/addressing/{id}', 'changeOfficeAddress')->name('changeOfficeAddress');
        Route::put('/addressing/homeAddress/{id}', 'changeHomeAddress')->name('changeHomeAddress');
        // Route::put('/addressing/{id}', 'update')->name('update');
        // Route::delete('/addressing/{id}', 'destroy')->name('destroy');
        // Route::get('/addressing/members/{id}', 'members')->name('members');
        Route::post('/addressing/members/{id}', 'membersStore')->name('membersStore');
        Route::put('/addressing/members/{id}', 'membersUpdate')->name('membersUpdate');
        Route::delete('/addressing/members/{id}', 'membersDestroy')->name('membersDestroy');
    });

    //    MyContactsController
    Route::controller(MyContactsController::class)->name('my-contacts.')->group(function () {
        Route::get('/my-contacts', 'index')->name('index');
        Route::get('/my-contacts/{id}', 'show')->name('show');
        Route::post('/my-contacts', 'store')->name('store');
        Route::post('/my-contacts/addOffice/{id}', 'addOffice')->name('addOffice');
        Route::post('/my-contacts/addhome/{id}', 'addHome')->name('addHome');
        Route::put('/my-contacts/{id}', 'update')->name('update');
        Route::delete('/my-contacts/{id}', 'destroy')->name('destroy');
    });
    // NationalMailController
    Route::controller(NationalMailController::class)->name('mails.')->group(function () {
        Route::get('/mails', 'index')->name('index');
        Route::get('/mails/details/{id}', 'details')->name('details');
        Route::post('/mails', 'store')->name('store');
        Route::post('/mails/add/{id}', 'add')->name('add');
        Route::delete('/mails/remove', 'remove')->name('remove');
        Route::put('/mails/send/{id}', 'sendMail')->name('sendMail');
        Route::delete('/mails/{id}', 'destroy')->name('destroy');
        // verify
        Route::post('/mails/verify/{id}', 'verify')->name('verify');
        // invoice
        Route::get('/mails/invoice', 'invoice')->name('invoice');
        Route::put('/mails/payInvoice/{id}', 'payInvoice')->name('payInvoice');
        // download
        Route::get('/mails/download/{id}', 'download')->name('download');
        Route::get('/mails/showInvoice/{id}', 'showInvoice')->name('showInvoice');
    });
    // InternationalMailController
    Route::controller(MailsController::class)->name('mail.')->group(function () {
        Route::get('/international-mails', 'index')->name('index');
        Route::get('/international-mails/show/{id}', 'show')->name('show');
        // make delivery order
        Route::post('/international-mails/delivery-order/{id}', 'deliveryOrder')->name('deliveryOrder');

        Route::get('/national-mails', 'national')->name('national');
        Route::get('/national-mails/show/{id}', 'nationalShow')->name('nationalShow');
        // get homeDelivery
        Route::get('/national-mails/homeDelivery', 'homeDelivery')->name('homeDelivery');
    });

});
