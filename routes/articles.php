<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArticleController;
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function(){
    Route::resource('articles',ArticleController::class)->except(['show']);
    Route::get('articles/{article}/studio',[ArticleController::class,'studio'])->name('articles.studio');
    Route::get('articles/{article}/studio/data',[ArticleController::class,'studioData'])->name('articles.studio.data');
    Route::post('articles/{article}/studio/save',[ArticleController::class,'studioSave'])->name('articles.studio.save');
});
