<?php

use App\Http\Controllers\Admin\LeadController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/leads')->name('admin.leads.')->group(function () {
    Route::get('/', [LeadController::class, 'index'])->name('index');
    Route::get('/export', [LeadController::class, 'export'])->name('export');
    Route::get('/{lead}', [LeadController::class, 'show'])->name('show');
    Route::patch('/{lead}/status', [LeadController::class, 'status'])->name('status');
    Route::delete('/{lead}', [LeadController::class, 'destroy'])->name('destroy');
});
