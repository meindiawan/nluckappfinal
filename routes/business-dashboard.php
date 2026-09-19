<?php
use App\Http\Controllers\Admin\BusinessDashboardController;
use Illuminate\Support\Facades\Route;
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard',[BusinessDashboardController::class,'index'])->name('dashboard');
});
