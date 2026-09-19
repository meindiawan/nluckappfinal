<?php

use App\Http\Controllers\ArticleWhatsAppController;
use Illuminate\Support\Facades\Route;

Route::get('/artikel/{slug}/whatsapp/{lead}/klik', [ArticleWhatsAppController::class, 'click'])
    ->name('articles.whatsapp.click');
