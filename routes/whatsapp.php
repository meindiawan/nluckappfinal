<?php

use App\Http\Controllers\Admin\WhatsAppSettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/whatsapp', [WhatsAppSettingController::class, 'edit'])->name('whatsapp.edit');
    Route::put('/whatsapp', [WhatsAppSettingController::class, 'update'])->name('whatsapp.update');
});
