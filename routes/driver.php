<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Driver\Drivercontroller;
use App\Http\Controllers\Driver\DriverNationalMails;
use App\Http\Controllers\Driver\CaliberationController;
use App\Http\Controllers\Driver\RouteController;
use App\Http\Controllers\Driver\HomeDeliveryController;
use App\Http\Controllers\Driver\AssignsController;

Route::middleware('auth')->group(function () {
    Route::controller(Drivercontroller::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/withVehicle', 'withVehicle')->name('withVehicle');
        Route::get('/withoutVehicle', 'withoutVehicle')->name('withoutVehicle');
        Route::put('/assign/{id}', 'assignVehicle')->name('assignVehicle');
        Route::put('/release/{id}', 'releaseVehicle')->name('releaseVehicle');
        Route::get('/history' ,'vehicleHistory')->name('history');
    });
    
       // RouteController
    Route::controller(RouteController::class)->name('route.')->prefix('route')->group(function () {
       Route::get('/', 'index')->name('index');
       Route::post('/', 'store')->name('store');
       Route::put('/{id}', 'update')->name('update');
       Route::delete('/{id}', 'destroy')->name('destroy');
       Route::put('/kmIn/{id}', 'kmIn')->name('kmIn');
    });
    // CaliberationController
    Route::controller(CaliberationController::class)->name('caliberation.')->prefix('caliberation')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // AssignsController
    Route::controller(AssignsController::class)->name('assigns.')->prefix('assigns')->group(function () {
        Route::get('/ems-national', 'emsNational')->name('emsNational');
        Route::get('/ems-national/receive', 'emsNationalReceive')->name('emsNationalReceive');
        Route::get('/ems-international', 'emsInternational')->name('emsInternational');
        Route::get('/ems-international/receive', 'emsInternationalReceive')->name('emsInternationalReceive');
        Route::put('/ems-international/pickup', 'emsInternationalPickup')->name('emsInternationalPickup');
        Route::get('/homeDelivery', 'homeDelivery')->name('homeDelivery');
        Route::get('/homeDelivery/receive', 'homeDeliveryReceive')->name('homeDeliveryReceive');
        Route::put('/homeDelivery/approve/{id}', 'homeDeliveryApprove')->name('homeDeliveryApprove');

    });
    

    Route::controller(DriverNationalMails::class)->name('nationalMails.')->group(function () {
        Route::get('/nationalMails', 'index')->name('index');
        Route::get('/nationalMails/assigned', 'assigned')->name('assigned');
        Route::put('/nationalMails/{id}', 'assignMail')->name('assignMail');
        Route::get('/nationalMails/received', 'received')->name('received');
        Route::get('/nationalMails/received/{id}', 'details')->name('details');
        Route::put('/nationalMails/fill-up/{id}', 'fillUp')->name('fillUp');
        Route::put('/nationalMails/submit/{id}', 'submit')->name('submit');
        Route::get('/nationalMails/sentMail', 'sentMail')->name('sentMail');
        Route::get('/nationalMails/sentMail/{id}', 'sentMailDetail')->name('sentMailDetail');
        Route::get('/nationalMails/pod/{id}', 'pod')->name('pod');

    });
    // HomeDeliveryController
    Route::controller(HomeDeliveryController::class)->name('homeDelivery.')->group(function () {
        Route::get('/homeDelivery', 'index')->name('index');
        Route::get('/homeDelivery/transit', 'transit')->name('transit');
        Route::get('/homeDelivery/delivered', 'delivered')->name('delivered');
        // assign delivery to driver
        Route::put('/homeDelivery/{id}', 'assignDelivery')->name('assignDelivery');

    });
});
