{{-- resources/views/thank-you.blade.php --}}
@extends('layouts.app')

@section('title', 'Terima Kasih - Pembayaran Berhasil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 flex items-center justify-center py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-12 text-center">
            @if($transaction && $transaction->payment_status === 'paid')
                <!-- Success State -->
                <div class="mb-8">
                    <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Pembayaran Berhasil!
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Terima kasih telah bergabung dengan Kursus Ujian Perangkat Desa
                    </p>
                </div>

                <!-- Transaction Details -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Detail Transaksi</h2>
                    <div class="space-y-3 text-left">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Invoice ID:</span>
                            <span class="font-semibold">{{ $transaction->invoice_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-semibold">{{ $transaction->user_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-semibold">{{ $transaction->user_email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-semibold text-green-600">{{ $transaction->formatted_amount }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Lunas</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal:</span>
                            <span class="font-semibold">{{ $transaction->paid_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-blue-50 rounded-2xl p-6 mb-8">
                    <h2 class="text-xl font-bold text-blue-900 mb-4">Langkah Selanjutnya</h2>
                    <div class="space-y-3 text-left text-blue-800">
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1">1</span>
                            <span>Cek email Anda untuk mendapatkan link akses ke platform pembelajaran</span>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1">2</span>
                            <span>Login menggunakan email yang telah terdaftar</span>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1">3</span>
                            <span>Mulai belajar dan raih kesuksesan dalam ujian perangkat desa</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <a href="mailto:support@example.com"
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300 inline-block">
                        Hubungi Support Jika Belum Terima Email
                    </a>
                    <a href="{{ route('landing') }}"
                       class="w-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300 inline-block">
                        Kembali ke Beranda
                    </a>
                </div>

            @elseif($transaction && $transaction->payment_status === 'pending')
                <!-- Pending State -->
                <div class="mb-8">
                    <div class="w-24 h-24 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Pembayaran Sedang Diproses
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Silakan selesaikan pembayaran Anda atau tunggu konfirmasi
                    </p>
                </div>

                <div class="bg-yellow-50 rounded-2xl p-6 mb-8">
                    <p class="text-yellow-800">
                        Invoice ID: <strong>{{ $transaction->invoice_id }}</strong><br>
                        Jumlah: <strong>{{ $transaction->formatted_amount }}</strong>
                    </p>
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
                        Terima Kasih
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Kami akan segera memproses pesanan Anda
                    </p>
                </div>
            @endif

            <!-- Support Contact -->
            <div class="mt-8 pt-8 border-t border-gray-200 text-sm text-gray-500">
                <p>Butuh bantuan? Hubungi kami di:</p>
                <p class="font-semibold text-gray-700">
                    Email: support@example.com | WhatsApp: +62 812-3456-7890
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
