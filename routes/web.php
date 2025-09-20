<?php
// routes/web.php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Payment routes
Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/thank-you', [PaymentController::class, 'thankYou'])->name('thank-you');
