<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'getProducts']);

Route::post('/refund/batch',  [RefundController::class, 'refundBatch']);
Route::post('/refund/order',  [RefundController::class, 'refundOrder']);
Route::post('/batch/purchase',  [BatchController::class, 'purchase']);
Route::get('/batch/calculate',  [BatchController::class, 'calculateProfitPerBatch']);

Route::get('/stock/{date}',  [StockController::class, 'getStockByDate']);

Route::post('order', [OrderController::class, 'createOrder']);
