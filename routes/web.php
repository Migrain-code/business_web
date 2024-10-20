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
use \App\Http\Controllers\Business\Auth\RegisterController;
use \App\Http\Controllers\Business\Auth\VerificationController;
use \App\Http\Controllers\Business\Auth\ForgotPasswordController;
use \App\Http\Controllers\Business\SetupController;
use \App\Http\Controllers\DetailSetupController;
use \App\Http\Controllers\AppointmentRequestFormController;
use App\Http\Controllers\Business\Form\BusinessAppointmentRequestController;
use App\Http\Controllers\PacketOrderController;
use App\Http\Controllers\PaymentController;
use \App\Http\Controllers\PersonelCustomerPriceListController;
use \App\Http\Controllers\OfficialSettingController;
use \App\Http\Controllers\BusinessCloseDateController;
use App\Http\Controllers\PersonelWorkTimeController;
use App\Http\Controllers\Business\Auth\TwoFactorVerificationController;
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

include "guards/personel.php";
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/test', function (){
    return view('test');
});
Route::get('/ozellikler', [HomeController::class, 'proparties'])->name('proparties');
Route::get('/biz-kimiz', [HomeController::class, 'about'])->name('about');
Route::get('/iletisim', [HomeController::class, 'contact'])->name('contact');
Route::post('/iletisim/yeni-talep', [HomeController::class, 'contactRequest'])->name('contact.request');
Route::get('/ozellik/{slug}/detay', [HomeController::class, 'propartieDetail'])->name('propartie.detail');
Route::get('/fiyatlandirma', [HomeController::class, 'prices'])->name('prices');
Route::get('/referanslar', [HomeController::class, 'references'])->name('references');
Route::get('/bloglar', [HomeController::class, 'blogs'])->name('blogs');
Route::get('/blog/category/{category}', [HomeController::class, 'category'])->name('blogs.category');
Route::get('/blog/{slug}', [HomeController::class, 'blogDetail'])->name('blogs.detail');
Route::get('/sss', [HomeController::class, 'faq'])->name('faq');

Route::post('information-request', [HomeController::class, 'informationRequest'])->name('send.informationRequest');
Route::get('login', [HomeController::class, 'loginTypes'])->name('loginTypes');

Route::prefix('isletme')->as('business.')->group(function (){
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register/request', [RegisterController::class, 'register'])->name('register.request');

    Route::get('verify', [VerificationController::class, 'show'])->name('showVerify');
    Route::post('verify/request', [VerificationController::class, 'verify'])->name('verify');

    Route::get('/sifremi-unuttum', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('showForgotForm');
    Route::post('/sifremi-unuttum-send-code', [ForgotPasswordController::class, 'sendResetVerifyCode'])->name('sendResetVerifyCode');

    Route::get('/telefon-numarasi-dogrulama', [ForgotPasswordController::class, 'showResetPassword'])->name('verify.showResetPassword');
    Route::post('/sifremi-unuttum-dogrulama', [ForgotPasswordController::class, 'verifyResetPassword'])->name('verify.resetPassword');
    Route::get('/sifremi-unuttum-dogrulama-tekrar-gönder', [ForgotPasswordController::class, 'verifyResetRepeatPassword'])->name('verify.repeatPassword');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/packet/{packet}/callback/{official}', [PaymentController::class, 'callback'])->name('packet.payment.callback');
    Route::get('generate/invoice/{invoice}/pdf', [\App\Http\Controllers\PdfController::class, 'generatePdf'])->name('generateInvoice');

    Route::get('two-factor-verification', [TwoFactorVerificationController::class, 'show'])->name('twoFactorVerification.show');
    Route::post('two-factor-verification/verify', [TwoFactorVerificationController::class, 'verify'])->name('twoFactorVerification.verify');
    Route::post('two-factor-verification/resend', [TwoFactorVerificationController::class, 'resendCode'])->name('twoFactorVerification.resend');

    Route::middleware(['auth:official', 'setup', 'twoFactor'])->group(function () {
        Route::get('/home', [\App\Http\Controllers\Business\HomeController::class, 'index'])->name('home');

        /*-----------------------  Setup  ------------------------*/
        Route::prefix('setup')->as('setup.')->group(function (){
            Route::get('/step-1', [SetupController::class, 'step1'])->name('step1');
            Route::get('/step/pass', [SetupController::class, 'stepPass'])->name('pass');
            Route::get('/step/set', [SetupController::class, 'setSetup'])->name('setSetup');
            Route::post('/step-1', [SetupController::class, 'step1Update']);
            Route::post('/step-2', [SetupController::class, 'step2Update']);
            Route::post('/step-3', [SetupController::class, 'step3Update']);
            Route::post('/step-4', [SetupController::class, 'step4Update']);

        });
        Route::prefix('detail-setup')->as('detailSetup.')->group(function (){
            Route::get('/', [DetailSetupController::class, 'detailSetup'])->name('step2');
            Route::post('/step-1', [DetailSetupController::class, 'detailSetupStep1']);
        });
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
           Route::get('services', [PersonelController::class, 'services'])->name('services');//hizmetler
           Route::post('services/update', [PersonelController::class, 'updateServices'])->name('services.update');//hizmetler
           Route::post('/add-payment', [PersonelController::class, 'paymentsAdd']);//ödeme ekle
           Route::get('stay-off-day', [PersonelController::class, 'stayOffDays'])->name('stayOffDays');//izin günleri
           Route::post('add-stay-off-day', [PersonelController::class, 'addStayOffDays']);//izin günü ekle
           Route::get('notification', [PersonelController::class, 'notifications'])->name('notifications');
           Route::post('add-notification', [PersonelController::class, 'sendNotify']);
           Route::get('setting', [PersonelController::class, 'setting'])->name('setting');
           Route::post('/add-custom-price', [PersonelCustomerPriceListController::class, 'store']); //özel fiyat ekleme
           Route::post('/delete-custom-price', [PersonelCustomerPriceListController::class, 'destroy']); //özel fiyat kaldırma
        });
        /* -------------------- Hizmetler --------------------------*/
        Route::resource('service', ServiceController::class);

        /* -------------------- Randevular --------------------------*/
        Route::resource('appointment', AppointmentController::class);
        Route::get('/calendar', [AppointmentController::class, 'calendar'])->name('appointment.calendar');
        Route::get('/randevular', [AppointmentController::class, 'todayAppointment'])->name('appointment.today');
        Route::post('appointment/{appointment}/service', [AppointmentServicesController::class,'store'])->name('appointment.service.add');
        Route::post('appointment/{appointment}/save/service', [AppointmentServicesController::class,'saveService'])->name('appointment.service.save');
        Route::delete('appointmentServices/{appointmentServices}', [AppointmentServicesController::class,'destroy'])->name('appointment.service.destroy');
        Route::get('/personel/{personel}/appointment', [AppointmentServicesController::class, 'getClock']);
        Route::get('/personel-randevular', [AppointmentServicesController::class, 'personelAppointment'])->name('appointment.personelAppointment');
        /* -------------------- Randevu Oluşturma --------------------------*/

        Route::prefix('appointment-create')->as('appointmentCreate.')->controller(AppointmentCreateController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('get/services', 'getService');
            Route::get('get/customers', 'getCustomer');
            Route::post('new/customer', 'newCustomer');
            Route::post('get/personel', 'getPersonel');
            Route::get('get/date', 'getDate');
            Route::post('get/clock', 'getClock');
            Route::post('check/clock', 'checkClock');
            Route::post('/store', 'appointmentCreate')->name('store');
            Route::post('/summary', 'summary');
        });

        /* -------------------- Hızlı Randevu -------------------------------------- */
        Route::prefix('speed-appointment')->as('speedAppointment.')
            ->controller(\App\Http\Controllers\Business\Appointment\SpeedAppointmentController::class)
            ->group(function (){
            Route::get('/', 'index')->name('index');
            Route::get('customer', 'getCustomerList');
            Route::get('personel/list', 'getPersonelList');
            Route::get('personel/{personel}/services', 'getPersonelServiceList');
            Route::get('personel/{personel}/clocks', 'getPersonelClocks');
            Route::post('create/{personel}', 'appointmentCreate');
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

            Route::get('/{adission}/print', [AdissionController::class, 'printAdission'])->name('printAdission');

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
        Route::post('/branche/{branche}/copy', [BusinessBrancheController::class, 'copyBranche']);

        /* -------------------- Yetkililer --------------------------*/
        Route::resource('business-official', BusinessOfficialController::class);
        Route::get('official/setting', [OfficialSettingController::class, 'index'])->name('official.setting');
        Route::put('official/setting/{official}/update', [OfficialSettingController::class, 'update'])->name('official.setting.update');
        Route::post('official/permission/{official}/update', [BusinessOfficialController::class, 'updatePermission'])->name('official.permission.update');

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

        /* -------------------- İşletme Kapalı Günleri --------------------------*/
        Route::resource('close-day', BusinessCloseDateController::class);

        /* -------------------- Personel Özel Çalışma Aralığı --------------------------*/
        Route::resource('personel-custom-work-time', PersonelWorkTimeController::class);

        /* -------------------- Fiyat Al Formu --------------------------*/
        Route::resource('request-form', AppointmentRequestFormController::class);
        Route::post('/request-form/question/{requestForm}/update', [AppointmentRequestFormController::class, 'updateQuestion'])->name('requestForm.updateQuestion');

        /* -------------------- Fiyat Al Talepleri --------------------------*/
        Route::resource('appointment-request', BusinessAppointmentRequestController::class);

        /* -------------------- Abonelik Özeti --------------------------*/
        Route::get('abonelik', [SubscribtionController::class, 'index'])->name('subscription.index');
        /* -------------------- Abonelik Satın Al --------------------------*/
        Route::prefix('paketler')->as('packet.')->group(function (){
            Route::get('/', [PacketOrderController::class, 'index'])->name('index');
            Route::get('/paket/{packet}/satin-al', [PacketOrderController::class, 'buy'])->name('buy');
            Route::post('/paket/{packet}/ode', [PacketOrderController::class, 'pay'])->name('pay');
            Route::post('/paket/{packet}/coupon', [PacketOrderController::class, 'useCoupon'])->name('useCoupon');
            Route::post('/paket/{packet}/coupon/delete', [PacketOrderController::class, 'removeCoupon'])->name('removeCoupon');
            Route::get('/paket/basarili', [PacketOrderController::class, 'success'])->name('payment.success');
            Route::get('/paket/hata', [PacketOrderController::class, 'fail'])->name('payment.fail');
        });
        /* -------------------- Faturalar --------------------------*/
        Route::resource('invoice', \App\Http\Controllers\InvoiceController::class)->only([
            'index', 'show', 'datatable'
        ]);
        /* -------------------- Global Ajax İstekleri --------------------------*/
        Route::post('password-update', [BusinessOfficialController::class, 'passwordUpdate'])->name('passwordUpdate');

        Route::get('settings', [\App\Http\Controllers\BusinessSettingController::class, 'index'])->name('settings');
        Route::post('settings', [\App\Http\Controllers\BusinessSettingController::class, 'updateInfo'])->name('settings.update');

        /* -------------------------------- Gelmeyenler --------------------------------------- */
        Route::get('customer-absent', [\App\Http\Controllers\Business\Absent\AbsentCustomerController::class, 'index'])->name('customer.absents');

        /* --------------------------------- Odalar ----------------------------------------------------*/
        Route::resource('room', \App\Http\Controllers\BusinessRoomController::class);

        Route::controller(AjaxController::class)->as('ajax.')->prefix('ajax')->group(function () {
            Route::post('/update-featured', 'updateFeatured')->name('updateFeatured');
            Route::delete('/delete/object', 'deleteFeatured')->name('deleteFeatured');
            Route::post('/delete/all/object', 'deleteAllFeatured')->name('deleteAllFeatured');
            Route::post('/get/district', 'getDistrict')->name('getDistrictUrl');
            Route::post('/get/personel', 'getPersonel');
            Route::post('/get/services', 'getServices');
        });
    });


});

Route::get('/sayfa/{slug}', [HomeController::class, 'page'])->name('page.detail');
