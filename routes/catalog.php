<?php

use App\Http\Controllers\ProductCatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductCatalogController::class, 'index'])->name('catalog');
Route::get('/produk/{slug}', [ProductCatalogController::class, 'show'])->name('products.show');
