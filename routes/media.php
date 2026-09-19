<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MediaController;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/media/json', [MediaController::class, 'libraryJson'])->name('media.json');
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::patch('/media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
});
