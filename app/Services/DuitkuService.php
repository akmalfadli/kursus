<?php
// app/Services/DuitkuService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DuitkuService
{
    private $merchantCode;
    private $apiKey;
    private $environment;
    private $baseUrl;

    public function __construct()
    {
        $this->merchantCode = config('services.duitku.merchant_code');
        $this->apiKey = config('services.duitku.api_key');
        $this->environment = config('services.duitku.environment', 'sandbox');
        $this->baseUrl = $this->environment === 'production'
            ? 'https://passport.duitku.com/webapi/api/merchant/'
            : 'https://sandbox.duitku.com/webapi/api/merchant/';
    }

    public function createInvoice(array $params): array
    {
        $data = [
            'merchantCode' => $this->merchantCode,
            'paymentAmount' => $params['amount'],
            'paymentMethod' => 'SP', // Smart Payment (all methods)
            'merchantOrderId' => $params['invoice_id'],
            'productDetails' => $params['product_details'],
            'customerVaName' => $params['customer_name'],
            'email' => $params['email'],
            'phoneNumber' => $params['phone'] ?? '',
            'callbackUrl' => $params['callback_url'],
            'returnUrl' => $params['return_url'],
            'expiryPeriod' => 60, // 60 minutes
        ];

        // Generate signature
        $signature = hash('sha256',
            $this->merchantCode .
            $data['merchantOrderId'] .
            $data['paymentAmount'] .
            $this->apiKey
        );
        $data['signature'] = $signature;

        try {
            $response = Http::post($this->baseUrl . 'v2/inquiry', $data);

            Log::info('Duitku API Request', ['data' => $data]);
            Log::info('Duitku API Response', ['response' => $response->json()]);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception('Duitku API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Duitku Service Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function verifyCallback(array $callbackData): bool
    {
        $merchantOrderId = $callbackData['merchantOrderId'] ?? '';
        $resultCode = $callbackData['resultCode'] ?? '';
        $amount = $callbackData['amount'] ?? '';
        $receivedSignature = $callbackData['signature'] ?? '';

        $expectedSignature = hash('sha256',
            $this->merchantCode .
            $merchantOrderId .
            $amount .
            $resultCode .
            $this->apiKey
        );

        return hash_equals($expectedSignature, $receivedSignature);
    }
}
