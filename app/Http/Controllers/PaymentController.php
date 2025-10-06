<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\ContentBlock; // Add this import
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
    // Step 1: Get available payment methods
    public function getPaymentMethods(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            // Get price dynamically from database
            $amount = $this->getCoursePrice();

            // Get available payment methods from Duitku
            $paymentMethods = $this->fetchDuitkuPaymentMethods($amount);

            if (!$paymentMethods) {
                throw new \Exception('Failed to fetch payment methods');
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'payment_methods' => $paymentMethods,
                    'amount' => $amount,
                    'formatted_amount' => 'Rp ' . number_format($amount, 0, ',', '.'),
                    'user_data' => [
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get payment methods', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil metode pembayaran. Silakan coba lagi.'
            ], 500);
        }
    }

    // Step 2: Create transaction with selected payment method
    public function initiate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'payment_method' => 'required|string|max:10',
        ]);

        try {
            $invoiceId = 'KPD-' . now()->format('YmdHis') . '-' . Str::random(6);

            // Get price dynamically from database
            $amount = $this->getCoursePrice();

            // Create or find user
            $password = Str::random(12);
            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => Hash::make($password),
                    'phone' => $request->phone,
                    'role' => 'customer',
                    'is_active' => true,
                ]
            );

            // TODO: Send email with $password to user if newly created

            // Create transaction record
            $transaction = Transaction::create([
                'invoice_id' => $invoiceId,
                'user_name' => $request->name,
                'user_email' => $request->email,
                'user_phone' => $request->phone,
                'amount' => $amount,
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            // Create Duitku payment with selected method
            $duitkuResponse = $this->createDuitkuInvoice([
                'invoice_id' => $invoiceId,
                'amount' => $amount,
                'payment_method' => $request->payment_method,
                'product_details' => $this->getCourseDetails(),
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

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'payment_url' => $duitkuResponse['paymentUrl'],
                        'invoice_id' => $invoiceId,
                        'va_number' => $duitkuResponse['vaNumber'] ?? null,
                        'qr_string' => $duitkuResponse['qrString'] ?? null,
                        'amount' => $amount
                    ]
                ]);
            }

            throw new \Exception('Failed to create payment: ' . ($duitkuResponse['statusMessage'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            Log::error('Payment initiation failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat pembayaran. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Get course price dynamically from database
     *
     * @return int
     */
    private function getCoursePrice(): int
    {
        try {
            // Get price from ContentBlock database
            $price = ContentBlock::getNumberValue('course_price', config('course.price', 299000));

            // Ensure price is a valid positive number
            $price = (int) $price;

            if ($price <= 0) {
                Log::warning('Invalid course price from database, using fallback', [
                    'database_price' => $price,
                    'fallback_price' => config('course.price', 299000)
                ]);
                return (int) config('course.price', 299000);
            }

            Log::info('Course price loaded from database', ['price' => $price]);

            return $price;

        } catch (\Exception $e) {
            Log::error('Failed to get course price from database', [
                'error' => $e->getMessage(),
                'fallback_price' => config('course.price', 299000)
            ]);

            // Fallback to config if database fails
            return (int) config('course.price', 299000);
        }
    }

    /**
     * Get course details dynamically from database or config
     *
     * @return string
     */
    private function getCourseDetails(): string
    {
        try {
            // Try to get course name from ContentBlock
            $courseName = ContentBlock::getValue('hero_title', config('course.name', 'Kursus Ujian Perangkat Desa'));

            return !empty($courseName) ? $courseName : config('course.name', 'Kursus Ujian Perangkat Desa');

        } catch (\Exception $e) {
            Log::error('Failed to get course details from database', [
                'error' => $e->getMessage()
            ]);

            return config('course.name', 'Kursus Ujian Perangkat Desa');
        }
    }

    // ... rest of your existing methods (callback, thankYou, checkStatus, etc.) remain the same

    public function callback(Request $request)
    {
        Log::info('Duitku callback received', $request->all());

        try {
            if (!$this->verifyDuitkuCallback($request->all())) {
                Log::warning('Invalid callback signature', $request->all());
                return response('Invalid signature', 400);
            }

            $merchantOrderId = $request->merchantOrderId;
            $resultCode = $request->resultCode;

            $transaction = Transaction::where('invoice_id', $merchantOrderId)->first();

            if (!$transaction) {
                Log::warning('Transaction not found', ['invoice_id' => $merchantOrderId]);
                return response('Transaction not found', 404);
            }

            if ($resultCode === '00') {
                $transaction->update([
                    'payment_status' => 'paid',
                    'payment_method' => $request->paymentCode ?? $transaction->payment_method,
                    'payment_reference' => $request->reference ?? null,
                    'paid_at' => now(),
                ]);

                Log::info('Payment successful', ['invoice_id' => $merchantOrderId]);
                $this->sendPaymentConfirmation($transaction);
                $this->notifyAdminPaymentSuccess($transaction);

            } elseif ($resultCode === '01') {
                $transaction->update(['payment_status' => 'pending']);
                Log::info('Payment pending', ['invoice_id' => $merchantOrderId]);
            } else {
                $transaction->update(['payment_status' => 'failed']);
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

    // Helper methods
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
            Log::info('Payment success notification should be sent to admin', ['invoice_id' => $transaction->invoice_id]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment success notification', [
                'error' => $e->getMessage(),
                'invoice_id' => $transaction->invoice_id
            ]);
        }
    }

    private function verifyDuitkuCallback(array $callbackData): bool
    {
        $merchantCode = config('services.duitku.merchant_code');
        $apiKey = config('services.duitku.api_key');

        $merchantOrderId = $callbackData['merchantOrderId'] ?? '';
        $amount = $callbackData['amount'] ?? '';
        $receivedSignature = $callbackData['signature'] ?? '';

        $expectedSignature = md5($merchantCode . $amount . $merchantOrderId . $apiKey);
        return hash_equals($expectedSignature, $receivedSignature);
    }

    private function formatPhoneNumber(string $phone): string
    {
        if (empty($phone)) return '';

        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1);
        }

        if (!str_starts_with($phone, '62')) {
            return '62' . $phone;
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
            $this->sendPaymentConfirmation($transaction);
        } elseif ($statusCode === '02') {
            $transaction->update(['payment_status' => 'failed']);
        }
    }

    // Keep existing Duitku methods
    private function fetchDuitkuPaymentMethods(int $amount): ?array
    {
        $merchantCode = config('services.duitku.merchant_code');
        $apiKey = config('services.duitku.api_key');
        $environment = config('services.duitku.environment', 'sandbox');

        $baseUrl = $environment === 'production'
            ? 'https://passport.duitku.com/webapi/api/merchant/'
            : 'https://sandbox.duitku.com/webapi/api/merchant/';

        $datetime = now()->format('Y-m-d H:i:s');
        $signature = hash('sha256', $merchantCode . $amount . $datetime . $apiKey);

        $data = [
            'merchantcode' => $merchantCode,
            'amount' => $amount,
            'datetime' => $datetime,
            'signature' => $signature
        ];

        try {
            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($baseUrl . 'paymentmethod/getpaymentmethod', $data);

            Log::info('Duitku Payment Methods Request', [
                'url' => $baseUrl . 'paymentmethod/getpaymentmethod',
                'data' => array_merge($data, ['signature' => 'HIDDEN'])
            ]);

            $responseData = $response->json();
            Log::info('Duitku Payment Methods Response', ['response' => $responseData]);

            if ($response->successful() &&
                isset($responseData['responseCode']) &&
                $responseData['responseCode'] === '00') {
                return $responseData['paymentFee'] ?? [];
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Duitku Payment Methods Error', [
                'error' => $e->getMessage(),
                'merchant_code' => $merchantCode
            ]);
            return null;
        }
    }

    private function createDuitkuInvoice(array $params): array
    {
        $merchantCode = config('services.duitku.merchant_code');
        $apiKey = config('services.duitku.api_key');
        $environment = config('services.duitku.environment', 'sandbox');

        $baseUrl = $environment === 'production'
            ? 'https://passport.duitku.com/webapi/api/merchant/'
            : 'https://sandbox.duitku.com/webapi/api/merchant/';

        $paymentData = [
            'merchantCode' => $merchantCode,
            'paymentAmount' => $params['amount'],
            'paymentMethod' => $params['payment_method'],
            'merchantOrderId' => $params['invoice_id'],
            'productDetails' => $params['product_details'],
            'customerVaName' => $params['customer_name'],
            'email' => $params['email'],
            'phoneNumber' => $this->formatPhoneNumber($params['phone'] ?? ''),
            'callbackUrl' => $params['callback_url'],
            'returnUrl' => $params['return_url'],
            'expiryPeriod' => 60,
        ];

        $signature = md5(
            $merchantCode .
            $paymentData['merchantOrderId'] .
            $paymentData['paymentAmount'] .
            $apiKey
        );
        $paymentData['signature'] = $signature;

        try {
            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($baseUrl . 'v2/inquiry', $paymentData);

            Log::info('Duitku Transaction Request', [
                'url' => $baseUrl . 'v2/inquiry',
                'data' => array_merge($paymentData, ['signature' => 'HIDDEN'])
            ]);

            $responseData = $response->json();
            Log::info('Duitku Transaction Response', ['response' => $responseData]);

            if ($response->successful() && isset($responseData['statusCode'])) {
                return $responseData;
            }

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
}
