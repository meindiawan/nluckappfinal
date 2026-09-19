<?php

use App\Http\Controllers\Admin\ArticleLeadController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/leads', [ArticleLeadController::class, 'index'])->name('leads.index');
});
