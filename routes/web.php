<?php

use App\Modules\Reports\Http\Controllers\ReportController;
use App\Modules\Products\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReportController::class, 'index'])->name('reports.index');
Route::post('/reports', [ReportController::class, 'generate'])->name('reports.generate');
Route::post('/reports/archive-csv', [ReportController::class, 'archive'])->name('reports.archive');
Route::post('/reports/undo', [ReportController::class, 'undo'])->name('reports.undo');

Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::post('/produtos', [ProductController::class, 'store'])->name('products.store');
Route::put('/produtos/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/produtos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
