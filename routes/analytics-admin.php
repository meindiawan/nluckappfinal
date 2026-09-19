<?php
use App\Http\Controllers\Admin\AnalyticsController;
use Illuminate\Support\Facades\Route;
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function(){
    Route::get('/analytics',[AnalyticsController::class,'index'])->name('analytics');
});
