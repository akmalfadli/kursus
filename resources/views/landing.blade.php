{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('title', $content['hero_title'])
@section('description', $content['hero_subtitle'])

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white">
        <div class="container mx-auto px-4 py-16 lg:py-24">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                    {{ $content['hero_title'] }}
                </h1>
                <p class="text-xl lg:text-2xl mb-8 text-blue-100 leading-relaxed">
                    {{ $content['hero_subtitle'] }}
                </p>
                <div class="space-y-4 lg:space-y-0 lg:space-x-4 lg:flex lg:justify-center">
                    <button onclick="scrollToSection('pricing')"
                            class="w-full lg:w-auto bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        BELAJAR SEKARANG
                    </button>
                    <button onclick="scrollToSection('about')"
                            class="w-full lg:w-auto border-2 border-white text-white hover:bg-white hover:text-blue-700 font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300">
                        Pelajari Lebih Lanjut
                    </button>
                </div>
            </div>
        </div>

        <!-- Wave divider -->
        <div class="relative">
            <svg class="w-full h-16 lg:h-24" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                      fill="rgb(249 250 251)"></path>
            </svg>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 lg:py-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-6">
                        {{ $content['about_title'] }}
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        {{ $content['about_content'] }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Yang Akan Anda Pelajari:</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1">✓</span>
                                <span class="text-gray-700">Administrasi dan Tata Kelola Pemerintahan Desa</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1">✓</span>
                                <span class="text-gray-700">Pengelolaan Keuangan Desa dan APBDes</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1">✓</span>
                                <span class="text-gray-700">Pelayanan Masyarakat dan Pembangunan Desa</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-1">✓</span>
                                <span class="text-gray-700">Peraturan Perundang-undangan Desa</span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <img src="/api/placeholder/400/300" alt="Kursus Image" class="w-full h-64 object-cover rounded-lg mb-6">
                        <div class="text-center">
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Materi Terlengkap</h4>
                            <p class="text-gray-600">Dengan dukungan instruktur berpengalaman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-16 lg:py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Mengapa Memilih Kursus Ini?
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Dapatkan keunggulan kompetitif dengan fitur-fitur terbaik yang kami tawarkan
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($content['benefits'] as $benefit)
                    <div class="bg-gray-50 rounded-2xl p-8 text-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-5xl mb-4">{{ $benefit['icon'] }}</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $benefit['title'] }}</h3>
                        <p class="text-gray-600">{{ $benefit['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 lg:py-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Kata Mereka
                    </h2>
                    <p class="text-xl text-gray-600">
                        Testimoni dari para alumni yang telah berhasil
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    @foreach($content['testimonials'] as $testimonial)
                    <div class="bg-white rounded-2xl p-8 shadow-lg">
                        <div class="mb-6">
                            <div class="flex text-yellow-500 mb-4">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                @endfor
                            </div>
                            <p class="text-gray-700 text-lg italic">"{{ $testimonial['content'] }}"</p>
                        </div>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                {{ substr($testimonial['name'], 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">{{ $testimonial['name'] }}</div>
                                <div class="text-gray-600">{{ $testimonial['role'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16 lg:py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Investasi Terbaik untuk Masa Depan Anda
                    </h2>
                    <p class="text-xl text-gray-600">
                        Dapatkan akses seumur hidup dengan harga terjangkau
                    </p>
                </div>

                <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-8 lg:p-12 text-white text-center shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="mb-8">
                        <div class="text-6xl lg:text-8xl font-bold mb-4">
                            Rp {{ number_format($content['price'], 0, ',', '.') }}
                        </div>
                        <div class="text-xl text-blue-100">Sekali bayar, akses selamanya</div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-2xl font-bold mb-6">Yang Anda Dapatkan:</h3>
                        <ul class="text-left max-w-md mx-auto space-y-3">
                            <li class="flex items-center">
                                <span class="bg-yellow-500 text-gray-900 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3">✓</span>
                                Akses seumur hidup ke semua materi
                            </li>
                            <li class="flex items-center">
                                <span class="bg-yellow-500 text-gray-900 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3">✓</span>
                                Bank soal dengan 1000+ pertanyaan
                            </li>
                            <li class="flex items-center">
                                <span class="bg-yellow-500 text-gray-900 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3">✓</span>
                                Video pembelajaran HD
                            </li>
                            <li class="flex items-center">
                                <span class="bg-yellow-500 text-gray-900 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3">✓</span>
                                Sertifikat kelulusan
                            </li>
                            <li class="flex items-center">
                                <span class="bg-yellow-500 text-gray-900 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3">✓</span>
                                Konsultasi dengan mentor
                            </li>
                        </ul>
                    </div>

                    <form action="{{ route('payment.initiate') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Nama Lengkap" required
                                   class="w-full px-4 py-3 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <input type="email" name="email" placeholder="Email" required
                                   class="w-full px-4 py-3 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <input type="tel" name="phone" placeholder="Nomor WhatsApp (Opsional)"
                               class="w-full px-4 py-3 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500">

                        <button type="submit"
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-4 px-8 rounded-lg text-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                            BELAJAR SEKARANG - BAYAR AMAN
                        </button>
                    </form>

                    <div class="mt-6 text-sm text-blue-100">
                        <div class="flex items-center justify-center space-x-4">
                            <span>🔒 Pembayaran 100% Aman</span>
                            <span>💳 Semua Metode Pembayaran</span>
                            <span>📱 Akses Instant</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 lg:py-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Pertanyaan yang Sering Diajukan
                    </h2>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Berapa lama akses kursus ini?</h3>
                        <p class="text-gray-600">Anda mendapatkan akses seumur hidup setelah melakukan pembelian. Tidak ada batasan waktu.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Apakah ada garansi uang kembali?</h3>
                        <p class="text-gray-600">Ya, kami memberikan garansi 30 hari uang kembali jika Anda tidak puas dengan kursus ini.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Bagaimana cara mengakses materi setelah pembayaran?</h3>
                        <p class="text-gray-600">Setelah pembayaran berhasil, Anda akan menerima email dengan link akses ke platform pembelajaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h3 class="text-2xl font-bold mb-4">{{ $content['course_name'] }}</h3>
                <p class="text-gray-400 mb-6">Persiapkan masa depan Anda bersama kami</p>
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-800 text-gray-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</div>

@if($errors->any())
<div class="fixed top-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50">
    {{ $errors->first() }}
</div>
@endif

<script>
function scrollToSection(sectionId) {
    document.getElementById(sectionId).scrollIntoView({
        behavior: 'smooth'
    });
}

// Auto hide error messages
setTimeout(function() {
    const errors = document.querySelectorAll('.fixed.bg-red-500');
    errors.forEach(error => error.remove());
}, 5000);
</script>
@endsection
