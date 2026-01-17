<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;

class WelcomeMessageService
{
    public function __construct(private readonly WhatsAppGatewayService $whatsAppGateway)
    {
    }

    public function sendWhatsAppWelcome(User $user, string $tempPassword, ?string $whatsappGroup = null): void
    {
        if (empty($user->phone)) {
            Log::info('WhatsApp welcome skipped: phone missing', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            return;
        }

        $phoneNumber = $this->formatPhoneNumber($user->phone);

        if (empty($phoneNumber)) {
            Log::warning('WhatsApp welcome skipped: invalid phone', [
                'user_id' => $user->id,
                'email' => $user->email,
                'raw_phone' => $user->phone,
            ]);
            return;
        }

        $courseUrl = config('app.course_platform_url', config('app.url'));
        $message = $this->buildMessage(
            $user->name,
            $user->email,
            $tempPassword,
            $user->class,
            $courseUrl,
            $whatsappGroup
        );

        try {
            $this->whatsAppGateway->sendText($phoneNumber, $message);

            Log::info('WhatsApp welcome message sent', [
                'user_id' => $user->id,
                'phone' => $phoneNumber,
            ]);
        } catch (RequestException $e) {
            Log::error('WhatsApp gateway error when sending welcome message', [
                'user_id' => $user->id,
                'phone' => $phoneNumber,
                'gateway_message' => $this->extractGatewayMessage($e),
            ]);
        }
    }

    public function sendTestWelcomeMessage(
        string $phone,
        string $name,
        string $email,
        string $tempPassword,
        ?string $class = null,
        ?string $courseUrl = null,
        ?string $whatsappGroup = null
    ): void {
        $formattedPhone = $this->formatPhoneNumber($phone);

        if (empty($formattedPhone)) {
            throw new \InvalidArgumentException('Nomor WhatsApp tidak valid. Pastikan menggunakan format Indonesia.');
        }

        $url = $courseUrl ?: config('app.course_platform_url', config('app.url'));
        $message = $this->buildMessage($name, $email, $tempPassword, $class, $url, $whatsappGroup);

        try {
            $this->whatsAppGateway->sendText($formattedPhone, $message);
        } catch (RequestException $e) {
            $friendlyMessage = $this->extractGatewayMessage($e);
            throw new \RuntimeException('Gateway WhatsApp gagal: ' . $friendlyMessage, 0, $e);
        }
    }

    public function buildMessage(
        string $name,
        string $email,
        string $tempPassword,
        ?string $class,
        ?string $courseUrl,
        ?string $whatsappGroup
    ): string {
        $lines = [
            "Halo {$name}! Selamat datang di Digidesa - Kursus Ujian Perangkat Desa.",
            '',
            'Berikut informasi akun Anda:',
            "Email: {$email}",
            "Password sementara: {$tempPassword}",
        ];

        if (!empty($class)) {
            $lines[] = "Kelas: {$class}";
        }

        $lines[] = '';

        if (!empty($courseUrl)) {
            $lines[] = "Masuk platform: {$courseUrl}";
            $lines[] = '';
        }

        if (!empty($whatsappGroup)) {
            $lines[] = "Silahkan bergabung di grup belajar kursus ujian perangkat desa, untuk mengikuti info terbaru.";
            $lines[] = "Grup WhatsApp Peserta: {$whatsappGroup}";
        }

        $lines[] = '';
        $lines[] = 'Segera login dan ganti password Anda ya!';

        return implode("\n", $lines);
    }

    private function extractGatewayMessage(RequestException $e): string
    {
        $response = $e->response;

        if ($response) {
            $json = $response->json();

            if (is_array($json) && isset($json['message'])) {
                return $json['message'];
            }

            $body = trim($response->body() ?? '');
            if ($body !== '') {
                return $body;
            }
        }

        return $e->getMessage();
    }

    private function formatPhoneNumber(?string $phone): string
    {
        if (empty($phone)) {
            return '';
        }

        $digits = preg_replace('/\D/', '', $phone);

        if (empty($digits)) {
            return '';
        }

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (!str_starts_with($digits, '62')) {
            return '62' . $digits;
        }

        return $digits;
    }
}
