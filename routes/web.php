<?php
// routes/web.php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CourseAccessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing page
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Payment routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/initiate', [PaymentController::class, 'initiate'])->name('initiate');
    Route::post('/callback', [PaymentController::class, 'callback'])->name('callback');
    Route::post('/status', [PaymentController::class, 'checkStatus'])->name('status');
});

// Thank you and course access routes
Route::get('/thank-you', [PaymentController::class, 'thankYou'])->name('thank-you');
// Route::get('/course-access', [CourseAccessController::class, 'index'])->name('course.access');

// Additional utility routes
Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');

// Health check route for monitoring
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'app' => config('app.name'),
        'version' => '1.0.0'
    ]);
})->name('health');

// API routes for AJAX calls
Route::prefix('api')->name('api.')->group(function () {
    Route::post('/transaction/status', [PaymentController::class, 'checkStatus'])->name('transaction.status');
});
