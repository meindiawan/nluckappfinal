<?php

use App\Http\Controllers\ArticleLeadController;
use Illuminate\Support\Facades\Route;

Route::post('/artikel/{slug}/daftar', [ArticleLeadController::class, 'store'])->name('articles.leads.store');
