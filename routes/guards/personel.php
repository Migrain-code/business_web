<?php
Route::prefix('personel')->as('personel.')->group(function (){
    Route::get('login', [\App\Http\Controllers\Personel\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Personel\Auth\LoginController::class, 'login']);

    Route::post('logout', [\App\Http\Controllers\Personel\Auth\LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:personel')->group(function () {
        Route::get('/home', [\App\Http\Controllers\Personel\HomeController::class, 'index'])->name('home');
        Route::get('/appointment', [\App\Http\Controllers\Personel\HomeController::class, 'appointment'])->name('appointments');

    });
});
