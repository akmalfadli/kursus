@extends('layouts.app')

@section('title', 'Terima Kasih - Status Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 flex items-center justify-center py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-12 text-center">
            @if($transaction && $transaction->payment_status === 'paid')
                <!-- Success State -->
                <div class="mb-8">
                    <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        🎉 Pembayaran Berhasil!
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Selamat! Anda telah berhasil bergabung dengan <strong>Kursus Ujian Perangkat Desa</strong>
                    </p>
                </div>

                <!-- Transaction Details -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">📋 Detail Transaksi</h2>
                    <div class="space-y-3 text-left">
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Invoice ID:</span>
                            <span class="font-semibold">{{ $transaction->invoice_id }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-semibold">{{ $transaction->user_name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-semibold">{{ $transaction->user_email }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-semibold text-green-600">{{ $transaction->formatted_amount }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Metode:</span>
                            <span class="font-semibold">{{ $transaction->payment_method ?? 'Duitku Payment' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="text-gray-600">Status:</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">✅ Lunas</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Tanggal:</span>
                            <span class="font-semibold">{{ $transaction->paid_at->format('d/m/Y H:i') }} WIB</span>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-blue-50 rounded-2xl p-6 mb-8">
                    <h2 class="text-xl font-bold text-blue-900 mb-4">🚀 Langkah Selanjutnya</h2>
                    <div class="space-y-3 text-left text-blue-800">
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1 flex-shrink-0">1</span>
                            <span>Cek email Anda (termasuk folder spam) untuk link akses ke platform pembelajaran</span>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1 flex-shrink-0">2</span>
                            <span>Login menggunakan email yang telah terdaftar</span>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1 flex-shrink-0">3</span>
                            <span>Mulai belajar dan raih kesuksesan dalam ujian perangkat desa</span>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-blue-100 rounded-lg text-sm text-blue-700">
                        <strong>💡 Tips:</strong> Email biasanya diterima dalam 5-10 menit. Jika belum menerima, silakan hubungi support kami.
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <a href="mailto:support@example.com?subject=Bantuan%20Akses%20Kursus%20-%20{{ $transaction->invoice_id }}"
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300 inline-block">
                        📧 Hubungi Support Jika Belum Terima Email
                    </a>
                    <a href="{{ route('landing') }}"
                       class="w-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300 inline-block">
                        🏠 Kembali ke Beranda
                    </a>
                </div>

            @elseif($transaction && $transaction->payment_status === 'pending')
                <!-- Pending State -->
                <div class="mb-8">
                    <div class="w-24 h-24 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        ⏳ Pembayaran Sedang Diproses
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Silakan selesaikan pembayaran Anda atau tunggu konfirmasi dari sistem
                    </p>
                </div>

                <div class="bg-yellow-50 rounded-2xl p-6 mb-8">
                    <div class="text-yellow-800">
                        <h3 class="font-bold mb-2">📄 Detail Pesanan:</h3>
                        <p><strong>Invoice ID:</strong> {{ $transaction->invoice_id }}</p>
                        <p><strong>Jumlah:</strong> {{ $transaction->formatted_amount }}</p>
                        <p><strong>Status:</strong> <span class="bg-yellow-200 px-2 py-1 rounded">Menunggu Pembayaran</span></p>
                    </div>
                </div>

                <!-- Auto refresh for pending payments -->
                <div class="bg-blue-50 rounded-2xl p-6 mb-8">
                    <h3 class="text-blue-900 font-bold mb-2">🔄 Pemeriksaan Status Otomatis</h3>
                    <p class="text-blue-700 text-sm">Halaman ini akan memperbarui status pembayaran secara otomatis setiap 30 detik.</p>
                    <div class="mt-4">
                        <div class="bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 60%"></div>
                        </div>
                        <p class="text-xs text-blue-600 mt-1" id="refresh-countdown">Memeriksa status dalam 30 detik...</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <button onclick="checkPaymentStatus('{{ $transaction->invoice_id }}')"
                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300"
                            id="check-status-btn">
                        🔍 Periksa Status Pembayaran
                    </button>
                    <a href="{{ route('landing') }}"
                       class="w-full border-2 border-gray-400 text-gray-600 hover:bg-gray-400 hover:text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300 inline-block">
                        ← Kembali ke Beranda
                    </a>
                </div>

            @else
                <!-- Error/Unknown State -->
                <div class="mb-8">
                    <div class="w-24 h-24 bg-gray-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        📝 Terima Kasih!
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Kami akan segera memproses pesanan Anda. Silakan cek email untuk konfirmasi lebih lanjut.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                    <h3 class="text-gray-800 font-bold mb-2">🔍 Lacak Status Pembayaran</h3>
                    <p class="text-gray-600 mb-4">Masukkan Invoice ID untuk melacak status pembayaran Anda:</p>
                    <div class="flex gap-2">
                        <input type="text" id="invoice-search" placeholder="Masukkan Invoice ID (contoh: KPD-20240101120000-ABC123)"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button onclick="searchTransaction()"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                                id="search-btn">
                            Cari
                        </button>
                    </div>
                </div>

                <a href="{{ route('landing') }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300 inline-block">
                    🏠 Kembali ke Beranda
                </a>
            @endif

            <!-- Support Contact -->
            <div class="mt-8 pt-8 border-t border-gray-200 text-sm text-gray-500">
                <p class="mb-2">Butuh bantuan? Hubungi kami di:</p>
                <div class="space-y-1">
                    <p class="font-semibold text-gray-700">
                        📧 Email: support@example.com
                    </p>
                    <p class="font-semibold text-gray-700">
                        📱 WhatsApp: +62 812-3456-7890
                    </p>
                    <p class="text-xs text-gray-400 mt-2">
                        Jam operasional: Senin-Jumat 09:00-17:00 WIB
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($transaction && $transaction->payment_status === 'pending')
        // Auto refresh for pending payments
        let countdown = 30;
        const countdownElement = document.getElementById('refresh-countdown');

        const refreshInterval = setInterval(function() {
            countdown--;
            if (countdownElement) {
                countdownElement.textContent = `Memeriksa status dalam ${countdown} detik...`;
            }

            if (countdown <= 0) {
                checkPaymentStatus('{{ $transaction->invoice_id }}');
                countdown = 30; // Reset countdown
            }
        }, 1000);

        // Clean up interval when page is hidden
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                clearInterval(refreshInterval);
            }
        });
    @endif
});

function checkPaymentStatus(invoiceId) {
    const checkBtn = document.getElementById('check-status-btn');
    if (checkBtn) {
        checkBtn.disabled = true;
        checkBtn.innerHTML = '🔄 Memeriksa...';
    }

    fetch('{{ route("payment.status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            invoice_id: invoiceId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const transaction = data.data;
            if (transaction.payment_status === 'paid') {
                // Refresh page to show success state
                window.location.reload();
            } else if (transaction.payment_status === 'failed') {
                showNotification('❌ Pembayaran gagal. Silakan coba lagi atau hubungi support.', 'error');
            } else {
                showNotification('⏳ Pembayaran masih dalam proses. Mohon tunggu sebentar.', 'info');
            }
        } else {
            showNotification('❌ Gagal memeriksa status pembayaran. Coba lagi nanti.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('❌ Terjadi kesalahan. Coba lagi nanti.', 'error');
    })
    .finally(() => {
        if (checkBtn) {
            checkBtn.disabled = false;
            checkBtn.innerHTML = '🔍 Periksa Status Pembayaran';
        }
    });
}

function searchTransaction() {
    const invoiceId = document.getElementById('invoice-search').value.trim();
    const searchBtn = document.getElementById('search-btn');

    if (!invoiceId) {
        showNotification('⚠️ Masukkan Invoice ID terlebih dahulu', 'warning');
        return;
    }

    searchBtn.disabled = true;
    searchBtn.textContent = 'Mencari...';

    checkPaymentStatus(invoiceId);

    setTimeout(() => {
        searchBtn.disabled = false;
        searchBtn.textContent = 'Cari';
    }, 2000);
}

function showNotification(message, type = 'info') {
    const colors = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'warning': 'bg-yellow-500',
        'info': 'bg-blue-500'
    };

    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} text-white p-4 rounded-lg shadow-lg z-50 max-w-sm`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="flex-1">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Auto hide after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);
}
</script>
@endsection
