<?php

use App\Http\Controllers\Admin\ArticleWorkflowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/articles/{article}/publish', [ArticleWorkflowController::class, 'publish'])->name('articles.publish');
    Route::post('/articles/{article}/unpublish', [ArticleWorkflowController::class, 'unpublish'])->name('articles.unpublish');
    Route::post('/articles/{article}/duplicate', [ArticleWorkflowController::class, 'duplicate'])->name('articles.duplicate');
    Route::get('/articles/{article}/preview', [ArticleWorkflowController::class, 'preview'])->name('articles.preview');
});
