<?php

namespace Tests\Unit;

use App\Services\WhatsAppGatewayService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WhatsAppGatewayServiceTest extends TestCase
{
    public function test_send_text_posts_payload(): void
    {
        config([
            'services.wa_gateway.base_url' => 'https://wa-gateway.test',
            'services.wa_gateway.api_key' => 'test-key',
            'services.wa_gateway.session' => 'welcome',
            'services.wa_gateway.timeout' => 5,
        ]);

        Http::fake([
            'https://wa-gateway.test/message/send-text' => Http::response(['status' => 'ok'], 200),
        ]);

        $service = new WhatsAppGatewayService();
        $response = $service->sendText('628123456789', 'Hello there!');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://wa-gateway.test/message/send-text'
                && $request['session'] === 'welcome'
                && $request['to'] === '628123456789'
                && $request['text'] === 'Hello there!';
        });

        $this->assertSame('ok', $response['status']);
    }

    public function test_send_text_requires_configuration(): void
    {
        $this->expectException(\RuntimeException::class);

        config([
            'services.wa_gateway.base_url' => null,
            'services.wa_gateway.api_key' => null,
            'services.wa_gateway.session' => null,
        ]);

        (new WhatsAppGatewayService())->sendText('628123456789', 'Hello');
    }

    public function test_list_sessions_returns_data_array(): void
    {
        config([
            'services.wa_gateway.base_url' => 'https://wa-gateway.test',
            'services.wa_gateway.api_key' => 'test-key',
        ]);

        Http::fake([
            'https://wa-gateway.test/session' => Http::response([
                'data' => ['alpha', 'beta'],
            ], 200),
        ]);

        $sessions = (new WhatsAppGatewayService())->listSessions();

        $this->assertSame(['alpha', 'beta'], $sessions);
    }

    public function test_request_login_qr_parses_html_response(): void
    {
        config([
            'services.wa_gateway.base_url' => 'https://wa-gateway.test',
            'services.wa_gateway.api_key' => 'test-key',
            'services.wa_gateway.session' => 'welcome',
        ]);

        $html = "<script>let qr = 'data:image/png;base64,TEST';</script>";

        Http::fake([
            'https://wa-gateway.test/session/start*' => Http::response($html, 200, ['Content-Type' => 'text/html']),
        ]);

        $result = (new WhatsAppGatewayService())->requestLoginQr();

        $this->assertSame('data:image/png;base64,TEST', $result['qr_data_url']);
        $this->assertSame('qr', $result['status']);
        $this->assertSame('welcome', $result['session']);
    }

    public function test_remove_session_hits_logout_endpoint(): void
    {
        config([
            'services.wa_gateway.base_url' => 'https://wa-gateway.test',
            'services.wa_gateway.api_key' => 'test-key',
            'services.wa_gateway.session' => 'alpha',
        ]);

        Http::fake([
            'https://wa-gateway.test/session/logout*' => Http::response(['data' => 'success'], 200),
        ]);

        $result = (new WhatsAppGatewayService())->removeSession();

        $this->assertTrue($result);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'https://wa-gateway.test/session/logout')
                && str_contains($request->url(), 'session=alpha')
                && $request->method() === 'GET';
        });
    }

    public function test_test_connection_returns_true_on_ok(): void
    {
        config([
            'services.wa_gateway.base_url' => 'https://wa-gateway.test',
        ]);

        Http::fake([
            'https://wa-gateway.test/health' => Http::response(['status' => 'ok'], 200),
        ]);

        $this->assertTrue((new WhatsAppGatewayService())->testConnection());
    }
}
