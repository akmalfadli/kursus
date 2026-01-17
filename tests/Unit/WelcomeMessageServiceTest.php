<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\WelcomeMessageService;
use App\Services\WhatsAppGatewayService;
use Mockery;
use Tests\TestCase;

class WelcomeMessageServiceTest extends TestCase
{
    public function test_send_test_welcome_message_invokes_gateway_with_formatted_phone(): void
    {
        $gateway = Mockery::mock(WhatsAppGatewayService::class);
        $gateway->shouldReceive('sendText')
            ->once()
            ->withArgs(function ($phone, $message) {
                return $phone === '628123456789' && str_contains($message, 'Email: tester@example.com');
            });

        $service = new WelcomeMessageService($gateway);
        $service->sendTestWelcomeMessage(
            '08123456789',
            'Tester',
            'tester@example.com',
            'Secret123!',
            'Batch 1',
            'https://kursus.test',
            'https://chat.whatsapp.com/group'
        );
    }

    public function test_build_message_contains_expected_sections(): void
    {
        $gateway = Mockery::mock(WhatsAppGatewayService::class);
        $service = new WelcomeMessageService($gateway);

        $message = $service->buildMessage(
            'Tester',
            'tester@example.com',
            'Secret123!',
            'Batch 1',
            'https://kursus.test',
            'https://chat.whatsapp.com/group'
        );

        $this->assertStringContainsString('Tester', $message);
        $this->assertStringContainsString('Email: tester@example.com', $message);
        $this->assertStringContainsString('Kelas: Batch 1', $message);
        $this->assertStringContainsString('Masuk platform: https://kursus.test', $message);
        $this->assertStringContainsString('Grup WhatsApp Peserta: https://chat.whatsapp.com/group', $message);
    }

    public function test_send_whatsapp_welcome_skips_when_phone_missing(): void
    {
        $gateway = Mockery::mock(WhatsAppGatewayService::class);
        $gateway->shouldReceive('sendText')->never();

        $service = new WelcomeMessageService($gateway);

        $user = User::factory()->make([
            'phone' => null,
        ]);

        $service->sendWhatsAppWelcome($user, 'Secret123!', 'https://chat.whatsapp.com/group');
    }
}
