{{-- resources/views/maintenance.blade.php --}}
@extends('layouts.app')

@section('title', 'Situs Sedang Maintenance')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 flex items-center justify-center py-12">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-12">
            <div class="mb-8">
                <div class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 7.172V5L8 4z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    🔧 Situs Sedang Maintenance
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Kami sedang melakukan pemeliharaan sistem untuk memberikan pelayanan yang lebih baik.
                    Mohon maaf atas ketidaknyamanannya.
                </p>
            </div>

            <div class="bg-blue-50 rounded-2xl p-6 mb-8">
                <h2 class="text-xl font-bold text-blue-900 mb-4">📱 Tetap Terhubung</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-center">
                        <span class="text-blue-700">📧 Email: {{ $content['contact_email'] }}</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <span class="text-blue-700">📱 WhatsApp: {{ $content['contact_phone'] }}</span>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <p class="text-gray-500 mb-4">Estimasi selesai: Beberapa saat lagi</p>
                <button onclick="location.reload()"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300">
                    🔄 Muat Ulang Halaman
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Auto refresh every 30 seconds
setTimeout(function() {
    location.reload();
}, 30000);
</script>
@endsection
