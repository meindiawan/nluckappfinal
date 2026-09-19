<?php

use App\Http\Controllers\Admin\ArticleController;
use Illuminate\Support\Facades\Route;

// Put these routes inside the existing auth/admin group.
Route::get('articles/{article}/studio', [ArticleController::class, 'studio'])->name('articles.studio');
Route::get('articles/{article}/studio/data', [ArticleController::class, 'studioData'])->name('articles.studio.data');
Route::post('articles/{article}/studio/save', [ArticleController::class, 'studioSave'])->name('articles.studio.save');
Route::post('articles/{article}/unpublish', [ArticleController::class, 'unpublish'])->name('articles.unpublish');
Route::get('articles/{article}/preview', [ArticleController::class, 'preview'])->name('articles.preview');
