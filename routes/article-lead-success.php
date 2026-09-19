<?php

use App\Http\Controllers\ArticleLeadSuccessController;
use Illuminate\Support\Facades\Route;

Route::get('/artikel/{slug}/berhasil', [ArticleLeadSuccessController::class, 'show'])
    ->name('articles.leads.success');
