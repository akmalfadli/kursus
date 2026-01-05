<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\ContentBlock;
use App\Services\PricingService;
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
    public function __construct(private readonly PricingService $pricingService)
    {
    }
    // Step 1: Get available payment methods
    public function getPaymentMethods(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'referral_code' => 'nullable|string|max:50',
        ]);
        try {
            // Get price dynamically from database
            $pricing = $this->pricingService->calculatePricing($request->input('referral_code'));
            $amount = $pricing['final_amount'];
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
                    'pricing' => $this->formatPricingResponse($pricing),
                    'user_data' => [
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'referral_code' => $pricing['referral']?->code ?? null,
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
            'referral_code' => 'nullable|string|max:50',
        ]);

        try {
            $invoiceId = 'KPD-' . now()->format('YmdHis') . '-' . Str::random(6);

            $pricing = $this->pricingService->calculatePricing($request->input('referral_code'));
            $amount = $pricing['final_amount'];

            // Get default class from database
            $defaultClass = $this->getDefaultClass();

            // ✅ CHANGED: Only create transaction, NOT user
            // User will be created after payment success
            $transaction = Transaction::create([
                'invoice_id' => $invoiceId,
                'user_name' => $request->name,
                'user_email' => $request->email,
                'user_phone' => $request->phone,
                'base_amount' => $pricing['base_amount'],
                'amount' => $amount,
                'referral_discount_amount' => $pricing['discount_amount'],
                'referral_commission_amount' => $pricing['commission_amount'],
                'referral_discount_percentage' => $pricing['referral']?->discount_percentage,
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'referral_id' => $pricing['referral']?->id,
                'referral_code' => $pricing['referral']?->code,
                'referral_commission_status' => $pricing['referral'] ? 'pending' : null,
            ]);

            Log::info('Transaction created (user will be created after payment)', [
                'invoice_id' => $invoiceId,
                'email' => $request->email,
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
                        'amount' => $amount,
                        'pricing' => $this->formatPricingResponse($pricing),
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

    public function callback(Request $request)
    {
        // Log ALL incoming data for debugging
        Log::info('Duitku callback received', [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'ip' => $request->ip(),
            'method' => $request->method(),
        ]);

        try {
            // Verify signature FIRST before any processing
            if (!$this->verifyDuitkuCallback($request->all())) {
                Log::warning('Invalid callback signature', [
                    'data' => $request->all(),
                    'expected_signature' => $this->calculateExpectedSignature($request->all())
                ]);
                return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 400);
            }

            // Extract and validate required fields
            $merchantOrderId = $request->input('merchantOrderId');
            $resultCode = $request->input('resultCode');

            if (empty($merchantOrderId) || empty($resultCode)) {
                Log::error('Missing required callback fields', $request->all());
                return response()->json(['status' => 'error', 'message' => 'Missing required fields'], 400);
            }

            // Find transaction
            $transaction = Transaction::where('invoice_id', $merchantOrderId)->first();

            if (!$transaction) {
                Log::warning('Transaction not found in callback', [
                    'invoice_id' => $merchantOrderId,
                    'all_data' => $request->all()
                ]);
                return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
            }

            // Prevent duplicate processing
            if ($transaction->payment_status === 'paid') {
                Log::info('Transaction already paid, skipping duplicate callback', [
                    'invoice_id' => $merchantOrderId,
                    'paid_at' => $transaction->paid_at
                ]);
                return response()->json(['status' => 'success', 'message' => 'Already processed'], 200);
            }

            // Process based on result code
            if ($resultCode === '00') {
                // Payment SUCCESS
                $transaction->update([
                    'payment_status' => 'paid',
                    'payment_method' => $request->input('paymentCode', $transaction->payment_method),
                    'payment_reference' => $request->input('reference'),
                    'paid_at' => now(),
                    'duitku_response' => array_merge(
                        $transaction->duitku_response ?? [],
                        ['callback_received_at' => now()->toISOString()]
                    )
                ]);

                Log::info('Payment successful - Starting post-payment processing', [
                    'invoice_id' => $merchantOrderId,
                    'reference' => $request->input('reference')
                ]);

                $this->recordReferralUsage($transaction);

                // Create user after payment
                try {
                    $this->createUserAfterPayment($transaction);
                } catch (\Exception $e) {
                    Log::error('User creation failed but payment succeeded', [
                        'invoice_id' => $merchantOrderId,
                        'error' => $e->getMessage()
                    ]);
                }

                // Send notifications (non-blocking)
                try {
                    $this->sendPaymentConfirmation($transaction);
                    $this->notifyAdminPaymentSuccess($transaction);
                } catch (\Exception $e) {
                    Log::error('Notification failed but payment succeeded', [
                        'invoice_id' => $merchantOrderId,
                        'error' => $e->getMessage()
                    ]);
                }

                // Trigger API integration (non-blocking)
                try {
                    $this->triggerApiIntegration($transaction);
                } catch (\Exception $e) {
                    Log::error('API integration failed but payment succeeded', [
                        'invoice_id' => $merchantOrderId,
                        'error' => $e->getMessage()
                    ]);
                }

                return response()->json(['status' => 'success'], 200);

            } elseif ($resultCode === '01') {
                // Payment PENDING
                $transaction->update(['payment_status' => 'pending']);
                Log::info('Payment pending', ['invoice_id' => $merchantOrderId]);
                return response()->json(['status' => 'success', 'message' => 'Pending'], 200);

            } else {
                // Payment FAILED
                $transaction->update([
                    'payment_status' => 'failed',
                    'duitku_response' => array_merge(
                        $transaction->duitku_response ?? [],
                        [
                            'failure_code' => $resultCode,
                            'failure_time' => now()->toISOString()
                        ]
                    )
                ]);
                Log::info('Payment failed', [
                    'invoice_id' => $merchantOrderId,
                    'result_code' => $resultCode
                ]);
                return response()->json(['status' => 'success', 'message' => 'Failed'], 200);
            }

        } catch (\Exception $e) {
            Log::error('Callback processing exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            // Still return 200 to prevent Duitku from retrying
            return response()->json([
                'status' => 'error',
                'message' => 'Internal error - will be investigated'
            ], 200);
        }
    }

    /**
     * Helper method to calculate expected signature for debugging
     */
    private function calculateExpectedSignature(array $data): string
    {
        $merchantCode = config('services.duitku.merchant_code');
        $apiKey = config('services.duitku.api_key');
        $merchantOrderId = $data['merchantOrderId'] ?? '';
        $amount = $data['amount'] ?? '';

        return md5($merchantCode . $amount . $merchantOrderId . $apiKey);
    }

    /**
     * ✅ NEW METHOD: Create user after payment success
     */
    private function createUserAfterPayment(Transaction $transaction): void
    {
        try {
            $defaultClass = $this->getDefaultClass();
            $tempPassword = Str::random(12);

            // Create or find user
            $user = User::firstOrCreate(
                ['email' => $transaction->user_email],
                [
                    'name' => $transaction->user_name,
                    'password' => Hash::make($tempPassword),
                    'phone' => $transaction->user_phone,
                    'role' => 'customer',
                    'is_active' => true,
                    'class' => $defaultClass,
                ]
            );

            // If user already exists, update the class if it's not set
            if ($user->wasRecentlyCreated === false) {
                $updateData = [];

                if (empty($user->class)) {
                    $updateData['class'] = $defaultClass;
                }

                // Always update password for existing users when they pay again
                $updateData['password'] = Hash::make($tempPassword);

                if (!empty($updateData)) {
                    $user->update($updateData);
                }
            }

            Log::info('User created/updated after payment', [
                'user_id' => $user->id,
                'email' => $user->email,
                'class' => $user->class,
                'was_newly_created' => $user->wasRecentlyCreated,
                'transaction_id' => $transaction->id
            ]);

            // Store temp password in transaction notes for reference
            $transaction->update([
                'duitku_response' => array_merge(
                    $transaction->duitku_response ?? [],
                    ['temp_password_generated' => true]
                )
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create user after payment', [
                'error' => $e->getMessage(),
                'transaction_id' => $transaction->id,
                'email' => $transaction->user_email
            ]);

            // Don't throw exception - payment was successful
            // User creation failure should not break the payment flow
        }
    }

    /**
     * Trigger API Integration setelah pembayaran sukses
     */
    private function triggerApiIntegration(Transaction $transaction): void
    {
        try {
            // Check if API integration is enabled
            $apiEnabled = ContentBlock::getBooleanValue('api_enabled', false);

            if (!$apiEnabled) {
                Log::info('API Integration disabled, skipping', ['invoice_id' => $transaction->invoice_id]);
                return;
            }

            // Get API settings
            $apiUrl = ContentBlock::getValue('api_trigger_url');
            $bearerToken = ContentBlock::getValue('api_bearer_token');
            $defaultClass = $this->getDefaultClass();

            if (empty($apiUrl) || empty($bearerToken)) {
                Log::warning('API settings incomplete, skipping integration', [
                    'invoice_id' => $transaction->invoice_id,
                    'has_url' => !empty($apiUrl),
                    'has_token' => !empty($bearerToken)
                ]);
                return;
            }

            // Find user (should exist now after createUserAfterPayment)
            $user = User::where('email', $transaction->user_email)->first();

            if (!$user) {
                Log::error('User not found for API integration', [
                    'invoice_id' => $transaction->invoice_id,
                    'email' => $transaction->user_email
                ]);
                return;
            }

            // Generate temporary password
            $tempPassword = Str::random(12);

            // Update user password
            $user->update([
                'password' => Hash::make($tempPassword)
            ]);

            // Ensure user has a class
            if (empty($user->class)) {
                $user->update(['class' => $defaultClass]);
                $user->refresh();
            }

            // Prepare API payload
            $payload = [
                'adminEmail' => 'akmalfadli94@gmail.com',
                'adminPassword' => 'pAdli3',
                'email' => $user->email,
                'password' => $tempPassword,
                'name' => $user->name,
                'class' => $user->class
            ];

            Log::info('API Integration triggered', [
                'user_id' => $user->id,
                'email' => $user->email,
                'url' => $apiUrl
            ]);

            // Send API request
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $bearerToken,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($apiUrl, $payload);

            // Log response
            $statusCode = $response->status();
            $responseData = $response->json();

            Log::info('API Integration Response', [
                'user_id' => $user->id,
                'status_code' => $statusCode,
                'response' => $responseData
            ]);

            if ($response->successful()) {
                // Send email with credentials to user
                $this->sendCredentialsEmail($user, $tempPassword);
            } else {
                Log::error('API request failed', [
                    'invoice_id' => $transaction->invoice_id,
                    'status_code' => $statusCode,
                    'response' => $response->body()
                ]);
            }

        } catch (\Exception $e) {
            Log::error('API Integration error', [
                'invoice_id' => $transaction->invoice_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Don't throw exception - payment was successful
        }
    }

    /**
     * Send credentials email to user
     */
    private function sendCredentialsEmail(User $user, string $tempPassword): void
    {
        try {
            Mail::to($user->email)->send(new \App\Mail\WelcomeEmail($user, $tempPassword));

            Log::info('Credentials email sent', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send credentials email', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
        }
    }

    /**
     * Get default class from database
     */
    private function getDefaultClass(): string
    {
        try {
            $defaultClass = ContentBlock::getValue('default_class', 'Batch 1');
            Log::info('Default class loaded from database', ['class' => $defaultClass]);
            return $defaultClass;
        } catch (\Exception $e) {
            Log::error('Failed to get default class from database', [
                'error' => $e->getMessage()
            ]);
            return 'Kelas Umum'; // Fallback
        }
    }

    private function recordReferralUsage(Transaction $transaction): void
    {
        try {
            $this->pricingService->recordReferralUsage($transaction);
        } catch (\Exception $e) {
            Log::error('Failed to record referral usage', [
                'error' => $e->getMessage(),
                'transaction_id' => $transaction->id,
            ]);
        }
    }

    private function formatPricingResponse(array $pricing): array
    {
        return [
            'base_amount' => $pricing['base_amount'],
            'discount_amount' => $pricing['discount_amount'],
            'final_amount' => $pricing['final_amount'],
            'commission_amount' => $pricing['commission_amount'],
            'formatted' => [
                'base' => 'Rp ' . number_format($pricing['base_amount'], 0, ',', '.'),
                'discount' => 'Rp ' . number_format($pricing['discount_amount'], 0, ',', '.'),
                'final' => 'Rp ' . number_format($pricing['final_amount'], 0, ',', '.'),
            ],
            'referral' => $pricing['referral'] ? [
                'code' => $pricing['referral']->code,
                'discount_percentage' => $pricing['referral']->discount_percentage,
            ] : null,
        ];
    }

    /**
     * Get course details dynamically from database or config
     */
    private function getCourseDetails(): string
    {
        try {
            $courseName = ContentBlock::getValue('hero_title', config('course.name', 'Kursus Ujian Perangkat Desa'));
            return !empty($courseName) ? $courseName : config('course.name', 'Kursus Ujian Perangkat Desa');
        } catch (\Exception $e) {
            Log::error('Failed to get course details from database', [
                'error' => $e->getMessage()
            ]);
            return config('course.name', 'Kursus Ujian Perangkat Desa');
        }
    }

    public function thankYou(Request $request)
    {
        $invoiceId = $request->get('invoice');
        $transaction = null;

        if ($invoiceId) {
            $transaction = Transaction::where('invoice_id', $invoiceId)->first();
        }

        $content = [
            'contact_email' => ContentBlock::getValue('contact_email', 'support@example.com'),
            'contact_phone' => ContentBlock::getValue('contact_phone', '+62 812-3456-7890'),
            'price' => $this->pricingService->getBasePrice(),
            'default_class' => ContentBlock::getValue('default_class', 'Kelas Umum'),
            'course_name' => ContentBlock::getValue('hero_title', config('course.name', 'Kursus Ujian Perangkat Desa')),
        ];

        return view('thank-you', compact('transaction', 'content'));
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
            $adminEmail = config('mail.admin_email', 'teknologiperwira@gmail.com');
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

            $this->recordReferralUsage($transaction);

            // ✅ Create user after payment confirmed
            $this->createUserAfterPayment($transaction);

            $this->sendPaymentConfirmation($transaction);
            $this->triggerApiIntegration($transaction);
        } elseif ($statusCode === '02') {
            $transaction->update(['payment_status' => 'failed']);
        }
    }

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
