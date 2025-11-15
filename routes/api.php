<?php
use App\Http\Controllers\WooCommerceController;

Route::get('/wc/products', [WooCommerceController::class, 'getProducts']);
Route::get('/wc/product/{id}', [WooCommerceController::class, 'getProduct']);
Route::post('/wc/order', [WooCommerceController::class, 'createOrder']);
Route::post('/wc/createProduct', [WooCommerceController::class, 'createProduct']);
Route::put('/wc/product/{id}/stock', [WooCommerceController::class, 'updateStock']);
Route::put('/wc/product/{id}/update', [WooCommerceController::class, 'updateProducts']);
Route::delete('wc/product/delete/{id}', [WooCommerceController::class, 'deleteProduct']);

