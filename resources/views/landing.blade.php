{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('title', $content['hero_title'])
@section('description', $content['hero_subtitle'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <!-- Hero Section -->
    <section class="relative overflow-hidden py-20 lg:py-32 px-4
    bg-[url('/images/background-hero.png')] bg-cover bg-center
    before:absolute before:inset-0 before:bg-gradient-to-br
    before:from-blue-100/50 before:via-teal-50 before:to-cyan-100/10">
    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <!-- Decorative background elements -->
        {{-- <div class="absolute inset-0 bg-gradient-to-r from-blue-200/20 to-teal-200/20"></div>
        <div class="absolute top-0 left-1/4 w-72 h-72 bg-blue-300/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-teal-300/10 rounded-full blur-3xl"></div> --}}

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h1 class="text-4xl lg:text-6xl font-light text-slate-800 mb-8 leading-tight">
                {{ $content['hero_title'] }}
            </h1>
            <p class="text-lg lg:text-xl text-slate-600 mb-12 max-w-2xl mx-auto leading-relaxed">
                {{ $content['hero_subtitle'] }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <button onclick="scrollToSection('pricing')"
                        class="w-full sm:w-auto bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 text-white px-8 py-3 text-sm tracking-wide uppercase transition-all duration-300 shadow-lg hover:shadow-xl">
                    Daftar Sekarang
                </button>
                <button onclick="scrollToSection('about')"
                        class="w-full sm:w-auto text-teal-700 border border-teal-300 hover:border-teal-600 hover:bg-teal-50 px-8 py-3 text-sm tracking-wide uppercase transition-all duration-200">
                    Pelajari Lebih Lanjut
                </button>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 lg:py-32 px-4 bg-gradient-to-br from-white to-blue-50/30">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl lg:text-4xl font-light text-slate-800 mb-8">
                        {{ $content['about_title'] }}
                    </h2>
                    <p class="text-slate-600 mb-8 leading-relaxed">
                        {{ $content['about_content'] }}
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 bg-gradient-to-r from-teal-500 to-blue-500 flex items-center justify-center mt-1 rounded-full shadow-md">
                                <span class="text-white text-xs">✓</span>
                            </div>
                            <span class="text-slate-700">Administrasi dan Tata Kelola Pemerintahan Desa</span>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 bg-gradient-to-r from-teal-500 to-blue-500 flex items-center justify-center mt-1 rounded-full shadow-md">
                                <span class="text-white text-xs">✓</span>
                            </div>
                            <span class="text-slate-700">Pengelolaan Keuangan Desa dan APBDes</span>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 bg-gradient-to-r from-teal-500 to-blue-500 flex items-center justify-center mt-1 rounded-full shadow-md">
                                <span class="text-white text-xs">✓</span>
                            </div>
                            <span class="text-slate-700">Pelayanan Masyarakat dan Pembangunan Desa</span>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 bg-gradient-to-r from-teal-500 to-blue-500 flex items-center justify-center mt-1 rounded-full shadow-md">
                                <span class="text-white text-xs">✓</span>
                            </div>
                            <span class="text-slate-700">Peraturan Perundang-undangan Desa</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white/70 backdrop-blur-sm p-4 border border-blue-100 rounded-lg shadow-lg">
                    <!-- Replace gradient box with image -->
                    <div class="w-full h-64 mb-6 rounded-lg overflow-hidden">
                        <img src="/images/mentor.png"
                            alt="Materi Kursus"
                            class="w-full h-full object-cover">
                    </div>

                    <h3 class="text-xl font-light text-slate-800 mb-2">Pembelajaran Terstruktur</h3>
                    <p class="text-slate-600 text-sm">Dengan panduan dari instruktur berpengalaman</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 lg:py-32 px-4 bg-gradient-to-r from-teal-50/50 via-white to-blue-50/50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-light text-slate-800 mb-8">
                    Keunggulan Program
                </h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($content['benefits'] as $index => $benefit)
                @php
                    $colors = [
                        'from-blue-400 to-blue-600',
                        'from-teal-400 to-teal-600',
                        'from-indigo-400 to-indigo-600',
                        'from-cyan-400 to-cyan-600'
                    ];
                    $bgColors = [
                        'from-blue-50 to-blue-100',
                        'from-teal-50 to-teal-100',
                        'from-indigo-50 to-indigo-100',
                        'from-cyan-50 to-cyan-100'
                    ];
                    $color = $colors[$index % 4];
                    $bgColor = $bgColors[$index % 4];
                @endphp
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br {{ $bgColor }} flex items-center justify-center mx-auto mb-6 rounded-full shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                        <span class="text-2xl">{{ $benefit['icon'] }}</span>
                    </div>
                    <h3 class="text-lg font-light text-slate-800 mb-3">{{ $benefit['title'] }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $benefit['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 lg:py-32 px-4 bg-gradient-to-br from-blue-50/40 to-teal-50/40">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-light text-slate-800 mb-8">
                    Testimoni Alumni
                </h2>
            </div>

            <div class="space-y-8">
                @foreach($content['testimonials'] as $index => $testimonial)
                @php
                    $gradientColors = [
                        'from-blue-500 to-teal-500',
                        'from-teal-500 to-cyan-500',
                        'from-indigo-500 to-blue-500'
                    ];
                    $gradient = $gradientColors[$index % 3];
                @endphp
                <div class="bg-white/80 backdrop-blur-sm p-8 border border-blue-100/50 rounded-lg shadow-lg {{ $index % 2 === 0 ? 'lg:mr-16' : 'lg:ml-16' }} hover:shadow-xl transition-shadow duration-300">
                    <p class="text-slate-700 mb-6 italic leading-relaxed">
                        "{{ $testimonial['content'] }}"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-r {{ $gradient }} flex items-center justify-center text-white font-light rounded-full shadow-md">
                            {{ substr($testimonial['name'], 0, 1) }}
                        </div>
                        <div>
                            <div class="font-medium text-slate-800">{{ $testimonial['name'] }}</div>
                            <div class="text-sm text-teal-600">{{ $testimonial['role'] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 lg:py-32 px-4 bg-gradient-to-r from-white to-blue-50/30">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-light text-slate-800 mb-8">
                    Investasi Pendidikan
                </h2>
                <p class="text-slate-600">
                    Satu kali pembayaran, akses seumur hidup
                </p>
            </div>

            <div class="bg-white/90 backdrop-blur-sm border border-blue-100 rounded-xl p-8 lg:p-12 shadow-xl">
                <div class="text-center mb-8">
                    <div class="text-5xl lg:text-6xl font-light bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent mb-4">
                        Rp {{ number_format($content['price'], 0, ',', '.') }}
                    </div>
                    <div class="text-slate-600">Akses seumur hidup</div>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 bg-gradient-to-r from-teal-500 to-blue-500 rounded-full"></div>
                        <span class="text-sm text-slate-700">Akses seumur hidup ke semua materi</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 bg-gradient-to-r from-teal-500 to-blue-500 rounded-full"></div>
                        <span class="text-sm text-slate-700">Bank soal dengan 1000+ pertanyaan</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 bg-gradient-to-r from-teal-500 to-blue-500 rounded-full"></div>
                        <span class="text-sm text-slate-700">Video pembelajaran berkualitas tinggi</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 bg-gradient-to-r from-teal-500 to-blue-500 rounded-full"></div>
                        <span class="text-sm text-slate-700">Sertifikat kelulusan resmi</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 bg-gradient-to-r from-teal-500 to-blue-500 rounded-full"></div>
                        <span class="text-sm text-slate-700">Konsultasi dengan mentor ahli</span>
                    </div>
                </div>

                <form id="customer-form" class="space-y-4">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <input type="text" name="name" placeholder="Nama Lengkap" required
                                class="w-full px-4 py-3 border border-blue-200 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 text-sm rounded-lg transition-all duration-200"
                                maxlength="255">
                        </div>
                        <div>
                            <input type="email" name="email" placeholder="Email Aktif" required
                                class="w-full px-4 py-3 border border-blue-200 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 text-sm rounded-lg transition-all duration-200"
                                maxlength="255">
                        </div>
                    </div>
                    <div>
                        <input type="tel" name="phone" placeholder="Nomor WhatsApp (Opsional)"
                            class="w-full px-4 py-3 border border-blue-200 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 text-sm rounded-lg transition-all duration-200"
                            pattern="^(\+62|62|0)[0-9]{8,13}$">
                    </div>

                    <button type="submit" id="choose-payment-btn"
                            class="w-full bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 text-white py-4 text-sm tracking-wide uppercase transition-all duration-300 shadow-lg hover:shadow-xl rounded-lg disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="button-text">Pilih Metode Pembayaran</span>
                        <span id="button-loading" class="hidden">Memuat...</span>
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-blue-100">
                    <div class="flex items-center justify-center gap-8 text-xs text-slate-500">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Pembayaran Aman
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                            Akses Instant
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Method Selection Modal -->
    <div id="payment-method-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white max-w-2xl w-full max-h-[90vh] overflow-y-auto rounded-xl shadow-2xl">
            <div class="p-6 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-teal-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-light text-slate-800">Metode Pembayaran</h3>
                    <button id="close-modal" class="text-slate-400 hover:text-slate-600 text-2xl transition-colors">&times;</button>
                </div>
                <div class="mt-2">
                    <p class="text-sm text-slate-600">Total: <span id="modal-amount" class="font-medium text-teal-600"></span></p>
                    <p class="text-xs text-slate-500">Untuk: <span id="modal-customer"></span></p>
                </div>
            </div>

            <div class="p-6">
                <div id="payment-methods-loading" class="text-center py-8">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-200 to-teal-200 mx-auto mb-4 rounded-full animate-pulse"></div>
                    <p class="text-sm text-slate-600">Memuat metode pembayaran...</p>
                </div>

                <div id="payment-methods-container" class="hidden">
                    <div class="space-y-3" id="payment-methods-list">
                        <!-- Payment methods will be loaded here -->
                    </div>

                    <div class="mt-8 pt-6 border-t border-blue-100">
                        <button id="proceed-payment-btn"
                                class="w-full bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 text-white py-4 text-sm tracking-wide uppercase transition-all duration-300 shadow-lg hover:shadow-xl rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            <span id="proceed-text">Pilih Metode Pembayaran</span>
                            <span id="proceed-loading" class="hidden">Memproses...</span>
                        </button>
                    </div>
                </div>

                <div id="payment-methods-error" class="hidden text-center py-8">
                    <div class="w-16 h-16 border-2 border-red-200 mx-auto mb-4 flex items-center justify-center rounded-full bg-red-50">
                        <span class="text-red-400 text-xl">!</span>
                    </div>
                    <h4 class="text-lg font-medium text-slate-800 mb-2">Gagal Memuat</h4>
                    <p class="text-sm text-slate-600 mb-4">Silakan coba lagi atau hubungi customer service</p>
                    <button id="retry-payment-methods" class="bg-gradient-to-r from-teal-600 to-blue-600 text-white px-6 py-2 text-sm tracking-wide uppercase rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                        Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <section class="py-20 lg:py-32 px-4 bg-gradient-to-br from-teal-50/40 to-blue-50/40">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-light text-slate-800 mb-8">
                    Pertanyaan Umum
                </h2>
            </div>

            <div class="space-y-1">
                <div class="bg-white/80 backdrop-blur-sm border border-blue-100 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="font-medium text-slate-800 mb-2">Berapa lama akses kursus ini?</h3>
                        <p class="text-sm text-slate-600">Anda mendapatkan akses seumur hidup setelah melakukan pembelian.</p>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm border border-blue-100 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="font-medium text-slate-800 mb-2">Apakah ada garansi uang kembali?</h3>
                        <p class="text-sm text-slate-600">Ya, kami memberikan garansi 30 hari uang kembali jika tidak puas.</p>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm border border-blue-100 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="font-medium text-slate-800 mb-2">Bagaimana cara mengakses materi?</h3>
                        <p class="text-sm text-slate-600">Setelah pembayaran berhasil, Anda akan menerima email dengan link akses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-4 border-t border-blue-00 bg-gradient-to-r from-white to-blue-50/20">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="text-xl font-light text-slate-800 mb-4">{{ $content['course_name'] }}</h3>
            <p class="text-sm text-slate-600 mb-6">Persiapkan masa depan Anda bersama kami</p>

            <div class="flex justify-center gap-8 text-xs text-slate-500 mb-6">
                <a href="#" class="hover:text-teal-600 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-teal-600 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-teal-600 transition-colors">Contact</a>
            </div>

            <!-- Kontak Support -->
            <div class="text-sm text-slate-600 mb-6 space-y-1">
                <p>email: <a href="mailto:tkursus.digidesa@gmail.com" class="hover:text-teal-600">kursus.digidesa@gmail.com</a></p>
                <p>Nomor Telepon: <a href="tel:kursus.digidesa@gmail.com" class="hover:text-teal-600">kursus.digidesa@gmail.com</a></p>
                <p>Alamat Usaha: Timbang, Kejobong, Purbalingga, Jawa Tengah</p>
            </div>

            <p class="text-xs text-slate-400">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>

</div>

<!-- Notifications -->
@if($errors->any())
<div class="fixed top-4 right-4 bg-gradient-to-r from-red-500 to-pink-500 text-white p-4 max-w-sm z-50 rounded-lg shadow-lg" id="error-notification">
    <div class="flex items-center justify-between">
        <span class="text-sm">{{ $errors->first() }}</span>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-red-200 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@endif

@if(session('success'))
<div class="fixed top-4 right-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white p-4 max-w-sm z-50 rounded-lg shadow-lg" id="success-notification">
    <div class="flex items-center justify-between">
        <span class="text-sm">{{ session('success') }}</span>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-green-200 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@endif

<script>
// Smooth scrolling function
function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Enhanced payment flow with payment method selection
document.addEventListener('DOMContentLoaded', function() {
    const customerForm = document.getElementById('customer-form');
    const choosePaymentBtn = document.getElementById('choose-payment-btn');
    const buttonText = document.getElementById('button-text');
    const buttonLoading = document.getElementById('button-loading');

    // Modal elements
    const paymentModal = document.getElementById('payment-method-modal');
    const closeModal = document.getElementById('close-modal');
    const paymentMethodsLoading = document.getElementById('payment-methods-loading');
    const paymentMethodsContainer = document.getElementById('payment-methods-container');
    const paymentMethodsError = document.getElementById('payment-methods-error');
    const paymentMethodsList = document.getElementById('payment-methods-list');
    const proceedPaymentBtn = document.getElementById('proceed-payment-btn');
    const retryBtn = document.getElementById('retry-payment-methods');

    let currentUserData = null;
    let currentPaymentMethods = null;
    let selectedPaymentMethod = null;

    // Phone number formatting
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = value;
            } else if (value.length > 0) {
                value = '0' + value;
            }
            e.target.value = value;
        });
    }

    // Step 1: Get payment methods
    customerForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(customerForm);
        const customerData = {
            name: formData.get('name').trim(),
            email: formData.get('email').trim(),
            phone: formData.get('phone').trim()
        };

        // Validate customer data
        if (customerData.name.length < 2) {
            showError('Nama harus minimal 2 karakter');
            return;
        }

        if (!isValidEmail(customerData.email)) {
            showError('Format email tidak valid');
            return;
        }

        // Store customer data and fetch payment methods
        currentUserData = customerData;
        fetchPaymentMethods(customerData);
    });

    function fetchPaymentMethods(customerData) {
        setButtonLoading(true);

        fetch('{{ route("payment.methods") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(customerData)
        })
        .then(response => response.json())
        .then(data => {
            setButtonLoading(false);

            if (data.status === 'success') {
                currentPaymentMethods = data.data.payment_methods;
                showPaymentMethodModal(data.data);
            } else {
                showError(data.message || 'Gagal mengambil metode pembayaran');
            }
        })
        .catch(error => {
            setButtonLoading(false);
            console.error('Error:', error);
            showError('Terjadi kesalahan. Silakan coba lagi.');
        });
    }

    function showPaymentMethodModal(data) {
        // Update modal info
        document.getElementById('modal-amount').textContent = data.formatted_amount;
        document.getElementById('modal-customer').textContent = `${data.user_data.name} (${data.user_data.email})`;

        // Show modal
        paymentModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Load payment methods
        loadPaymentMethods(data.payment_methods);
    }

    function loadPaymentMethods(paymentMethods) {
        paymentMethodsLoading.classList.remove('hidden');
        paymentMethodsContainer.classList.add('hidden');
        paymentMethodsError.classList.add('hidden');

        if (!paymentMethods || paymentMethods.length === 0) {
            showPaymentMethodsError();
            return;
        }

        // Render payment methods
        paymentMethodsList.innerHTML = '';

        paymentMethods.forEach(method => {
            const methodElement = createPaymentMethodElement(method);
            paymentMethodsList.appendChild(methodElement);
        });

        // Show payment methods
        setTimeout(() => {
            paymentMethodsLoading.classList.add('hidden');
            paymentMethodsContainer.classList.remove('hidden');
        }, 500);
    }

    function createPaymentMethodElement(method) {
        const div = document.createElement('div');
        div.className = 'payment-method-option border border-blue-200 p-4 cursor-pointer hover:border-teal-500 hover:bg-blue-50/30 transition-all duration-200 rounded-lg';
        div.dataset.paymentMethod = method.paymentMethod;

        div.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-8 bg-blue-50 border border-blue-100 flex items-center justify-center overflow-hidden rounded">
                        <img src="${method.paymentImage}" alt="${method.paymentName}" class="max-w-full max-h-full object-contain"
                             onerror="this.style.display='none'; this.parentElement.innerHTML='<span class=\\"text-xs text-slate-500\\">${method.paymentMethod}</span>'">
                    </div>
                    <div>
                        <h4 class="font-medium text-slate-800">${method.paymentName}</h4>
                        <p class="text-xs text-slate-500">Kode: ${method.paymentMethod}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    ${method.totalFee === '0' || method.totalFee === 0 ?
                        '<span class="text-emerald-600 text-sm font-medium">Gratis</span>' :
                        `<span class="text-slate-600 text-xs">+Rp ${parseInt(method.totalFee).toLocaleString('id-ID')}</span>`
                    }
                    <div class="w-4 h-4 border-2 border-blue-300 rounded-full payment-radio transition-all duration-200"></div>
                </div>
            </div>
        `;

        div.addEventListener('click', function() {
            selectPaymentMethod(method, div);
        });

        return div;
    }

    function selectPaymentMethod(method, element) {
        // Remove previous selection
        document.querySelectorAll('.payment-method-option').forEach(el => {
            el.classList.remove('border-teal-500', 'bg-blue-50/30');
            const radio = el.querySelector('.payment-radio');
            radio.classList.remove('border-teal-500', 'bg-gradient-to-r', 'from-teal-500', 'to-blue-500');
            radio.innerHTML = '';
        });

        // Add selection to clicked element
        element.classList.add('border-teal-500', 'bg-blue-50/30');
        const radio = element.querySelector('.payment-radio');
        radio.classList.add('border-teal-500', 'bg-gradient-to-r', 'from-teal-500', 'to-blue-500');
        radio.innerHTML = '<div class="w-2 h-2 bg-white rounded-full mx-auto"></div>';

        selectedPaymentMethod = method;

        // Enable proceed button
        proceedPaymentBtn.disabled = false;
        document.getElementById('proceed-text').textContent = `Bayar dengan ${method.paymentName}`;
    }

    function showPaymentMethodsError() {
        paymentMethodsLoading.classList.add('hidden');
        paymentMethodsContainer.classList.add('hidden');
        paymentMethodsError.classList.remove('hidden');
    }

    // Step 2: Create transaction
    proceedPaymentBtn.addEventListener('click', function() {
        if (!selectedPaymentMethod) return;

        createTransaction();
    });

    function createTransaction() {
        const proceedText = document.getElementById('proceed-text');
        const proceedLoading = document.getElementById('proceed-loading');

        proceedPaymentBtn.disabled = true;
        proceedText.classList.add('hidden');
        proceedLoading.classList.remove('hidden');

        const transactionData = {
            ...currentUserData,
            payment_method: selectedPaymentMethod.paymentMethod
        };

        fetch('{{ route("payment.initiate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(transactionData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Store transaction data for thank you page
                localStorage.setItem('payment_form_data', JSON.stringify({
                    name: currentUserData.name,
                    email: currentUserData.email,
                    invoice_id: data.data.invoice_id,
                    timestamp: Date.now()
                }));

                // Redirect to payment URL
                window.location.href = data.data.payment_url;
            } else {
                showError(data.message || 'Gagal membuat pembayaran');
                resetProceedButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Terjadi kesalahan. Silakan coba lagi.');
            resetProceedButton();
        });
    }

    function resetProceedButton() {
        const proceedText = document.getElementById('proceed-text');
        const proceedLoading = document.getElementById('proceed-loading');

        proceedPaymentBtn.disabled = false;
        proceedText.classList.remove('hidden');
        proceedLoading.classList.add('hidden');
    }

    // Modal controls
    closeModal.addEventListener('click', hidePaymentMethodModal);
    retryBtn.addEventListener('click', function() {
        if (currentUserData) {
            fetchPaymentMethods(currentUserData);
        }
    });

    // Close modal on outside click
    paymentModal.addEventListener('click', function(e) {
        if (e.target === paymentModal) {
            hidePaymentMethodModal();
        }
    });

    function hidePaymentMethodModal() {
        paymentModal.classList.add('hidden');
        document.body.style.overflow = '';
        selectedPaymentMethod = null;
        proceedPaymentBtn.disabled = true;
        document.getElementById('proceed-text').textContent = 'Pilih Metode Pembayaran';
    }

    // Helper functions
    function setButtonLoading(loading) {
        choosePaymentBtn.disabled = loading;
        if (loading) {
            buttonText.classList.add('hidden');
            buttonLoading.classList.remove('hidden');
        } else {
            buttonText.classList.remove('hidden');
            buttonLoading.classList.add('hidden');
        }
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function showError(message) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification-error');
        existingNotifications.forEach(notif => notif.remove());

        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-gradient-to-r from-red-500 to-pink-500 text-white p-4 max-w-sm z-50 notification-error rounded-lg shadow-lg';
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="text-sm">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-red-200 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
});
</script>
@endsection
