<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class WhatsAppGatewayService
{
    public function requestLoginQr(?string $session = null): array
    {
        $baseUrl = rtrim((string) config('services.wa_gateway.base_url', ''), '/');
        $apiKey = config('services.wa_gateway.api_key');
        $sessionName = $session ?? config('services.wa_gateway.session');

        if (empty($baseUrl) || empty($apiKey) || empty($sessionName)) {
            throw new \RuntimeException('WhatsApp gateway configuration is incomplete.');
        }

        $response = Http::timeout((int) config('services.wa_gateway.timeout', 15))
            ->withHeaders(['key' => $apiKey])
            ->get("{$baseUrl}/session/start", [
                'session' => $sessionName,
            ]);

        if ($response->failed()) {
            throw new RequestException($response);
        }

        $contentType = (string) $response->header('Content-Type', '');

        if (str_contains(strtolower($contentType), 'text/html')) {
            $dataUrl = $this->extractDataUrl($response->body());

            if ($dataUrl) {
                return [
                    'status' => 'qr',
                    'qr_data_url' => $dataUrl,
                    'session' => $sessionName,
                ];
            }
        }

        $payload = $response->json() ?? [];

        return [
            'status' => $payload['data']['message'] ?? 'connected',
            'qr_data_url' => null,
            'session' => $sessionName,
        ];
    }

    public function sendText(string $phoneNumber, string $message, bool $isGroup = false, ?string $session = null): array
    {
        $baseUrl = rtrim((string) config('services.wa_gateway.base_url', ''), '/');
        $apiKey = config('services.wa_gateway.api_key');
        $sessionName = $session ?? config('services.wa_gateway.session');

        if (empty($baseUrl) || empty($apiKey) || empty($sessionName)) {
            throw new \RuntimeException('WhatsApp gateway configuration is incomplete.');
        }

        $response = Http::timeout((int) config('services.wa_gateway.timeout', 15))
            ->withHeaders(['key' => $apiKey])
            ->post("{$baseUrl}/message/send-text", [
                'session' => $sessionName,
                'to' => $phoneNumber,
                'text' => $message,
                'is_group' => $isGroup,
            ]);

        if ($response->failed()) {
            throw new RequestException($response);
        }

        return $response->json() ?? [];
    }

    public function removeSession(?string $session = null): bool
    {
        $baseUrl = rtrim((string) config('services.wa_gateway.base_url', ''), '/');
        $apiKey = config('services.wa_gateway.api_key');
        $sessionName = $session ?? config('services.wa_gateway.session');

        if (empty($baseUrl) || empty($apiKey) || empty($sessionName)) {
            throw new \RuntimeException('WhatsApp gateway configuration is incomplete.');
        }

        $response = Http::timeout((int) config('services.wa_gateway.timeout', 15))
            ->withHeaders(['key' => $apiKey])
            ->get("{$baseUrl}/session/logout", [
                'session' => $sessionName,
            ]);

        if ($response->failed()) {
            throw new RequestException($response);
        }

        return true;
    }

    public function testConnection(): bool
    {
        $baseUrl = rtrim((string) config('services.wa_gateway.base_url', ''), '/');

        if (empty($baseUrl)) {
            throw new \RuntimeException('WhatsApp gateway URL belum dikonfigurasi.');
        }

        $response = Http::timeout((int) config('services.wa_gateway.timeout', 10))
            ->get("{$baseUrl}/health");

        if ($response->failed()) {
            return false;
        }

        $payload = $response->json();

        return is_array($payload) ? ($payload['status'] ?? null) === 'ok' : true;
    }

    public function listSessions(): array
    {
        $baseUrl = rtrim((string) config('services.wa_gateway.base_url', ''), '/');
        $apiKey = config('services.wa_gateway.api_key');

        if (empty($baseUrl) || empty($apiKey)) {
            return [];
        }

        $response = Http::timeout((int) config('services.wa_gateway.timeout', 15))
            ->withHeaders(['key' => $apiKey])
            ->get("{$baseUrl}/session");

        if ($response->failed()) {
            return [];
        }

        $payload = $response->json();

        if (!is_array($payload)) {
            return [];
        }

        $data = $payload['data'] ?? $payload;

        return is_array($data) ? array_values($data) : [];
    }

    public function isSessionRegistered(?string $session = null): bool
    {
        $sessionName = $session ?? config('services.wa_gateway.session');

        if (empty($sessionName)) {
            return false;
        }

        $sessions = $this->listSessions();

        return in_array($sessionName, $sessions, true);
    }

    private function extractDataUrl(string $html): ?string
    {
        if (preg_match("/let qr = '(data:image[^']+)'/i", $html, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
