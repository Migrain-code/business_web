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

        Route::prefix('package-sale/{packageSale}')->group(function () {
            Route::get('/payments', [PackageSaleOperationController::class, 'payments']);
            Route::get('/usages', [PackageSaleOperationController::class, 'usages']);

            Route::post('/add-payment', [PackageSaleOperationController::class, 'paymentsAdd']);
            Route::post('/add-usage', [PackageSaleOperationController::class, 'usagesAdd']);
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











        Route::controller(AjaxController::class)->as('ajax.')->prefix('ajax')->group(function () {
            Route::post('/update-featured', 'updateFeatured')->name('updateFeatured');
            Route::delete('/delete/object', 'deleteFeatured')->name('deleteFeatured');
            Route::post('/delete/all/object', 'deleteAllFeatured')->name('deleteAllFeatured');
            Route::post('/get/district', 'getDistrict')->name('getDistrictUrl');
        });
    });


});

