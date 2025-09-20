<?php
// app/Http/Controllers/PaymentController.php (Enhanced with Email Notifications)

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Mail\PaymentConfirmation;
use App\Mail\NewTransactionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            $invoiceId = 'KPD-' . now()->format('YmdHis') . '-' . Str::random(6);
            $amount = config('course.price', 299000);

            // Create or find user
            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => Hash::make(Str::random(12)),
                    'phone' => $request->phone,
                    'role' => 'customer',
                    'is_active' => true,
                ]
            );

            // Create transaction record
            $transaction = Transaction::create([
                'invoice_id' => $invoiceId,
                'user_name' => $request->name,
                'user_email' => $request->email,
                'user_phone' => $request->phone,
                'amount' => $amount,
                'payment_status' => 'pending',
            ]);

            // Prepare Duitku payment data
            $duitkuResponse = $this->createDuitkuInvoice([
                'invoice_id' => $invoiceId,
                'amount' => $amount,
                'product_details' => config('course.name', 'Kursus Ujian Perangkat Desa'),
                'customer_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'callback_url' => config('services.duitku.callback_url'),
                'return_url' => config('services.duitku.return_url') . '?invoice=' . $invoiceId,
            ]);

            if (isset($duitkuResponse['statusCode']) && $duitkuResponse['statusCode'] === '00') {
                // Update transaction with Duitku response
                $transaction->update([
                    'duitku_reference' => $duitkuResponse['reference'] ?? null,
                    'duitku_response' => $duitkuResponse,
                ]);

                // Send admin notification
                $this->notifyAdminNewTransaction($transaction);

                return redirect($duitkuResponse['paymentUrl']);
            }

            throw new \Exception('Failed to create payment: ' . ($duitkuResponse['statusMessage'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            Log::error('Payment initiation failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return back()->withErrors(['error' => 'Gagal membuat pembayaran. Silakan coba lagi.']);
        }
    }

    public function callback(Request $request)
    {
        Log::info('Duitku callback received', $request->all());

        try {
            // Verify callback signature using MD5 (as per Duitku documentation)
            if (!$this->verifyDuitkuCallback($request->all())) {
                Log::warning('Invalid callback signature', $request->all());
                return response('Invalid signature', 400);
            }

            $merchantOrderId = $request->merchantOrderId;
            $resultCode = $request->resultCode;
            $amount = $request->amount;

            $transaction = Transaction::where('invoice_id', $merchantOrderId)->first();

            if (!$transaction) {
                Log::warning('Transaction not found', ['invoice_id' => $merchantOrderId]);
                return response('Transaction not found', 404);
            }

            // Update transaction status based on result code
            if ($resultCode === '00') {
                $transaction->update([
                    'payment_status' => 'paid',
                    'payment_method' => $request->paymentCode ?? null,
                    'payment_reference' => $request->reference ?? null,
                    'paid_at' => now(),
                ]);

                Log::info('Payment successful', ['invoice_id' => $merchantOrderId]);

                // Send payment confirmation email
                $this->sendPaymentConfirmation($transaction);

                // Send admin notification
                $this->notifyAdminPaymentSuccess($transaction);

            } elseif ($resultCode === '01') {
                // Payment pending/processing
                $transaction->update([
                    'payment_status' => 'pending',
                ]);

                Log::info('Payment pending', ['invoice_id' => $merchantOrderId]);
            } else {
                // Payment failed or expired
                $transaction->update([
                    'payment_status' => 'failed',
                ]);

                Log::info('Payment failed', ['invoice_id' => $merchantOrderId, 'result_code' => $resultCode]);
            }

            return response('OK', 200);

        } catch (\Exception $e) {
            Log::error('Callback processing failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response('Error processing callback', 500);
        }
    }

    public function thankYou(Request $request)
    {
        $invoiceId = $request->get('invoice');
        $transaction = null;

        if ($invoiceId) {
            $transaction = Transaction::where('invoice_id', $invoiceId)->first();
        }

        return view('thank-you', compact('transaction'));
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|string'
        ]);

        try {
            $transaction = Transaction::where('invoice_id', $request->invoice_id)->firstOrFail();

            // Check status with Duitku if still pending
            if ($transaction->payment_status === 'pending') {
                $duitkuStatus = $this->checkDuitkuTransactionStatus($transaction->invoice_id);

                if ($duitkuStatus && isset($duitkuStatus['statusCode'])) {
                    $this->updateTransactionFromStatus($transaction, $duitkuStatus);
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'invoice_id' => $transaction->invoice_id,
                    'payment_status' => $transaction->payment_status,
                    'amount' => $transaction->formatted_amount,
                    'paid_at' => $transaction->paid_at?->format('d/m/Y H:i')
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Status check failed', [
                'error' => $e->getMessage(),
                'invoice_id' => $request->invoice_id
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengecek status pembayaran'
            ], 500);
        }
    }

    // Email notification methods
    private function sendPaymentConfirmation(Transaction $transaction): void
    {
        try {
            Mail::to($transaction->user_email)->send(new PaymentConfirmation($transaction));
            Log::info('Payment confirmation email sent', ['invoice_id' => $transaction->invoice_id]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment confirmation email', [
                'error' => $e->getMessage(),
                'invoice_id' => $transaction->invoice_id
            ]);
        }
    }

    private function notifyAdminNewTransaction(Transaction $transaction): void
    {
        try {
            $adminEmail = config('mail.admin_email', 'admin@kursusperangkatdesa.com');
            Mail::to($adminEmail)->send(new NewTransactionNotification($transaction));
            Log::info('Admin notification sent for new transaction', ['invoice_id' => $transaction->invoice_id]);
        } catch (\Exception $e) {
            Log::error('Failed to send admin notification', [
                'error' => $e->getMessage(),
                'invoice_id' => $transaction->invoice_id
            ]);
        }
    }

    private function notifyAdminPaymentSuccess(Transaction $transaction): void
    {
        try {
            $adminEmail = config('mail.admin_email', 'admin@kursusperangkatdesa.com');
            // You can create a separate mailable for payment success notifications
            Log::info('Payment success notification should be sent to admin', ['invoice_id' => $transaction->invoice_id]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment success notification', [
                'error' => $e->getMessage(),
                'invoice_id' => $transaction->invoice_id
            ]);
        }
    }

    // Duitku API methods (same as before but with better error handling)
    private function createDuitkuInvoice(array $params): array
    {
        $merchantCode = config('services.duitku.merchant_code');
        $apiKey = config('services.duitku.api_key');
        $environment = config('services.duitku.environment', 'sandbox');

        // Correct base URLs as per Duitku documentation
        $baseUrl = $environment === 'production'
            ? 'https://passport.duitku.com/webapi/api/merchant/'
            : 'https://sandbox.duitku.com/webapi/api/merchant/';

        // Prepare payment data with all required parameters
        $paymentData = [
            'merchantCode' => $merchantCode,
            'paymentAmount' => $params['amount'], // Must be integer (no decimals)
            'paymentMethod' => '', // Empty for Smart Payment (shows all available methods)
            'merchantOrderId' => $params['invoice_id'],
            'productDetails' => $params['product_details'],
            'customerVaName' => $params['customer_name'],
            'email' => $params['email'],
            'phoneNumber' => $this->formatPhoneNumber($params['phone'] ?? ''),
            'callbackUrl' => $params['callback_url'],
            'returnUrl' => $params['return_url'],
            'expiryPeriod' => 60, // 60 minutes
            'additionalParam' => '', // Optional additional data
        ];

        // Generate signature using correct formula: SHA256(merchantCode + merchantOrderId + paymentAmount + apiKey)
        $signature = hash('sha256',
            $merchantCode .
            $paymentData['merchantOrderId'] .
            $paymentData['paymentAmount'] .
            $apiKey
        );
        $paymentData['signature'] = $signature;

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->post($baseUrl . 'v2/inquiry', $paymentData);

            Log::info('Duitku API Request', [
                'url' => $baseUrl . 'v2/inquiry',
                'data' => array_merge($paymentData, ['signature' => 'HIDDEN']) // Hide signature in logs
            ]);

            $responseData = $response->json();
            Log::info('Duitku API Response', ['response' => $responseData]);

            if ($response->successful() && isset($responseData['statusCode'])) {
                return $responseData;
            }

            // Handle specific error cases
            $errorMessage = $responseData['statusMessage'] ?? 'Unknown API error';
            throw new \Exception("Duitku API Error: {$errorMessage}");

        } catch (\Exception $e) {
            Log::error('Duitku Service Error', [
                'error' => $e->getMessage(),
                'environment' => $environment,
                'merchant_code' => $merchantCode
            ]);
            throw $e;
        }
    }

    private function verifyDuitkuCallback(array $callbackData): bool
    {
        $merchantCode = config('services.duitku.merchant_code');
        $apiKey = config('services.duitku.api_key');

        $merchantOrderId = $callbackData['merchantOrderId'] ?? '';
        $amount = $callbackData['amount'] ?? '';
        $receivedSignature = $callbackData['signature'] ?? '';

        // Correct callback verification using MD5 (as per Duitku documentation)
        $expectedSignature = md5($merchantCode . $amount . $merchantOrderId . $apiKey);

        return hash_equals($expectedSignature, $receivedSignature);
    }

    private function formatPhoneNumber(string $phone): string
    {
        if (empty($phone)) {
            return '';
        }

        // Remove all non-digits
        $phone = preg_replace('/\D/', '', $phone);

        // Convert to Indonesian format
        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1); // Convert 08xxx to 628xxx
        }

        if (!str_starts_with($phone, '62')) {
            return '62' . $phone; // Add country code if missing
        }

        return $phone;
    }

    private function checkDuitkuTransactionStatus(string $merchantOrderId): ?array
    {
        $merchantCode = config('services.duitku.merchant_code');
        $apiKey = config('services.duitku.api_key');
        $environment = config('services.duitku.environment', 'sandbox');

        $baseUrl = $environment === 'production'
            ? 'https://passport.duitku.com/webapi/api/merchant/'
            : 'https://sandbox.duitku.com/webapi/api/merchant/';

        // Generate signature for status check: MD5(merchantCode + merchantOrderId + apiKey)
        $signature = md5($merchantCode . $merchantOrderId . $apiKey);

        $data = [
            'merchantCode' => $merchantCode,
            'merchantOrderId' => $merchantOrderId,
            'signature' => $signature
        ];

        try {
            $response = Http::timeout(15)->post($baseUrl . 'transactionStatus', $data);

            if ($response->successful()) {
                return $response->json();
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Duitku status check failed', [
                'error' => $e->getMessage(),
                'merchant_order_id' => $merchantOrderId
            ]);
            return null;
        }
    }

    private function updateTransactionFromStatus(Transaction $transaction, array $statusData): void
    {
        $statusCode = $statusData['statusCode'] ?? '';

        if ($statusCode === '00') {
            $transaction->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            // Send payment confirmation if newly paid
            $this->sendPaymentConfirmation($transaction);
        } elseif ($statusCode === '02') {
            $transaction->update([
                'payment_status' => 'failed',
            ]);
        }
        // Keep as pending for other status codes
    }
}
