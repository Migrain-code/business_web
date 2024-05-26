<?php
Route::prefix('personel')->as('personel.')->group(function (){
    Route::get('login', [\App\Http\Controllers\Personel\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Personel\Auth\LoginController::class, 'login']);

    Route::get('/sifremi-unuttum', [\App\Http\Controllers\Personel\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('showForgotForm');
    Route::post('/sifremi-unuttum-send-code', [\App\Http\Controllers\Personel\Auth\ForgotPasswordController::class, 'sendResetVerifyCode'])->name('sendResetVerifyCode');

    Route::get('/telefon-numarasi-dogrulama', [\App\Http\Controllers\Personel\Auth\ForgotPasswordController::class, 'showResetPassword'])->name('verify.showResetPassword');
    Route::post('/sifremi-unuttum-dogrulama', [\App\Http\Controllers\Personel\Auth\ForgotPasswordController::class, 'verifyResetPassword'])->name('verify.resetPassword');
    Route::get('/sifremi-unuttum-dogrulama-tekrar-gönder', [\App\Http\Controllers\Personel\Auth\ForgotPasswordController::class, 'verifyResetRepeatPassword'])->name('verify.repeatPassword');

    Route::post('logout', [\App\Http\Controllers\Personel\Auth\LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:personel')->group(function () {
        Route::get('/home', [\App\Http\Controllers\Personel\HomeController::class, 'index'])->name('home');
        Route::get('/appointment/calendar', [\App\Http\Controllers\Personel\HomeController::class, 'calendar'])->name('appointment.calendar');
        Route::get('/case', [\App\Http\Controllers\Personel\HomeController::class, 'case'])->name('case.index');
        Route::get('/prim', [\App\Http\Controllers\Personel\HomeController::class, 'prim'])->name('prim.index');
        Route::get('/today/appointment', [\App\Http\Controllers\Personel\HomeController::class, 'getClock']);

        Route::resource('appointment', \App\Http\Controllers\Personel\Appointment\AppointmentController::class);
        Route::post('appointment/{appointment}/service', [\App\Http\Controllers\Personel\Appointment\AppointmentServicesController::class,'store'])->name('appointment.service.add');
        Route::delete('appointmentServices/{appointmentServices}', [\App\Http\Controllers\Personel\Appointment\AppointmentServicesController::class,'destroy'])->name('appointment.service.destroy');

        Route::prefix('appointment-create')->as('appointmentCreate.')->controller(\App\Http\Controllers\Personel\Appointment\AppointmentCreateController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('get/services', 'getService');
            Route::get('get/customers', 'getCustomer');
            Route::post('new/customer', 'newCustomer');
            Route::post('get/personel', 'getPersonel');
            Route::get('get/date', 'getDate');
            Route::post('get/clock', 'getClock');
            Route::post('/store', 'appointmentCreate')->name('store');
            Route::post('/summary', 'summary');
        });

        /* -------------------- Personel İzin Günleri --------------------------*/
        Route::resource('personel-stay-off-day', \App\Http\Controllers\Personel\StayOffDay\PersonelStayOffDayController::class);
        Route::resource('payment', \App\Http\Controllers\Personel\PersonelCostController::class);

        Route::get('notification', [\App\Http\Controllers\Personel\PersonelSettingController::class, 'notifications'])->name('notifications');

        Route::get('settings', [\App\Http\Controllers\Personel\PersonelSettingController::class, 'settings'])->name('settings');
        Route::post('settings', [\App\Http\Controllers\Personel\PersonelSettingController::class, 'update'])->name('setting.update');

        Route::get('notification-permission', [\App\Http\Controllers\Personel\PersonelSettingController::class, 'notificationPermission'])->name('notificationPermission');
        Route::post('notification-permission', [\App\Http\Controllers\Personel\PersonelSettingController::class, 'notificationPermissionUpdate']);
        Route::post('password-update', [\App\Http\Controllers\Personel\PersonelSettingController::class, 'passwordUpdate'])->name('passwordUpdate');

        /* -------------------- Adisyonlar --------------------------*/
        Route::resource('adission', \App\Http\Controllers\Personel\Adission\AdissionController::class);
        Route::prefix('adission')->as('adission.')->group(function () {

            Route::get('/{adission}/sale/datatable', [\App\Http\Controllers\Personel\Adission\AdissionProductSaleController::class, 'index'])->name('sale.datatable');
            Route::get('/{adission}/sale/create', [\App\Http\Controllers\Personel\Adission\AdissionProductSaleController::class, 'create']);
            Route::post('/{adission}/sale/add', [\App\Http\Controllers\Personel\Adission\AdissionProductSaleController::class, 'store'])->name('sale.add');

            Route::get('/{adission}/payment', [\App\Http\Controllers\Personel\Adission\AdissionPaymentController::class, 'index']);//tahsilat listesi
            Route::post('/{adission}/payment/add', [\App\Http\Controllers\Personel\Adission\AdissionPaymentController::class, 'store']);//tahsilat ekle
            Route::delete('/{adission}/payment/{payment}', [\App\Http\Controllers\Personel\Adission\AdissionPaymentController::class, 'destroy']);//tahsilat sil

            Route::post('/{adission}/payment/save', [\App\Http\Controllers\Personel\Adission\AdissionPaymentController::class, 'paymentSave']);
            Route::get('/{adission}/payment/close', [\App\Http\Controllers\Personel\Adission\AdissionPaymentController::class, 'closePayment'])->name('paymentClose');

            //Parapuan Kullan
            Route::get('/{adission}/cash-point', [\App\Http\Controllers\Personel\Adission\AdissionAddCashPointController::class, 'index']);
            Route::post('/{adission}/cash-point', [\App\Http\Controllers\Personel\Adission\AdissionAddCashPointController::class, 'store'])->name('cashPoint.add');

            //Alacak Ekle
            Route::get('/{adission}/receivable', [\App\Http\Controllers\Personel\Adission\AdissionAddCashPointController::class, 'receivableList']);
            Route::post('/{adission}/receivable', [\App\Http\Controllers\Personel\Adission\AdissionAddCashPointController::class, 'receivableAdd']);
            Route::delete('/{adission}/receivable/{receivable}', [\App\Http\Controllers\Personel\Adission\AdissionAddCashPointController::class, 'receivableDelete']);
        });

    });
});
