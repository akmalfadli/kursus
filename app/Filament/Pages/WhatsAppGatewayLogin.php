<?php

namespace App\Filament\Pages;

use App\Models\ContentBlock;
use App\Services\WelcomeMessageService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;

class WhatsAppGatewayLogin extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'WhatsApp Gateway';

    protected static string $view = 'filament.pages.whatsapp-gateway-login';

    public ?string $qrDataUrl = null;

    public ?string $sessionName = null;

    public array $registeredSessions = [];

    public ?string $statusMessage = null;

    public ?string $lastGeneratedAt = null;

    public ?bool $gatewayReachable = null;

    public ?string $gatewayCheckedAt = null;

    public ?string $testPhone = null;

    public ?string $testName = null;

    public ?string $testEmail = null;

    public ?string $testPassword = null;

    public ?string $testClass = null;

    public ?string $testCourseUrl = null;

    public ?string $testGroupLink = null;

    public ?string $lastTestSentAt = null;

    public function mount(): void
    {
        $this->sessionName = config('services.wa_gateway.session');
        $this->refreshSessions();
        $this->testName = 'Tes WhatsApp';
        $this->testEmail = 'test@digidesa.id';
        $this->testPassword = Str::random(10);
        $this->testClass = ContentBlock::getValue('default_class', 'Kelas Umum');
        $this->testCourseUrl = config('app.course_platform_url', config('app.url'));
        $this->testGroupLink = ContentBlock::getValue('whatsapp_group');
    }

    protected function rules(): array
    {
        return [
            'testPhone' => ['required', 'string', 'max:30'],
        ];
    }

    public function generateQrCode(): void
    {
        if (blank($this->sessionName)) {
            Notification::make()
                ->title('Session WhatsApp belum dikonfigurasi')
                ->body('Pastikan variabel WA_GATEWAY_SESSION pada file .env sudah terisi.')
                ->danger()
                ->send();

            return;
        }

        try {
            $result = $this->gateway()->requestLoginQr($this->sessionName);
            $this->qrDataUrl = $result['qr_data_url'] ?? null;
            $this->statusMessage = $result['status'] ?? null;
            $this->lastGeneratedAt = now()->format('d/m/Y H:i');

            Notification::make()
                ->title($this->qrDataUrl ? 'QR code siap dipindai' : 'Session sudah terhubung')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            report($e);
            $this->qrDataUrl = null;

            Notification::make()
                ->title('Gagal membuat QR code')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }

        $this->refreshSessions();
    }

    public function refreshSessions(): void
    {
        try {
            $this->registeredSessions = $this->gateway()->listSessions();
        } catch (\Throwable $e) {
            report($e);
            $this->registeredSessions = [];

            Notification::make()
                ->title('Gagal memuat status session')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function removeCurrentSession(): void
    {
        if (blank($this->sessionName)) {
            Notification::make()
                ->title('Session belum dikonfigurasi')
                ->body('Isi variabel WA_GATEWAY_SESSION terlebih dahulu.')
                ->danger()
                ->send();

            return;
        }

        try {
            $this->gateway()->removeSession($this->sessionName);
            $this->qrDataUrl = null;
            $this->statusMessage = 'Session dihapus';

            Notification::make()
                ->title('Session berhasil dihapus')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            report($e);

            Notification::make()
                ->title('Gagal menghapus session')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }

        $this->refreshSessions();
    }

    public function testGateway(): void
    {
        try {
            $this->gatewayReachable = $this->gateway()->testConnection();
            $this->gatewayCheckedAt = now()->format('d/m/Y H:i');

            Notification::make()
                ->title($this->gatewayReachable ? 'Gateway responsif' : 'Gateway tidak merespons')
                ->color($this->gatewayReachable ? 'success' : 'danger')
                ->send();
        } catch (\Throwable $e) {
            report($e);
            $this->gatewayReachable = false;

            Notification::make()
                ->title('Tes gateway gagal')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function sendTestWelcomeMessage(): void
    {
        $data = $this->validate();

        $name = $this->testName ?? 'Tes WhatsApp';
        $email = $this->testEmail ?? 'test@digidesa.id';
        $password = $this->testPassword ?? Str::random(10);
        $class = $this->testClass ?? ContentBlock::getValue('default_class', 'Kelas Umum');
        $courseUrl = $this->testCourseUrl ?? config('app.course_platform_url', config('app.url'));
        $groupLink = $this->testGroupLink ?? ContentBlock::getValue('whatsapp_group');

        try {
            $this->welcomeService()->sendTestWelcomeMessage(
                $data['testPhone'],
                $name,
                $email,
                $password,
                $class,
                $courseUrl,
                $groupLink,
            );

            $this->lastTestSentAt = now()->format('d/m/Y H:i');

            Notification::make()
                ->title('Pesan welcome berhasil dikirim')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            report($e);

            Notification::make()
                ->title('Gagal mengirim pesan welcome')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function regenerateDummyData(): void
    {
        $this->testPassword = Str::random(10);
    }

    public function getSessionStatusProperty(): string
    {
        if (blank($this->sessionName)) {
            return 'Session belum dikonfigurasi';
        }

        return in_array($this->sessionName, $this->registeredSessions, true)
            ? 'Terhubung'
            : 'Belum terhubung';
    }

    public function getIsSessionConnectedProperty(): bool
    {
        if (blank($this->sessionName)) {
            return false;
        }

        return in_array($this->sessionName, $this->registeredSessions, true);
    }

    private function gateway(): \App\Services\WhatsAppGatewayService
    {
        return app(\App\Services\WhatsAppGatewayService::class);
    }

    private function welcomeService(): WelcomeMessageService
    {
        return app(WelcomeMessageService::class);
    }
}
