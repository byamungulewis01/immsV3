<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Eric\SearchController;
use App\Http\Controllers\Cntp\SortingController;
use App\Http\Controllers\Eric\Servicecontroller;
use App\Http\Controllers\CombinedTableController;
use App\Http\Controllers\Eric\CntpMailController;
use App\Http\Controllers\Cntp\JurnalMailController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Eric\MailsTotalController;
use App\Http\Controllers\Eric\AirportMailController;
use App\Http\Controllers\Cntp\GoogleadMailController;
use App\Http\Controllers\Cntp\PostCardMailController;
use App\Http\Controllers\Cntp\JurnalTransferController;
use App\Http\Controllers\Cntp\PrintedMaterialController;
use App\Http\Controllers\Eric\ServiceCustomercontroller;
use App\Http\Controllers\Eric\Vehicle\VehicleController;
use App\Http\Controllers\Cntp\GoogleadTransferController;
use App\Http\Controllers\Eric\MailRegistrationController;
use App\Http\Controllers\Eric\Register\EmsMailController;
use App\Http\Controllers\Eric\Backoffice\MailListController;
use App\Http\Controllers\Eric\Backoffice\MailRcsnController;
use App\Http\Controllers\Eric\Register\PercelMailController;
use App\Http\Controllers\Eric\Tarifss\EmstarifRegcontroller;
use App\Http\Controllers\Cntp\PostCardTransferMailController;
use App\Http\Controllers\Eric\Out\CNTPEmsOutboxingcontroller;
use App\Http\Controllers\Eric\Tarifss\RSPATarifRegcontroller;
use App\Http\Controllers\Eric\Out\OutboxingTransfercontroller;
use App\Http\Controllers\Eric\Tarifss\EmsCountryRegcontroller;
use App\Http\Controllers\Eric\Backoffice\MailPaymentController;
use App\Http\Controllers\Eric\Register\RegisterdMailController;
use App\Http\Controllers\Eric\Tarifss\PercelTarifRegController;
use App\Http\Controllers\Eric\Tarifss\RSPACountryRegcontroller;
use App\Http\Controllers\Cntp\PrintedMaterialTransferController;
use App\Http\Controllers\Eric\Backoffice\MailDeliveryController;
use App\Http\Controllers\Eric\Out\CNTPPercelOutboxingcontroller;
use App\Http\Controllers\Eric\Out\CNTPTembleOutboxingcontroller;
use App\Http\Controllers\Eric\Register\OrdinaryLetterController;
use App\Http\Controllers\Eric\Tarifss\PercelWeightRegController;
use App\Http\Controllers\Eric\Backoffice\EmsMailIncomecontroller;
use App\Http\Controllers\Eric\Register\EmsMailTransferController;
use App\Http\Controllers\Eric\Tarifss\PercelCountryRegController;
use App\Http\Controllers\Eric\Backoffice\EmsMailPaymentcontroller;
use App\Http\Controllers\Eric\Register\RegisteredLetterController;
use App\Http\Controllers\Eric\Tarifss\EmsCountryZoneRegcontroller;
use App\Http\Controllers\Eric\Tarifss\EmsWeightRangeRegcontroller;
use App\Http\Controllers\Eric\Tarifss\RSPAWeightrangeRegcontroller;
use App\Http\Controllers\Eric\Backoffice\DispachRecievingController;
use App\Http\Controllers\Eric\Backoffice\PercelMailIncomeController;
use App\Http\Controllers\Eric\Out\CNTPRegisteredOutboxingcontroller;
use App\Http\Controllers\Eric\Out\PerceloutboxingTransfercontroller;
use App\Http\Controllers\Eric\Register\PercelMailTransferController;
use App\Http\Controllers\Eric\Backoffice\PercelMailPaymentController;
use App\Http\Controllers\Eric\Backoffice\GoogleadIncomeMailController;
use App\Http\Controllers\Eric\Backoffice\OridinaryMailIcomeController;
use App\Http\Controllers\Eric\Register\OrdinaryMailTransferController;
use App\Http\Controllers\Eric\Backoffice\GoogleadPaymentMailController;
use App\Http\Controllers\Eric\Backoffice\RegisteredMailIncomeController;
use App\Http\Controllers\Eric\Out\RegisteredoutboxingTransfercontroller;
use App\Http\Controllers\Eric\Register\OrdinaryLetterTransferController;
use App\Http\Controllers\Eric\Register\RegisteredMailTransferController;
use App\Http\Controllers\Eric\Backoffice\RegisteredMailPaymentController;
use App\Http\Controllers\Eric\Register\RegisteredLetterTransferController;
use App\Http\Controllers\Eric\Out\PostingwithtembleoutboxingTransfercontroller;

Route::name('admin.')->middleware('auth')->group(function () {
    Route::controller(AirportMailController::class)->name('inbox.')->group(function () {
        Route::get('/AirportDispach', 'index')->name('AirportDispach')->middleware('can:read airport');
        Route::get('/DispatchTransfered', 'index1')->name('DispatchTransfered')->middleware('can:driver Recieved');
        Route::get('/Mailarrived', 'index2')->name('Mailarrived')->middleware('can:mail arrived');
        Route::post('/AirportDispach', 'store')->name('store');
        Route::get('/AirportDispachrepm/{month}', 'airportmonthly')->name('AirportDispachrepm')->middleware('can:read airport');
        Route::get('/AirportDispachrepda/{date}', 'airportdaily')->name('AirportDispachrepda')->middleware('can:read airport');
        Route::get('/airport/AirportDispachrepm/{month}', 'cntptaskmonthly')->name('monthdetails');
        Route::get('/airport/AirportDispachrepd/{month}', 'cntptaskmonthly')->name('monthdetails');
        Route::put('/AirportDispach', 'update')->name('update');
        Route::put('/AirportDispacheup/{id}', 'updateDispatch')->name('AirportDispacheup');
        Route::delete('/AirportDispach/{id}', 'destroy')->name('destroy');
        Route::get('/AirportDispachrep', 'report')->name('AirportDispachrep')->middleware('can:read airport');
        Route::get('/AirportDispachrepd', 'reportd')->name('AirportDispachrepd')->middleware('can:read airport');
        Route::get('/AirportDispachrepd-orgin', 'reportd_orgin')->name('AirportDispachrepd_orgin')->middleware('can:read airport');

    });
    Route::controller(CntpMailController::class)->name('cntp.')->group(function () {
        Route::get('/CntpDispach', 'index')->name('CntpDispach');
        Route::get('/reportDispachDaily', 'dailyreport')->name('reportDispachDaily');
        Route::get('/reportDispatchmonthly', 'reportm')->name('reportDispatchmonthly');
        Route::get('/CntpMailOpening', 'index1')->name('CntpMailOpening');
        Route::get('/CntpemsOpening', 'emsopen')->name('CntpemsOpening');
        Route::get('/CntppercelOpening', 'percelopen')->name('CntppercelOpening');
        Route::get('/CntpregOpening', 'regopen')->name('CntpregOpening');
        Route::get('/Outboxing/ViewEMS/{id}', 'viewems')->name('viewems');
        Route::get('/Opening/details/{cntppickupdate}', 'cntptaskdaily')->name('details');
        Route::get('/Opening/monthdetails/{month}', 'cntptaskmonthly')->name('monthdetails');
        //Route::get('/Mailarrived', 'index2')->name('Mailarrived');
        Route::post('/CntpDispach', 'store')->name('store');
        Route::put('/CntpDispach', 'update')->name('update');
        Route::put('/fillingreg/{id}', 'fillingreg')->name('fillingreg');
        Route::put('/filling/{id}', 'filling')->name('filling');
        //Route::delete('/AirportDispach/{id}', 'destroy')->name('destroy');
    });
    Route::controller(SortingController::class)->name('cntpsort.')->group(function () {
        Route::get('/CntpEmssorting', 'index1')->name('CntpEmssorting');
        Route::get('/Cntppercelsorting', 'index2')->name('Cntppercelsorting');
        Route::get('/Cntpregisteredsorting', 'index3')->name('Cntpregisteredsorting');
        Route::get('/Cntpallmailssorting', 'index4')->name('Cntpallmailssorting');
        Route::get('/sortingemsview/{id}', 'viewemssort')->name('sortingemsview');
        Route::get('/sortingallmailsview/{id}', 'viewallmailssort')->name('sortingallmailsview');
        Route::get('/sortingpercelview/{id}', 'viewpercelsort')->name('sortingpercelview');
        Route::get('/sortingregisteredview/{id}', 'viewregisteredsort')->name('sortingregisteredview');
        Route::post('/storeemssort', 'storeemssort')->name('storeemssort');
        Route::post('/storepercelsort', 'storepercelsort')->name('storepercelsort');
        Route::post('/storeregisteredsort', 'storeregisteredsort')->name('storeregisteredsort');
        Route::post('/storeallmailssort', 'storeallmails')->name('storeallmailssort');



    });

    Route::controller(MailsTotalController::class)->name('totalm.')->group(function () {
        Route::get('/TotalMails', 'index')->name('TotalMails');
    });
    Route::controller(MailRegistrationController::class)->name('mails.')->group(function () {
        Route::get('/OrdinaryMail', 'index')->name('OrdinaryMail');
        Route::get('Ordregistration/{id}', 'registero')->name('Ordregistration');
        Route::post('/Ordinary', 'store')->name('store');
        Route::put('/Ordinary/{id}', 'update')->name('update');
        Route::delete('/Ordinary/{id}', 'destroy')->name('destroy');
    });
    Route::controller(PrintedMaterialController::class)->name('mailsprinted.')->group(function () {
        Route::get('/PrintedMaterial', 'index')->name('PrintedMaterial');
        Route::get('PrintedMaterialreg/{id}', 'registerpri')->name('PrintedMaterialreg');
        Route::post('/PrintedMaterials', 'store')->name('store');
        Route::put('/PrintedMaterialup/{id}', 'update')->name('update');
    });
    Route::controller(JurnalMailController::class)->name('mailsjurnal.')->group(function () {
        Route::get('/Jurnal', 'index')->name('Jurnal');
        Route::get('Jurnalreg/{id}', 'registerpri')->name('Jurnalreg');
        Route::post('/Jurnals', 'store')->name('store');
        Route::put('/Jurnalup/{id}', 'update')->name('update');
    });
    Route::controller(GoogleadMailController::class)->name('mailsgooglead.')->group(function () {
        Route::get('/Googlead', 'index')->name('Googlead');
        Route::get('Googleadreg/{id}', 'registerpri')->name('Googleadreg');
        Route::post('/Googles', 'store')->name('store');
        Route::put('/Googleup/{id}', 'update')->name('update');
    });
    Route::controller(PostCardMailController::class)->name('mailspostcard.')->group(function () {
        Route::get('/PostCard', 'index')->name('PostCard');
        Route::get('PostCardreg/{id}', 'registerpri')->name('PostCardreg');
        Route::post('/PostCards', 'store')->name('store');
        Route::put('/PostCardup/{id}', 'update')->name('update');
    });

    Route::controller(RegisterdMailController::class)->name('mailsr.')->group(function () {
        Route::get('/RegisteredMail', 'index')->name('RegisteredMail');
        Route::get('registration/{id}', 'registerre')->name('registration');
        Route::post('/RegisteredMail', 'store')->name('store');
        Route::put('/RegisteredMail/{id}', 'update')->name('update');
        Route::delete('/RegisteredMail/{id}', 'destroy')->name('destroy');
    });
    Route::controller(PercelMailController::class)->name('mailsp.')->group(function () {
        Route::get('/PercelMail', 'index')->name('PercelMail');
        Route::get('PercelMails/{id}', 'registerp')->name('PercelMails');
        Route::post('/PercelMail', 'store')->name('store');
        Route::put('/PercelMail/{id}', 'update')->name('update');
        Route::delete('/PercelMail/{id}', 'destroy')->name('destroy');
    });
    Route::controller(EmsMailController::class)->name('mailsem.')->group(function () {
        Route::get('/EmsMail', 'index')->name('EmsMail');
        Route::get('EmsMails/{id}', 'registerem')->name('EmsMails');
        Route::post('/EmsMail', 'store')->name('store');
        Route::put('/EmsMail/{id}', 'update')->name('update');
        Route::delete('/EmsMail/{id}', 'destroy')->name('destroy');
    });
    Route::controller(RegisteredLetterController::class)->name('mailsrl.')->group(function () {
        Route::get('/RegisteredLetter', 'index')->name('RegisteredLetter');
        Route::get('RegisteredLetters/{id}', 'registerrl')->name('RegisteredLetters');
        Route::post('/RegisteredLetter', 'store')->name('store');
        Route::put('/RegisteredLetter/{id}', 'update')->name('update');
        Route::delete('/RegisteredLetter/{id}', 'destroy')->name('destroy');
    });
    Route::controller(OrdinaryLetterController::class)->name('mailsol.')->group(function () {
        Route::get('/OrdinaryLetter', 'index')->name('OrdinaryLetter');
        Route::get('OrdinaryLetters/{id}', 'registerol')->name('OrdinaryLetters');
        Route::post('/OrdinaryLetter', 'store')->name('store');
        Route::put('/OrdinaryLetter/{id}', 'update')->name('update');
        Route::delete('/OrdinaryLetters/{id}', 'destroy')->name('destroy');
    });
    Route::controller(OrdinaryMailTransferController::class)->name('transfero.')->group(function () {
        Route::get('/OrdinaryMailTransfer', 'index')->name('OrdinaryMailTransfer');
        Route::get('OrdinaryMailTransfers/{id}', 'registerto')->name('OrdinaryMailTransfers');
        Route::post('Ordinarytransfernumber', 'ordinarytrn')->name('Ordinarytransfernumber');
        Route::post('/OrdinaryMailTransfer', 'store')->name('store');
        Route::get('/OrdinaryMailTransferss/invoicereg/{idd}', 'invoicereg')->name('invoicereg');
    });

    Route::controller(RegisteredMailTransferController::class)->name('transferr.')->group(function () {
        Route::get('/RegisteredMailTransfer', 'index')->name('RegisteredMailTransfer');
        Route::get('RegisteredMailTransfers/{id}', 'registertr')->name('RegisteredMailTransfers');
        Route::post('/RegisteredMailTransfer', 'store')->name('store');
        Route::post('/RegisteredMailTransfernumber', 'registertrn')->name('registertranumber');
        Route::get('/RegisteredMailTransferss/invoicereg/{id}', 'invoicereg')->name('invoicereg');
    });
    Route::controller(PrintedMaterialTransferController::class)->name('transferprinted.')->group(function () {
        Route::get('/PrintedMaterialTransfer', 'index')->name('PrintedMaterialTransfer');
        Route::get('PrintedMaterialTransfers/{id}', 'registertr')->name('PrintedMaterialTransfers');
        Route::post('/PrintedMaterialTransfer', 'store')->name('store');
        Route::post('/PrintedMaterialTransfernumber', 'printedn')->name('printedtranumber');
        Route::get('/PrintedMaterialTransferss/invoiceprinted/{id}', 'invoiceprinted')->name('invoiceprinted');
    });
    Route::controller(JurnalTransferController::class)->name('transferjurnal.')->group(function () {
        Route::get('/JurnalTransfer', 'index')->name('JurnalTransfer');
        Route::get('JurnalTransfers/{id}', 'registertr')->name('JurnalTransfers');
        Route::post('/JurnalTransfer', 'store')->name('store');
        Route::post('/JurnalTransfernumber', 'jurnaltn')->name('jurnaltranumber');
        Route::get('/JurnalTransferss/invoicejurnal/{id}', 'invoicejurnal')->name('invoicejurnal');
    });
    Route::controller(GoogleadTransferController::class)->name('transfergooglead.')->group(function () {
        Route::get('/GoogleadTransfer', 'index')->name('GoogleadTransfer');
        Route::get('GoogleTransfers/{id}', 'registertr')->name('GoogleTransfers');
        Route::post('/GoogleTransfer', 'store')->name('store');
        Route::post('/GoogleadTransfernumber', 'googletn')->name('googletranumber');
        Route::get('/GoogleTransferss/invoicegooglead/{id}', 'invoicegooglead')->name('invoicegooglead');
    });
    Route::controller(PostCardTransferMailController::class)->name('transferpostcard.')->group(function () {
        Route::get('/PostCardTransfer', 'index')->name('PostCardTransfer');
        Route::get('PostCardTransfers/{id}', 'registertr')->name('PostCardTransfers');
        Route::post('/PostCardTransfer', 'store')->name('store');
        Route::post('/PostCardTransfernumber', 'posttn')->name('posttranumber');
        Route::get('/PostCardTransferss/invoicepostcard/{id}', 'invoicepostcard')->name('invoicepostcard');
    });

    Route::controller(EmsMailTransferController::class)->name('transferem.')->group(function () {
        Route::get('/EmsMailTransfer', 'index')->name('EmsMailTransfer');
        Route::get('EmsMailTransfers/{id}', 'registertr')->name('EmsMailTransfers');
        Route::post('/EmsMailTransfer', 'store')->name('store');
        Route::post('/EmsMailTransfernumber', 'storeems')->name('storeems');
        Route::get('/EmsMailTransferss/invoicereg/{idd}', 'invoicereg')->name('invoicereg');
    });
    Route::controller(PercelMailTransferController::class)->name('transferp.')->group(function () {
        Route::get('/PercelMailTransfer', 'index')->name('PercelMailTransfer');
        Route::get('PercelMailTransfers/{id}', 'registertr')->name('PercelMailTransfers');
        Route::post('/PercelMailTransfer', 'store')->name('store');
        Route::post('/PercelMailTransfers', 'storen')->name('storen');
        Route::get('/PercelMailTransferss/invoicereg/{idd}', 'invoicereg')->name('invoicereg');
    });
    Route::controller(RegisteredLetterTransferController::class)->name('transferrl.')->group(function () {
        Route::get('/RegisteredLetterTransfer', 'index')->name('RegisteredLetterTransfer');
        Route::get('RegisteredLetterTransfers/{id}', 'registertr')->name('RegisteredLetterTransfers');
        Route::post('/RegisteredLetterTransfers', 'store')->name('store');
        Route::get('/RegisteredLetterTransferss/invoicereg/{idd}', 'invoicereg')->name('invoicereg');
        Route::post('/LetterreMailTransfers', 'storeletterreg')->name('storeletterreg');
    });


    Route::controller(OrdinaryLetterTransferController::class)->name('transferol.')->group(function () {
        Route::get('/OrdinaryLetterTransfer', 'index')->name('OrdinaryLetterTransfer');
        Route::get('OrdinaryLetterTransfers/{id}', 'registertr')->name('OrdinaryLetterTransfers');
        Route::post('/OrdinaryLetterTransfer', 'store')->name('store');
        Route::get('/OrdinaryLetterTransferss/invoiceod/{idd}', 'invoiceod')->name('invoiceod');
        Route::post('/LetterodMailTransfers', 'storeletterod')->name('storeletterod');
    });
    Route::controller(DispachRecievingController::class)->name('dreceive.')->group(function () {
        Route::get('/Depechereceive', 'index')->name('Depechereceive')->middleware('can:Read Dispach Recieving');
        Route::get('Receive/{id}', 'Receivet')->name('Receive');
        Route::put('/updd/{id}', 'update')->name('update');
        Route::put('/Dispachdp/{id}', 'storepb')->name('Dispachdp');
        Route::put('/Dispachdo/{id}', 'storeoma')->name('Dispachdo');
        Route::put('/Dispachdr/{id}', 'storerm')->name('Dispachdr');
        Route::put('/Dispachdems/{id}', 'storeems')->name('Dispachdems');
        Route::put('/Dispachdpostal/{id}', 'storepostalcard')->name('Dispachdpostal');
        Route::put('/Dispachdgooglead/{id}', 'storegooglead')->name('Dispachdgooglead');
        Route::put('/Dispachdjurnal/{id}', 'storejurnal')->name('Dispachdjurnal');
        Route::put('/Dispachdprinted/{id}', 'storeprinted')->name('Dispachdprinted');
        Route::put('/Dispachdletter/{id}', 'storeletterod')->name('storeletterod');
        Route::put('/Dispachdletterr/{id}', 'storeletterodreg')->name('Dispachdletterr');
    });
    Route::controller(MailRcsnController::class)->name('mrcsn.')->group(function () {
        Route::get('/Mailcheckingandnotification', 'index')->name('Mailcheckingandnotification');
        Route::put('/mailcheckingandnotification/{id}', 'update')->name('update');
        Route::get('rcsnotification/{id}', 'index1')->name('rcsnotification');
        Route::put('smsnotification/{id}', 'notify')->name('smsnotification');


    });

    Route::controller(MailListController::class)->name('list.')->prefix('inboxing')->group(function () {
        Route::get('/search', 'all')->name('search');
        Route::get('/MailList/{id}', 'detail')->name('detail');
        Route::put('/notify/{id}', 'notify')->name('notify');
    });

    Route::controller(MailPaymentController::class)->name('pay.')->group(function () {
        Route::get('/Omailpay', 'index')->name('Omailpay');
        Route::put('storeo/{id}', 'store')->name('storeo');

    });
    Route::controller(RegisteredMailPaymentController::class)->prefix('registed-mails')->name('payr.')->group(function () {
        Route::get('/Rmailpay', 'index')->name('Rmailpay');
        Route::put('storer/{id}', 'store')->name('storer');

    });
    Route::controller(GoogleadPaymentMailController::class)->name('payg.')->group(function () {
        Route::get('/Googlepay', 'index')->name('Googlepay');
        Route::put('storer/{id}', 'store')->name('storer');


    });


    Route::controller(PercelMailPaymentController::class)->name('payp.')->group(function () {
        Route::get('/Pmailpay', 'index')->name('Pmailpay');
        Route::put('store/{id}', 'store')->name('store');

    });
    Route::controller(MailDeliveryController::class)->name('mailde.')->group(function () {
        Route::get('/Maildelevery', 'index')->name('Maildelevery');
        Route::get('/Maildeleveryss/invoice/{cid}', 'invoice')->name('invoice');

        Route::get('inboxing/reports', 'reports')->name('reports');
        Route::get('inboxing/emsReports', 'emsReports')->name('emsReports');
    });
    Route::controller(OridinaryMailIcomeController::class)->name('income.')->group(function () {
        Route::get('/Oincames', 'index')->name('Oincames');

        Route::get('transactionomail/{pdate}', 'transactiono')->name('transactionomail');


    });
    Route::controller(RegisteredMailIncomeController::class)->name('incomer.')->group(function () {
        Route::get('/Rincames', 'index')->name('Rincames');

        Route::get('transactionrmail/{pdate}', 'transactionr')->name('transactionrmail');

    });
    Route::controller(PercelMailIncomeController::class)->name('incomep.')->group(function () {
        Route::get('/Pincames', 'index')->name('Pincames');

        Route::get('transactionpmail/{pdate}', 'transactionp')->name('transactionpmail');
    });
    Route::controller(GoogleadIncomeMailController::class)->name('incomegoogle.')->group(function () {
        Route::get('/Gincames', 'index')->name('Gincames');
        Route::get('transactiongooglemail/{pdate}', 'transactiongoogle')->name('transactiongooglemail');
    });
    Route::controller(VehicleController::class)->name('vehicle.')->group(function () {
        Route::get('/Vehicles', 'index')->name('Vehicles');
        Route::get('/Assign', 'index1')->name('Assign');
        Route::post('/vehicles', 'store')->name('store');
        Route::put('/Vehiclesup/{id}', 'update')->name('update');
        Route::put('/Vehiclesassign/{id}', 'assign')->name('Vehiclesassign');
        Route::put('/Vehiclesreassign/{id}', 'reassign')->name('Vehiclesreassign');
        Route::delete('/Vehiclesdel/{id}', 'destroy')->name('destroy');

    });
    Route::controller(Servicecontroller::class)->name('serv.')->group(function () {
        Route::get('/Service', 'index')->name('Service');
        Route::post('/Services', 'store')->name('store');
        Route::put('/Servicesup/{servty_id}', 'update')->name('update');
        Route::delete('/Servicedel/{servty_id}', 'destroy')->name('destroy');
    });
    Route::controller(ServiceCustomercontroller::class)->name('cust.')->group(function () {
        Route::get('/Customers', 'index')->name('Customers');
        Route::post('/Customers', 'store')->name('store');
        Route::put('/update/{token_id}', 'update')->name('update');
        Route::delete('/Customersdel/{token_id}', 'destroy')->name('destroy');
    });
    Route::controller(EmsCountryRegcontroller::class)->name('countri.')->group(function () {
        Route::get('/Countries', 'index')->name('Countries');
        Route::post('/Countries', 'store')->name('store');
        Route::put('/Countriesup/{c_id}', 'update')->name('update');
        Route::delete('/Countriesdel/{c_id}', 'destroy')->name('destroy');
    });
    Route::controller(EmsCountryZoneRegcontroller::class)->name('zone.')->group(function () {
        Route::get('/Zones', 'index')->name('Zones');
        Route::post('/Zones', 'store')->name('store');
        Route::put('/Zonesup/{zone_id}', 'update')->name('update');
        Route::delete('/Zonedel/{zone_id}', 'destroy')->name('destroy');
        Route::get('zonecountries/{zone_id}', 'viewcountryzone')->name('zonecountries');
        Route::post('/CZones', 'storeczone')->name('storeczone');
        Route::delete('/CZonedel/{cz_id}', 'destroy1')->name('destroy1');

    });
    Route::controller(EmsWeightRangeRegcontroller::class)->name('range.')->group(function () {
        Route::get('/ranges', 'index')->name('ranges');
        Route::post('/ranges', 'store')->name('store');
        Route::put('/rangesup/{id}', 'update')->name('update');
        Route::delete('/rangesdel/{id}', 'destroy')->name('destroy');
    });
    Route::controller(EmstarifRegcontroller::class)->name('czone.')->group(function () {
        Route::get('/czoness', 'index')->name('czoness');
        Route::post('/czoness', 'store')->name('store');
        Route::put('/czoness/{id}', 'update')->name('update');
        Route::delete('/czoness/{id}', 'destroy')->name('destroy');
        Route::get('czonetarif/{zone_id}/{servty_id}', 'CzTarifController')->name('czonetarif');
        Route::post('/storetarif', 'storetarif')->name('storetarif');
        Route::put('/storetarifup/{tarif_id}', 'updatetar')->name('storetarifup');

    });
    Route::controller(RSPACountryRegcontroller::class)->name('regcountries.')->group(function () {
        Route::get('/countriesview', 'index')->name('countriesview');
        Route::post('/countriesreg', 'store')->name('store');
        Route::put('/countriesup/{cont_id}', 'update')->name('update');
        Route::delete('/countriesdel/{cont_id}', 'destroy')->name('destroy');

    });
    Route::controller(RSPAWeightrangeRegcontroller::class)->name('prange.')->group(function () {
        Route::get('/pranges', 'index')->name('pranges');
        Route::post('/pranges', 'store')->name('store');
        Route::put('/prangesup/{id}', 'update')->name('update');
        Route::delete('/prangesdel/{id}', 'destroy')->name('destroy');
    });
    Route::controller(RSPATarifRegcontroller::class)->name('rspatreg.')->group(function () {
        Route::get('/rspatregs', 'index')->name('rspatregs');
        Route::post('/rspatregs', 'store')->name('store');
        Route::put('/rspatregs/{id}', 'update')->name('update');
        Route::delete('/rspatregs/{id}', 'destroy')->name('destroy');
        Route::get('rspatregview/{cont_id}/{servty_id}', 'RspaTarifController')->name('rspatregview');
        Route::post('/rspatregss', 'storetarifp')->name('storetarifp');
        Route::put('/rspatregup/{tarif_id}', 'updatetar')->name('rspatregup');

    });
    Route::controller(PercelCountryRegController::class)->name('percecountreg.')->group(function () {
        Route::get('/percecountregs', 'index')->name('percecountregs');
        Route::post('/percecountregs', 'store')->name('store');
        Route::put('/percecountregs/{pc_id}', 'update')->name('update');
        Route::delete('/percecountregs/{pc_id}', 'destroy')->name('destroy');
    });
    Route::controller(PercelWeightRegController::class)->name('pweight.')->group(function () {
        Route::get('/pweights', 'index')->name('pweights');
        Route::post('/pweights', 'store')->name('store');
        Route::put('/pweights/{id}', 'update')->name('update');
        Route::delete('/pweights/{id}', 'destroy')->name('destroy');

    });
    Route::controller(PercelTarifRegController::class)->name('perceltreg.')->group(function () {
        Route::get('/perceltregs', 'index')->name('perceltregs');
        Route::post('/perceltregs', 'store')->name('store');
        Route::put('/perceltregs/{prt_id}', 'update')->name('update');
        Route::delete('/perceltregs/{id}', 'destroy')->name('destroy');
        Route::get('perceltregview/{pc_id}/{servty_id}', 'PercelTarifController')->name('perceltregview');
        Route::post('/perceltregss', 'storetarifp')->name('perceltregss');

    });
    Route::controller(OutboxingTransfercontroller::class)->name('outte.')->prefix('outboxing-transfer')->group(function () {
        Route::get('/ems', 'ems')->name('ems')->middleware('can:make outboxing');
        Route::get('/registerd', 'registerd')->name('registerd')->middleware('can:make outboxing');
        Route::get('/percel', 'percel')->name('percel')->middleware('can:make outboxing');
        Route::post('/store', 'store')->name('store');
    });
    Route::controller(RegisteredoutboxingTransfercontroller::class)->name('outtr.')->group(function () {
        Route::get('/transfer/Registered', 'index')->name('index')->middleware('can:make outboxing');
        Route::post('/RegisteredTransferout', 'store')->name('store');
    });
    Route::controller(PerceloutboxingTransfercontroller::class)->name('outtp.')->group(function () {
        Route::get('/transfer/Percel', 'index')->name('index')->middleware('can:make outboxing');
        Route::post('/Perceltransferout', 'store')->name('store');
    });
    Route::controller(PostingwithtembleoutboxingTransfercontroller::class)->name('outtte.')->group(function () {
        Route::get('/transfer/Temblepost', 'index')->name('index')->middleware('can:make outboxing');
        Route::post('/Tembletransferout', 'store')->name('store');
    });
    Route::controller(CNTPEmsOutboxingcontroller::class)->name('outtems.')->group(function () {
        Route::get('/Outboxing/receiveems', 'index')->name('outboxingems');
        Route::get('/reportoutboxingems', 'dailyreport')->name('reportoutboxingems');
        Route::get('/outbox/detailsems/{pdate}', 'dailyreout')->name('detailsems');
        Route::get('/Outboxing/ViewEMS/{id}', 'index2')->name('viewems');
        Route::put('/receiveemsout/{id}', 'update')->name('update');
        Route::put('/receiveems-verify/{id}', 'verify')->name('verify');
    });
    Route::controller(CNTPRegisteredOutboxingcontroller::class)->name('outtregis.')->group(function () {
        Route::get('/Outboxing/receiveregistered', 'index')->name('outboxingregistered');
        Route::get('/reportoutboxingregise', 'dailyreport')->name('detailsregistered');
        Route::get('/outbox/detailsregisteredre/{pdate}', 'dailyreout')->name('detailsregisteredre');
        Route::get('/Outboxing/ViewRegistered{id}', 'index2')->name('viewregistered');
        Route::put('/receiveregistered/{id}', 'update')->name('update');
    });
    Route::controller(CNTPPercelOutboxingcontroller::class)->name('outtperc.')->group(function () {
        Route::get('/Outboxing/receivepercel', 'index')->name('outboxingpercel');
        Route::get('/perceloutboxingregise', 'dailyreport')->name('perceloutboxingregise');
        Route::get('/outbox/detailspercelre/{pdate}', 'dailyreout')->name('detailspercelre');
        Route::get('/Outboxing/ViewPercel{id}', 'index2')->name('viewpercel');
        Route::put('/receivepercel/{id}', 'update')->name('update');
    });
    Route::controller(CNTPTembleOutboxingcontroller::class)->name('outttem.')->group(function () {
        Route::get('/Outboxing/receivetemble', 'index')->name('outboxingtemble');
        Route::get('/tembleoutboxingrep', 'dailyreport')->name('tembleoutboxingrep');
        Route::get('/outbox/detailstemble/{pdate}', 'dailyreout')->name('detailstemble');
        Route::get('/Outboxing/ViewTemble{id}', 'index2')->name('viewtemble');
        Route::put('/receivetemble/{id}', 'update')->name('update');
    });
    Route::controller(EmsMailPaymentcontroller::class)->name('emspay.')->group(function () {
        Route::get('/emspays', 'index')->name('emspays');
        Route::put('storeems/{id}', 'store')->name('storeems');

    });
    Route::controller(EmsMailIncomecontroller::class)->name('incomeems.')->group(function () {
        Route::get('/incomeemss', 'index')->name('incomeemss');
        Route::put('Submitomail/{pdate}', 'submito')->name('Submitomail');
        Route::get('transactionems/{pdate}', 'transactionems')->name('transactionems');
    });
    Route::controller(CombinedTableController::class)->name('combined.')->group(function () {
        Route::get('/combined-report', 'index')->name('index');
        Route::get('transactionallrep/{rvdate}', 'index1')->name('transactionallrep');
    });
    Route::controller(CommentController::class)->name('comments.')->group(function () {
        Route::get('/Comment', 'index')->name('Comment');
        Route::post('/store', 'store')->name('store');
        Route::put('/updates/{id}', 'update')->name('updates');
    });



});




