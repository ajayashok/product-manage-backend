<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(ProductController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('dashboard-analytics', 'dashboardAnalytics');
    Route::post('product-import', 'productImport');
    Route::get('get-products', 'productLists');
});
