<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::post('/products/{id}/stock-in', [StockMovementController::class, 'stockIn']);
Route::post('/products/{id}/stock-out', [StockMovementController::class, 'stockOut']);
Route::get('/products/{id}/movements', [StockMovementController::class, 'movements']);

Route::get('/reports/low-stock', [ReportController::class, 'lowStock']);
Route::get('/reports/out-of-stock', [ReportController::class, 'outOfStock']);
Route::get('/reports/summary', [ReportController::class, 'summary']);
