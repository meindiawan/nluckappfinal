<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');
