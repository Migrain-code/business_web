<?php

use App\Http\Controllers\Business\Auth\LoginController;
use App\Http\Controllers\Business\Customer\CustomerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\AjaxController;
use \App\Http\Controllers\Business\Customer\CustomerInfoController;
use App\Http\Controllers\Business\ProductSale\ProductSaleController;
use App\Http\Controllers\Business\Product\ProductController;
use \App\Http\Controllers\Business\PackageSale\PackageSaleController;
use App\Http\Controllers\Business\PackageSale\PackageSaleOperationController;
use \App\Http\Controllers\Business\Personel\PersonelController;
use App\Http\Controllers\Business\Appointment\AppointmentController;
use App\Http\Controllers\Business\Appointment\AppointmentServicesController;
use App\Http\Controllers\Business\Appointment\AppointmentCreateController;
use \App\Http\Controllers\Business\Service\ServiceController;
use \App\Http\Controllers\Business\Adission\AdissionController;
use \App\Http\Controllers\Business\Adission\AdissionProductSaleController;
use App\Http\Controllers\Business\Adission\AdissionPaymentController;
use App\Http\Controllers\Business\Adission\AdissionAddCashPointController;
use App\Http\Controllers\Business\SupportCenter\SupportController;
use App\Http\Controllers\Business\SupportCenter\SupportOptionController;
use App\Http\Controllers\Business\Case\CaseController;
use App\Http\Controllers\Business\Case\PrimController;
use \App\Http\Controllers\Business\Branche\BusinessBrancheController;
use App\Http\Controllers\Business\Official\BusinessOfficialController;
use \App\Http\Controllers\Business\Promossion\BusinessPromossionController;
use \App\Http\Controllers\Business\Notification\NotificationController;
use App\Http\Controllers\Business\Notification\BusinessNotificationPermissionController;
use App\Http\Controllers\Business\Gallery\GalleryController;
use \App\Http\Controllers\Business\Gallery\CustomerGalleryController;
use App\Http\Controllers\Business\Cost\BusinessCostController;
use App\Http\Controllers\Business\Receivable\AppointmentReceivableController;
use App\Http\Controllers\Business\Deps\BusinessDepController;
use \App\Http\Controllers\Business\Personel\PersonelStayOffDayController;
use \App\Http\Controllers\Business\Subscription\SubscribtionController;
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

Route::get('/', [HomeController::class, 'index']);
Route::get('/ozellikler', [HomeController::class, 'proparties'])->name('proparties');
Route::get('/ozellik/{slug}/detay', [HomeController::class, 'propartieDetail'])->name('propartie.detail');
Route::get('/fiyatlandirma', [HomeController::class, 'prices'])->name('prices');
Route::get('/referanslar', [HomeController::class, 'references'])->name('references');
Route::get('/bloglar', [HomeController::class, 'blogs'])->name('blogs');
Route::get('/blog/{slug}', [HomeController::class, 'blogDetail'])->name('blogs.detail');
Route::get('/sss', [HomeController::class, 'faq'])->name('faq');

Route::post('information-request', [HomeController::class, 'informationRequest'])->name('send.informationRequest');
Route::get('login', [HomeController::class, 'loginTypes'])->name('loginTypes');

Route::prefix('isletme')->as('business.')->group(function (){
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:official')->group(function () {
        Route::get('/home', [\App\Http\Controllers\Business\HomeController::class, 'index'])->name('home');
        /*-----------------------  Müşteri  ------------------------*/
        Route::resource('customer', CustomerController::class);
        Route::prefix('customer/{customer}')->group(function (){
            Route::get('cash-point-list', [CustomerInfoController::class, 'cashPointList']);
            Route::get('product-sale-list', [CustomerInfoController::class, 'productSaleList']);
            Route::get('package-sale-list', [CustomerInfoController::class, 'packageSaleList']);
            Route::get('receivable-list', [CustomerInfoController::class, 'receivableList']);
            Route::get('payment-list', [CustomerInfoController::class, 'payments']);
            Route::get('gallery', [CustomerInfoController::class, 'gallery']);
            Route::post('add-gallery', [CustomerInfoController::class, 'addGallery']);
        });
        /*-----------------------  Ürünler ------------------------*/
        Route::resource('product', ProductController::class);
        /*-----------------------  Ürün Satış ------------------------*/
        Route::resource('sale', ProductSaleController::class);

        /* ---------------------- Paket Satışı --------------------------------------- */
        Route::resource('package-sale', PackageSaleController::class);

        Route::prefix('package-sale/{packageSale}')->as('packageSale.')->group(function () {
            Route::get('/payments', [PackageSaleOperationController::class, 'payments']);
            Route::get('/usages', [PackageSaleOperationController::class, 'usages']);

            Route::post('/add-payment', [PackageSaleOperationController::class, 'paymentsAdd']);
            Route::post('/add-usage', [PackageSaleOperationController::class, 'usagesAdd']);
            Route::post('/add-policy', [PackageSaleOperationController::class, 'addPolicy'])->name('addPolicy');
        });
        Route::delete('package-sale/{packagePayment}/delete-payment', [PackageSaleOperationController::class, 'deletePayment']);
        Route::delete('package-sale/{packageUsage}/delete-usage', [PackageSaleOperationController::class, 'deleteUsage']);

        /* -------------------- Personeller --------------------------*/
        Route::resource('personel', PersonelController::class);
        Route::prefix('personel/{personel}')->as('personel.')->group(function (){
           Route::get('case', [PersonelController::class, 'case'])->name('case');//kasa
           Route::get('payments', [PersonelController::class, 'payments'])->name('payments');//ödemeler
           Route::post('/add-payment', [PersonelController::class, 'paymentsAdd']);//ödeme ekle
           Route::get('stay-off-day', [PersonelController::class, 'stayOffDays'])->name('stayOffDays');//izin günleri
           Route::post('add-stay-off-day', [PersonelController::class, 'addStayOffDays']);//izin günü ekle
           Route::get('notification', [PersonelController::class, 'notifications'])->name('notifications');
           Route::post('add-notification', [PersonelController::class, 'sendNotify']);
           Route::get('setting', [PersonelController::class, 'setting'])->name('setting');

        });
        /* -------------------- Hizmetler --------------------------*/
        Route::resource('service', ServiceController::class);

        /* -------------------- Randevular --------------------------*/

        Route::resource('appointment', AppointmentController::class);
        Route::post('appointment/{appointment}/service', [AppointmentServicesController::class,'store'])->name('appointment.service.add');
        Route::delete('appointmentServices/{appointmentServices}', [AppointmentServicesController::class,'destroy'])->name('appointment.service.destroy');

        /* -------------------- Randevu Oluşturma --------------------------*/
        Route::prefix('appointment-create')->as('appointmentCreate.')->controller(AppointmentCreateController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('get/services', 'getService');
            Route::get('get/customers', 'getCustomer');
            Route::post('get/personel', 'getPersonel');
            Route::get('get/date', 'getDate');
            Route::post('get/clock', 'getClock');
            Route::post('/store', 'appointmentCreate')->name('store');
            Route::post('/summary', 'summary');
        });

        /* -------------------- Adisyonlar --------------------------*/
        Route::resource('adission', AdissionController::class);
        Route::prefix('adission')->as('adission.')->group(function () {

            Route::get('/{adission}/sale/datatable', [AdissionProductSaleController::class, 'index'])->name('sale.datatable');
            Route::get('/{adission}/sale/create', [AdissionProductSaleController::class, 'create']);
            Route::post('/{adission}/sale/add', [AdissionProductSaleController::class, 'store'])->name('sale.add');

            Route::get('/{adission}/payment', [AdissionPaymentController::class, 'index']);//tahsilat listesi
            Route::post('/{adission}/payment/add', [AdissionPaymentController::class, 'store']);//tahsilat ekle
            Route::delete('/{adission}/payment/{payment}', [AdissionPaymentController::class, 'destroy']);//tahsilat sil

            Route::post('/{adission}/payment/save', [AdissionPaymentController::class, 'paymentSave']);
            Route::get('/{adission}/payment/close', [AdissionPaymentController::class, 'closePayment'])->name('paymentClose');

            //Parapuan Kullan
            Route::get('/{adission}/cash-point', [AdissionAddCashPointController::class, 'index']);
            Route::post('/{adission}/cash-point', [AdissionAddCashPointController::class, 'store'])->name('cashPoint.add');

            //Alacak Ekle
            Route::get('/{adission}/receivable', [AdissionAddCashPointController::class, 'receivableList']);
            Route::post('/{adission}/receivable', [AdissionAddCashPointController::class, 'receivableAdd']);
            Route::delete('/{adission}/receivable/{receivable}', [AdissionAddCashPointController::class, 'receivableDelete']);
        });

        /* -------------------- Destek Talepleri --------------------------*/

        Route::resource('support-center', SupportController::class);
        Route::prefix('support')->as('support.')->group(function (){
            Route::get('tutorial', [SupportOptionController::class, 'tutorials'])->name('tutorials');
            Route::get('sss', [SupportOptionController::class, 'faq'])->name('faq');
            Route::get('documents', [SupportOptionController::class, 'document'])->name('document');
            Route::get('documents/folder/{documentFolder}', [SupportOptionController::class, 'files'])->name('document.folder');
        });

        /* -------------------- Kasa --------------------------*/
        Route::get('case', [CaseController::class, 'index'])->name('case');
        /* -------------------- Prim --------------------------*/
        Route::get('prim', [PrimController::class, 'index'])->name('prim');

        /* -------------------- Şubeler --------------------------*/
        Route::resource('branche', BusinessBrancheController::class);

        /* -------------------- Yetkililer --------------------------*/
        Route::resource('business-official', BusinessOfficialController::class);

        /* -------------------- Promosyonlar --------------------------*/
        Route::resource('promossion', BusinessPromossionController::class);

        /* -------------------- Bildirimler --------------------------*/
        Route::resource('notifications', NotificationController::class);

        /* -------------------- Bildirim İzinleri --------------------------*/
        Route::resource('notification-permission', BusinessNotificationPermissionController::class);

        /* -------------------- İşletme Galerisi --------------------------*/
        Route::resource('gallery', GalleryController::class);

        /* -------------------- Müşteri Galerisi --------------------------*/
        Route::resource('customer-gallery', CustomerGalleryController::class);

        /* -------------------- Masraflar --------------------------*/
        Route::resource('cost', BusinessCostController::class);

        /* -------------------- Alacaklar --------------------------*/
        Route::resource('receivable', AppointmentReceivableController::class);

        /* -------------------- Borçlar --------------------------*/
        Route::resource('dep', BusinessDepController::class);

        /* -------------------- Personel İzin Günleri --------------------------*/
        Route::resource('personel-stay-off-day', PersonelStayOffDayController::class);

        /* -------------------- Abonelik Özeti --------------------------*/
        Route::get('abonelik', [SubscribtionController::class, 'index'])->name('subscription.index');

        /* -------------------- Global Ajax İstekleri --------------------------*/
        Route::post('password-update', [BusinessOfficialController::class, 'passwordUpdate'])->name('passwordUpdate');

        Route::controller(AjaxController::class)->as('ajax.')->prefix('ajax')->group(function () {
            Route::post('/update-featured', 'updateFeatured')->name('updateFeatured');
            Route::delete('/delete/object', 'deleteFeatured')->name('deleteFeatured');
            Route::post('/delete/all/object', 'deleteAllFeatured')->name('deleteAllFeatured');
            Route::post('/get/district', 'getDistrict')->name('getDistrictUrl');
        });
    });


});

