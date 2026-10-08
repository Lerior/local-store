<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/products/{id}', [ProductController::class, 'getProductById']);

Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('administration');
    })->name('admin.dashboard');
    Route::post('/products', [ProductController::class, 'addProduct']);
    Route::patch('/products/{id}', [ProductController::class, 'updateProductById']);
    Route::delete('/products/{id}', [ProductController::class, 'deleteProductById']);
});


Route::get('/home', function () {
    return view('catalog');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/product/{id}', function ($id) {
    return view('productDetails');
});