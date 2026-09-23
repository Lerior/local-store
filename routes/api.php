<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products',[ProductController::class, 'getProducts']);
Route::get('/products/{id}',[ProductController::class, 'getProductById']);
Route::post('/products',[ProductController::class, 'addProduct']);
Route::patch('/products/{id}',[ProductController::class, 'updateProductById']);
Route::delete('/products/{id}',[ProductController::class, 'deleteProductById']);
