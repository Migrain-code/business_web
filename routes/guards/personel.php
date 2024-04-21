<?php
Route::prefix('personel')->as('personel.')->group(function (){
    Route::get('login', [\App\Http\Controllers\Personel\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Personel\Auth\LoginController::class, 'login']);

    Route::get('/sifremi-unuttum', [\App\Http\Controllers\Personel\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('showForgotForm');
    Route::post('/sifremi-unuttum-send-code', [\App\Http\Controllers\Personel\Auth\ForgotPasswordController::class, 'sendResetVerifyCode'])->name('sendResetVerifyCode');

    Route::get('/telefon-numarasi-dogrulama', [\App\Http\Controllers\Personel\Auth\ForgotPasswordController::class, 'showResetPassword'])->name('verify.showResetPassword');
    Route::post('/sifremi-unuttum-dogrulama', [\App\Http\Controllers\Personel\Auth\ForgotPasswordController::class, 'verifyResetPassword'])->name('verify.resetPassword');

    Route::post('logout', [\App\Http\Controllers\Personel\Auth\LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:personel')->group(function () {
        Route::get('/home', [\App\Http\Controllers\Personel\HomeController::class, 'index'])->name('home');
        Route::get('/appointment/calendar', [\App\Http\Controllers\Personel\HomeController::class, 'calendar'])->name('appointment.calendar');
        Route::post('/appointment/update', [\App\Http\Controllers\Personel\HomeController::class, 'updateAppointment']);
        Route::get('/appointment', [\App\Http\Controllers\Personel\HomeController::class, 'appointment'])->name('appointments');
        Route::get('/case', [\App\Http\Controllers\Personel\HomeController::class, 'case'])->name('case.index');
        Route::get('/today/appointment', [\App\Http\Controllers\Personel\HomeController::class, 'getClock']);
        Route::get('/appointment/{appointment}/detay', [\App\Http\Controllers\Personel\HomeController::class, 'appointmentDetail'])->name('appointment.detail');
        Route::post('appointment/{appointment}/service', [\App\Http\Controllers\Personel\Appointment\AppointmentServicesController::class,'store'])->name('appointment.service.add');
        Route::delete('appointmentServices/{appointmentServices}', [\App\Http\Controllers\Personel\Appointment\AppointmentServicesController::class,'destroy'])->name('appointment.service.destroy');
        Route::prefix('appointment-create')->as('appointmentCreate.')->controller(\App\Http\Controllers\Personel\Appointment\AppointmentCreateController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('get/services', 'getService');
            Route::get('get/customers', 'getCustomer');
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

    });
});
