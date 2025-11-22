<?php
// routes/web.php (Updated)

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Legal pages
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms-of-service');

// Payment routes
Route::prefix('payment')->name('payment.')->group(function () {
    // Step 1: Get available payment methods
    Route::post('/methods', [PaymentController::class, 'getPaymentMethods'])->name('methods');

    // Step 2: Create transaction with selected method
    Route::post('/initiate', [PaymentController::class, 'initiate'])->name('initiate');

    // Callback and status routes
    // Route::post('/callback', [PaymentController::class, 'callback'])->name('callback');
    Route::post('/status', [PaymentController::class, 'checkStatus'])->name('status');
});

// In routes/web.php
Route::post('/payment/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback');

// Thank you and other pages
Route::get('/thank-you', [PaymentController::class, 'thankYou'])->name('thank-you');

Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');

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
