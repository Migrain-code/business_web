<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('order/status', [\App\Http\Controllers\PdfController::class, 'getOrderStatus']);
Route::get('test/sms', [\App\Http\Controllers\PdfController::class, 'testSms']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
