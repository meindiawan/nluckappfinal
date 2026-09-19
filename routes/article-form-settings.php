<?php

use App\Http\Controllers\Admin\ArticleFormSettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/form-artikel', [ArticleFormSettingController::class, 'edit'])->name('form-settings.edit');
    Route::put('/form-artikel', [ArticleFormSettingController::class, 'update'])->name('form-settings.update');
});
