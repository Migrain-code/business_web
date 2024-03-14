<?php

use App\Http\Controllers\Business\Auth\LoginController;
use App\Http\Controllers\Business\Customer\CustomerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\AjaxController;
use \App\Http\Controllers\Business\Customer\CustomerInfoController;
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
Route::get('/fiyatlandirma', [HomeController::class, 'prices'])->name('prices');
Route::get('/referanslar', [HomeController::class, 'references'])->name('references');
Route::get('/bloglar', [HomeController::class, 'blogs'])->name('blogs');
Route::get('/blog/{slug}', [HomeController::class, 'blogDetail'])->name('blogs.detail');
Route::get('/sss', [HomeController::class, 'faq'])->name('faq');

Route::get('login', [HomeController::class, 'loginTypes'])->name('loginTypes');

Route::prefix('isletme')->as('business.')->group(function (){
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:official')->group(function () {
        Route::get('/home', [\App\Http\Controllers\Business\HomeController::class, 'index'])->name('home');
        Route::resource('customer', CustomerController::class);
        Route::prefix('customer/{customer}')->group(function (){
            Route::get('cash-point-list', [CustomerInfoController::class, 'cashPointList']);
            Route::get('product-sale-list', [CustomerInfoController::class, 'productSaleList']);
            Route::get('package-sale-list', [CustomerInfoController::class, 'packageSaleList']);

        });
        Route::controller(AjaxController::class)->as('ajax.')->prefix('ajax')->group(function () {
            Route::post('/update-featured', 'updateFeatured')->name('updateFeatured');
            Route::post('/delete/object', 'deleteFeatured')->name('deleteFeatured');
            Route::post('/delete/all/object', 'deleteAllFeatured')->name('deleteAllFeatured');
            Route::post('/get/district', 'getDistrict')->name('getDistrictUrl');
        });
    });


});

