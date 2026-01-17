<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid gap-6 lg:grid-cols-2">
            <x-filament::section :heading="__('Status Session')">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Session yang digunakan</p>
                        <p class="text-lg font-semibold">{{ $sessionName ?? 'Belum disetel' }}</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <span @class([
                            'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium',
                            'bg-success-100 text-success-700 dark:bg-success-500/15 dark:text-success-300' => $this->is_session_connected,
                            'bg-danger-100 text-danger-700 dark:bg-danger-500/15 dark:text-danger-300' => ! $this->is_session_connected,
                        ])>
                            {{ $this->session_status }}
                        </span>

                        <x-filament::button color="gray" icon="heroicon-o-arrow-path" wire:click="refreshSessions" type="button">
                            Perbarui Status
                        </x-filament::button>

                        <x-filament::button color="danger" icon="heroicon-o-trash" wire:click="removeCurrentSession" type="button">
                            Hapus Session
                        </x-filament::button>
                    </div>

                    <div class="rounded-lg border border-gray-200 p-3 text-sm dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium">Tes Gateway</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Pastikan endpoint dapat diakses sebelum melakukan login.
                                </p>
                                @if (! is_null($gatewayReachable))
                                    <p class="mt-2 text-xs">
                                        Status terakhir: <span class="font-semibold">{{ $gatewayReachable ? 'Responsif' : 'Tidak merespons' }}</span>
                                        @if ($gatewayCheckedAt)
                                            ({{ $gatewayCheckedAt }})
                                        @endif
                                    </p>
                                @endif
                            </div>

                            <x-filament::button color="gray" icon="heroicon-o-wifi" wire:click="testGateway" type="button">
                                Tes Gateway
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section :heading="__('QR Code Login')">
                <div class="space-y-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tekan tombol di bawah untuk meminta QR code dari gateway, lalu pindai menggunakan aplikasi WhatsApp pada perangkat yang akan digunakan sebagai pengirim pesan.
                    </p>

                    <div class="flex min-h-[320px] flex-col items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-900/30">
                        @if ($qrDataUrl)
                            <img src="{{ $qrDataUrl }}" alt="QR Code" class="h-64 w-64 rounded bg-white p-2 shadow" />
                            <p class="mt-4 text-sm text-gray-600 dark:text-gray-300">
                                Pindai QR dalam waktu kurang dari 1 menit untuk menyelesaikan proses login.
                            </p>
                            @if ($lastGeneratedAt)
                                <p class="text-xs text-gray-400">Dibuat {{ $lastGeneratedAt }}</p>
                            @endif
                        @elseif ($this->is_session_connected)
                            <p class="text-sm font-medium text-success-600 dark:text-success-400">Session sudah terhubung. Tidak perlu memindai QR.</p>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada QR code. Tekan tombol di bawah untuk membuatnya.</p>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <x-filament::button icon="heroicon-o-qr-code" wire:click="generateQrCode" type="button">
                            Generate QR
                        </x-filament::button>

                        <x-filament::button color="gray" icon="heroicon-o-x-mark" wire:click="$set('qrDataUrl', null)" type="button">
                            Bersihkan QR
                        </x-filament::button>
                    </div>
                </div>
            </x-filament::section>
        </div>

        <x-filament::section :heading="__('Panduan Singkat')">
            <ol class="list-decimal space-y-2 pl-5 text-sm text-gray-600 dark:text-gray-300">
                <li>Pastikan variabel <code class="rounded bg-gray-200 px-1 py-0.5 text-xs text-gray-800 dark:bg-gray-800 dark:text-gray-100">WA_GATEWAY_SESSION</code> sudah diisi sesuai nama session di gateway.</li>
                <li>Tekan tombol <strong>Generate QR</strong> lalu pindai menggunakan WhatsApp.</li>
                <li>Setelah status berubah menjadi <strong>Terhubung</strong>, Anda bisa menutup halaman ini.</li>
            </ol>
        </x-filament::section>

        <x-filament::section :heading="__('Tes Pesan Welcome')">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor WhatsApp Tujuan</label>
                    <input
                        type="text"
                        wire:model.defer="testPhone"
                        class="mt-1 w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800/70 dark:text-gray-100 dark:placeholder-gray-500"
                        placeholder="Contoh: 0812xxxx"
                    />
                    @error('testPhone')
                        <p class="mt-1 text-xs text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="rounded-lg border border-dashed border-gray-300 p-4 text-sm text-gray-600 dark:border-gray-700 dark:text-gray-300">
                    <p class="font-semibold">Data dummy yang digunakan:</p>
                    <ul class="mt-2 space-y-1">
                        <li>Nama: {{ $testName }}</li>
                        <li>Email: {{ $testEmail }}</li>
                        <li>Password sementara: {{ $testPassword }}</li>
                        <li>Kelas: {{ $testClass }}</li>
                        <li>URL Platform: {{ $testCourseUrl }}</li>
                        <li>Link Grup WhatsApp: {{ $testGroupLink ?? 'Belum disetel' }}</li>
                    </ul>
                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">Anda hanya perlu memasukkan nomor WhatsApp. Data lain otomatis terisi.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <x-filament::button icon="heroicon-o-paper-airplane" wire:click="sendTestWelcomeMessage" type="button">
                        Kirim Pesan Tes
                    </x-filament::button>

                    <x-filament::button color="gray" wire:click="regenerateDummyData" type="button">
                        Regenerasi Password Dummy
                    </x-filament::button>

                    @if ($lastTestSentAt)
                        <p class="text-sm text-gray-500 dark:text-gray-400">Terakhir dikirim: {{ $lastTestSentAt }}</p>
                    @endif
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
