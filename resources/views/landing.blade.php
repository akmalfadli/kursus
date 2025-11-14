{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('title', $content['hero_title'])
@section('description', $content['hero_subtitle'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
    <!-- Floating Alert Bar -->
    <div class="bg-gradient-to-r from-orange-400 to-orange-700 text-white py-2 px-4 text-center text-sm font-medium sticky top-0 z-50 shadow-lg">
        🎉 <span class="font-bold">Promo Terbatas!</span> Daftar sekarang dan dapatkan akses seumur hidup + bonus eksklusif
    </div>

    <!-- Hero Section - Compact & Powerful -->
    <section class="relative overflow-hidden py-12 lg:py-20 px-4">
        <div class="absolute inset-0 bg-[url('/images/background-hero.png')] bg-cover bg-center opacity-10"></div>

        <div class="relative z-10 max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <!-- Left: Content -->
                <div>
                    <!-- Trust Badge -->
                    <div class="inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-lg mb-6 border border-orange-100">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-400 to-red-400 border-2 border-white"></div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-red-400 to-pink-400 border-2 border-white"></div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-pink-400 to-rose-400 border-2 border-white"></div>
                        </div>
                        <span class="text-sm font-medium text-slate-700">
                            <span class="text-orange-500 font-bold">Pemateri</span> Berpengalaman
                        </span>
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 mb-4 leading-tight">
                        Lolos Ujian <span class="text-transparent bg-clip-text bg-gradient-to-r  from-orange-400 to-orange-500">Perangkat Desa</span> Dengan Mudah
                    </h1>

                    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                        Persiapan lengkap dengan <strong>soal latihan</strong>, materi pembelajaran, dan mentoring langsung melalui zoom meeting. Tingkatkan peluang Anda hingga <span class="text-orange-600 font-bold">95%</span>!
                    </p>

                    <!-- Key Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-8 p-6 bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-orange-100">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-orange-600">100+</div>
                            <div class="text-xs text-slate-600">Soal Latihan</div>
                        </div>
                        <div class="text-center border-x border-slate-200">
                            <div class="text-3xl font-bold text-red-600">95%</div>
                            <div class="text-xs text-slate-600">Tingkat Lulus</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-pink-600">24/7</div>
                            <div class="text-xs text-slate-600">Akses Materi</div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 mb-6">
                        <button onclick="scrollToSection('pricing')"
                                class="flex-1 sm:flex-none bg-gradient-to-r  from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                            🎯 Daftar Sekarang
                        </button>
                        <button onclick="scrollToSection('benefits')"
                                class="flex-1 sm:flex-none border-2 border-orange-600 text-orange-600 hover:bg-orange-50 px-8 py-4 rounded-xl font-semibold transition-all duration-300">
                            Lihat Benefit
                        </button>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-slate-600">
                        <div class="flex items-center gap-1">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="font-semibold">4.9/5</span> Rating
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Garansi 30 Hari
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Pembayaran Aman
                        </div>
                    </div>
                </div>

                <!-- Right: Image/Visual -->
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="/images/graduation.png" alt="Mentor Kursus" class="w-full h-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                        <!-- Floating Achievement Card -->
                        <div class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur-sm rounded-xl p-4 shadow-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-slate-600">Tingkat Kelulusan</div>
                                    <div class="text-sm text-slate-600">meningkatkan percaya diri saat menjalani ujian</div>
                                    <div class="text-2xl font-bold text-orange-600">95%</div>
                                </div>
                                <div class="w-16 h-16 bg-gradient-to-r from-orange-400 to-red-400 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section - Compact Grid -->
    <section id="benefits" class="py-16 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-800 mb-3">
                    Kenapa Memilih Kursus Ini?
                </h2>
                <p class="text-slate-600">Semua yang Anda butuhkan untuk sukses dalam satu platform</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($content['benefits'] as $index => $benefit)
                <div class="group bg-gradient-to-br from-white to-orange-50 p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-orange-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="text-2xl">{{ $benefit['icon'] }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">{{ $benefit['title'] }}</h3>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $benefit['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials - Compact Carousel Style
    <section class="py-16 px-4 bg-gradient-to-br from-orange-50 to-red-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-800 mb-3">
                    Mereka Sudah Berhasil
                </h2>
                <p class="text-slate-600">Bergabung dengan ratusan alumni yang sudah diterima</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach($content['testimonials'] as $index => $testimonial)
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-red-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($testimonial['name'], 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-800">{{ $testimonial['name'] }}</div>
                            <div class="text-sm text-orange-600">{{ $testimonial['role'] }}</div>
                        </div>
                    </div>
                    <div class="flex gap-1 mb-3">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-slate-600 text-sm italic">"{{ $testimonial['content'] }}"</p>
                </div>
                @endforeach
            </div>
        </div>
    </section> -->

    <!-- Pricing Section - Bold & Clear -->
    <section id="pricing" class="py-16 px-4 bg-white">
        <div class="max-w-4xl mx-auto">
            <!-- Urgency Banner -->
              <div class="bg-gradient-to-r from-blue-500 to-pink-500 text-white text-center py-3 px-6 rounded-xl mb-8 shadow-lg">
                <div class="flex items-center justify-center gap-2 text-xl font-bold">
                    <span>❗❗ KURSUS {{ strtoupper($content['default_class']) }} SEGERA DIMULAI ❗❗</span>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-pink-500 text-white text-center py-3 px-6 rounded-xl mb-8 shadow-lg">
                <div class="flex items-center justify-center gap-2 text-sm font-bold">
                    <svg class="w-5 h-5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    <span>⏰ Promo Terbatas! Harga Normal Rp 500.000</span>
                </div>
            </div>

            <div class="bg-gradient-to-br from-white to-orange-50 rounded-3xl shadow-2xl overflow-hidden border-4 border-orange-500">
                <!-- Badge -->
                <div class="bg-gradient-to-r from-blue-600 to-orange-600 text-white text-center py-3 font-bold">
                    🔥 PAKET TERLARIS - HEMAT 60%
                </div>

                <div class="p-8 lg:p-12">
                    <!-- Price -->
                    <div class="text-center mb-8">
                        <div class="text-slate-500 text-lg line-through mb-2">Rp 500.000</div>
                        <div class="text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-red-600 mb-2">
                            Rp {{ number_format($content['price'], 0, ',', '.') }}
                        </div>
                        <div class="text-slate-600 font-medium">Pembayaran Sekali - Akses Selamanya</div>
                    </div>

                    <!-- Features -->
                    <div class="grid md:grid-cols-2 gap-4 mb-8">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700"><strong>100+</strong> Soal Latihan Premium</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700">Zoom Meeting & Recording</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700">Akses Materi <strong>24/7</strong></span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700">Mentoring <strong>Langsung</strong></span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700">Update Materi <strong>Gratis</strong></span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700">Garansi <strong>30 Hari</strong></span>
                        </div>
                    </div>

                    <!-- Form -->
                    <form id="customer-form" class="space-y-4">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Nama Lengkap *" required
                                class="w-full px-4 py-4 border-2 border-slate-200 focus:border-orange-500 focus:outline-none rounded-xl text-base transition-colors"
                                maxlength="255">
                            <input type="email" name="email" placeholder="Email Aktif *" required
                                class="w-full px-4 py-4 border-2 border-slate-200 focus:border-orange-500 focus:outline-none rounded-xl text-base transition-colors"
                                maxlength="255">
                        </div>
                        <input type="tel" name="phone" placeholder="Nomor WhatsApp (Opsional)"
                            class="w-full px-4 py-4 border-2 border-slate-200 focus:border-orange-500 focus:outline-none rounded-xl text-base transition-colors"
                            pattern="^(\+62|62|0)[0-9]{8,13}$">

                        <button type="submit" id="choose-payment-btn"
                                class="w-full bg-gradient-to-r from-blue-600 to-orange-600 hover:from-orange-700 hover:to-blue-700 text-white py-5 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <span id="button-text" class="flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                                </svg>
                                Daftar Sekarang - Bayar Aman
                            </span>
                            <span id="button-loading" class="hidden">Memuat...</span>
                        </button>
                    </form>

                    <!-- Trust Badges -->
                    <div class="mt-6 flex flex-wrap items-center justify-center gap-6 text-sm text-slate-500">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Pembayaran Aman
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Akses Instant
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                            </svg>
                            Garansi 30 Hari
                        </div>
                    </div>

                    <!-- Money Back Guarantee -->
                    <div class="mt-6 p-4 bg-yellow-50 border-2 border-yellow-200 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">100% Money-Back Guarantee</div>
                                <div class="text-sm text-slate-600">Tidak puas? Kami kembalikan uang Anda dalam 30 hari.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Method Modal -->
    <div id="payment-method-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white max-w-2xl w-full max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl">
            <div class="sticky top-0 p-6 border-b bg-gradient-to-r from-orange-300 to-orange-500 text-white rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">Pilih Metode Pembayaran</h3>
                        <p class="text-sm opacity-90 mt-1">Total: <span id="modal-amount" class="font-bold"></span></p>
                    </div>
                    <button id="close-modal" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6">
                <div id="payment-methods-loading" class="text-center py-12">
                    <div class="w-16 h-16 border-4 border-orange-200 border-t-orange-600 rounded-full animate-spin mx-auto mb-4"></div>
                    <p class="text-slate-600">Memuat metode pembayaran...</p>
                </div>

                <div id="payment-methods-container" class="hidden">
                    <div class="space-y-3" id="payment-methods-list"></div>

                    <button id="proceed-payment-btn"
                            class="w-full mt-6 bg-gradient-to-r  from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        <span id="proceed-text">Pilih Metode Pembayaran</span>
                        <span id="proceed-loading" class="hidden">Memproses...</span>
                    </button>
                </div>

                <div id="payment-methods-error" class="hidden text-center py-12">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-2">Gagal Memuat</h4>
                    <p class="text-slate-600 mb-4">Silakan coba lagi atau hubungi customer service</p>
                    <button id="retry-payment-methods" class="bg-gradient-to-r from-orange-600 to-red-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">
                        Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Scroll Promo Popup -->
    <div id="promo-popup" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 animate-fadeIn">
        <div class="bg-white max-w-2xl w-full max-h-[90vh] rounded-3xl shadow-2xl overflow-y-auto transform animate-slideUp">
            <!-- Header with Close Button -->
            <div class="relative bg-gradient-to-r  from-orange-600 to-red-600 text-white p-2 text-center sticky top-0 z-10">
            <button id="close-promo-popup" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-colors">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <h2 class="text-2xl font-bold mb-2">PROMO SPESIAL!</h2>
            <p class="text-lg opacity-90">Kesempatan Terbatas - Jangan Sampai Terlewat!</p>
            </div>

            <!-- Content -->
            <div class="p-4">
                <!-- Discount Section -->
                <div class="text-center mb-3">
                    <div class="inline-block bg-red-100 border-2 border-orange-500 rounded-xl px-3 py-3 mb-2">
                        <div class="text-orange-600 font-bold text-md mb-1">❗ KURSUS {{ strtoupper($content['default_class']) }} SEGERA DIMULAI ❗</div>
                        <div class="text-orange-600 font-bold text-md mb-1">DISKON 60%</div>
                        <div class="flex items-center justify-center gap-3">
                            <span class="text-xl text-slate-400 line-through">Rp 500.000</span>
                            <span class="text-2xl font-bold text-orange-600">Rp {{ number_format($content['price'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Benefits -->
                <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-3 mb-3">
                    <h3 class="font-bold text-xl text-slate-800 mb-4 text-center">🎓 Dapatkan Materi Lengkap:</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700"><strong>Persiapan Mental</strong> - Teknik menghadapi ujian dengan percaya diri</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700"><strong>Materi UUD 1945</strong> - Lengkap dan mudah dipahami</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700"><strong>Kewarganegaraan</strong> - Materi esensial untuk ujian</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700"><strong>Pengetahuan Umum Tentang Desa</strong> - Komprehensif dan terkini</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700"><strong> Kepemerintahan, Administrasi Perkantoran</strong> dan Kepemimpinan</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-700"><strong>Word, Excel, Power Point</strong> - Penguasaan dasar aplikasi perkantoran dan pengolahan data</span>
                        </div>
                    </div>
                </div>

                <!-- Mentor Image & Info Section -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl overflow-hidden border-2 border-blue-200 mb-2">
                    <div class="flex flex-col sm:flex-row gap-4 p-4">
                        <!-- Mentor Image -->
                        <div class="flex-shrink-0">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto sm:mx-0 rounded-xl overflow-hidden border-4 border-white shadow-lg">
                                <img src="/images/mentor.png" alt="Mentor Profesional" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <!-- Mentor Info -->
                        <div class="flex-1 text-center sm:text-left">
                            <h4 class="font-bold text-lg text-slate-800 mb-2">👨‍🏫 Mentor Profesional</h4>
                            <div class="text-sm text-slate-700 space-y-1">
                                <div class="flex items-start sm:items-center gap-2 justify-center sm:justify-start">
                                    <span class="text-blue-600 flex-shrink-0">✓</span>
                                    <span><strong>15+ tahun</strong> pengalaman bidang desa</span>
                                </div>
                                <div class="flex items-start sm:items-center gap-2 justify-center sm:justify-start">
                                    <span class="text-blue-600 flex-shrink-0">✓</span>
                                    <span>Pendamping desa profesional</span>
                                </div>
                                <div class="flex items-start sm:items-center gap-2 justify-center sm:justify-start">
                                    <span class="text-blue-600 flex-shrink-0">✓</span>
                                    <span>Pembicara nasional</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Button - Blinking -->
                <div class="sticky bottom-0 bg-white p-4 z-10">
                    <button id="promo-daftar-btn" class="w-full bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white py-4 rounded-xl font-bold text-xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 animate-pulse-slow">
                    <span class="flex items-center justify-center gap-3">
                        DAFTAR SEKARANG <br> HEMAT 60%
                    </span>
                    </button>
                </div>
                </div>
            </div>
            </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/62{{ preg_replace('/[^0-9]/', '', $content['contact_phone']) }}?text=Halo%2C%20saya%20tertarik%20dengan%20kursus%20{{ urlencode($content['course_name']) }}.%0ANama%20%3A%20%0AAlamat%20%3A%20"
       target="_blank"
       rel="noopener noreferrer"
       class="fixed bottom-12 right-12 z-50 group"
       id="whatsapp-fab"
       aria-label="Chat via WhatsApp">
        <div class="relative">
            <!-- Main Button -->
            <div class="w-16 h-16 bg-green-500 hover:bg-green-600 rounded-full shadow-2xl flex items-center justify-center transform transition-all duration-300 hover:scale-110 group-hover:shadow-green-500/50">
                <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
            </div>

            <!-- Pulse Animation -->
            <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-75"></div>

            <!-- Tooltip -->
            <div class="absolute right-full mr-3 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                <div class="bg-slate-900 text-white px-4 py-2 rounded-lg shadow-xl whitespace-nowrap text-sm font-medium">
                    Butuh Bantuan? Chat Kami!
                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 rotate-45 w-2 h-2 bg-slate-900"></div>
                </div>
            </div>
        </div>
    </a>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse-slow {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            60% {
                opacity: 0.95;
                transform: scale(1.02);
            }
        }

        @keyframes ping {
            75%, 100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.5s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .animate-ping {
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        /* Responsive WhatsApp Button */
        @media (max-width: 640px) {
            #whatsapp-fab {
                bottom: 1rem;
                right: 1rem;
            }

            #whatsapp-fab .w-16 {
                width: 3.5rem;
                height: 3.5rem;
            }

            #whatsapp-fab svg {
                width: 2rem;
                height: 2rem;
            }
        }
    </style>

    <!-- Compact Footer -->
    <footer class="py-8 px-4 bg-slate-900 text-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-3 gap-8 mb-6">
                <div>
                    <h3 class="text-xl font-bold mb-3">{{ $content['course_name'] }}</h3>
                    <p class="text-slate-400 text-sm">Persiapan terbaik untuk ujian perangkat desa</p>
                </div>
                <div>
                    <h4 class="font-bold mb-3">Tautan Cepat</h4>
                    <div class="space-y-2 text-sm">
                        <a href="{{ route('privacy-policy') }}" class="block text-slate-400 hover:text-white transition-colors">Kebijakan Privasi</a>
                        <a href="{{ route('terms-of-service') }}" class="block text-slate-400 hover:text-white transition-colors">Syarat & Ketentuan</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-3">Hubungi Kami</h4>
                    <div class="space-y-2 text-sm text-slate-400">
                        <p>📧 {{ $content['contact_email'] }}</p>
                        <p>📱 {{ $content['contact_phone'] }}</p>
                    </div>
                </div>
            </div>
            <div class="pt-6 border-t border-slate-800 text-center text-slate-400 text-sm">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </footer>
</div>

<!-- Notifications remain the same -->
@if($errors->any())
<div class="fixed top-4 right-4 bg-red-500 text-white p-4 rounded-xl shadow-2xl z-50 max-w-sm" id="error-notification">
    <div class="flex items-center justify-between">
        <span class="text-sm">{{ $errors->first() }}</span>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@endif

@if(session('success'))
<div class="fixed top-4 right-4 bg-green-500 text-white p-4 rounded-xl shadow-2xl z-50 max-w-sm" id="success-notification">
    <div class="flex items-center justify-between">
        <span class="text-sm">{{ session('success') }}</span>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@endif

<script>
// Smooth scrolling
function scrollToSection(sectionId) {
    document.getElementById(sectionId)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Payment flow (keep existing JavaScript logic)
document.addEventListener('DOMContentLoaded', function() {
    const customerForm = document.getElementById('customer-form');
    const choosePaymentBtn = document.getElementById('choose-payment-btn');
    const buttonText = document.getElementById('button-text');
    const buttonLoading = document.getElementById('button-loading');
    const paymentModal = document.getElementById('payment-method-modal');
    const closeModal = document.getElementById('close-modal');
    const paymentMethodsLoading = document.getElementById('payment-methods-loading');
    const paymentMethodsContainer = document.getElementById('payment-methods-container');
    const paymentMethodsError = document.getElementById('payment-methods-error');
    const paymentMethodsList = document.getElementById('payment-methods-list');
    const proceedPaymentBtn = document.getElementById('proceed-payment-btn');
    const retryBtn = document.getElementById('retry-payment-methods');

    // Promo Popup Elements
    const promoPopup = document.getElementById('promo-popup');
    const closePromoPopup = document.getElementById('close-promo-popup');
    const promoDaftarBtn = document.getElementById('promo-daftar-btn');
    let promoShown = false;

    // Detect scroll to bottom
    window.addEventListener('scroll', function() {
        if (promoShown) return;

        const scrollHeight = document.documentElement.scrollHeight;
        const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        const clientHeight = document.documentElement.clientHeight;

        // Check if user scrolled to bottom (with 100px threshold)
        if (scrollTop + clientHeight >= scrollHeight - 100) {
            showPromoPopup();
            promoShown = true;
        }
    });

    // Show promo popup
    function showPromoPopup() {
        promoPopup.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Close promo popup
    function closePromoPopupFunc() {
        promoPopup.classList.add('hidden');
        document.body.style.overflow = '';
    }

    closePromoPopup.addEventListener('click', closePromoPopupFunc);

    // Click outside to close
    promoPopup.addEventListener('click', function(e) {
        if (e.target === promoPopup) {
            closePromoPopupFunc();
        }
    });

    // Promo Daftar button triggers scroll to pricing and close popup
    promoDaftarBtn.addEventListener('click', function() {
        closePromoPopupFunc();
        scrollToSection('pricing');
        // Wait for scroll then focus on form
        setTimeout(() => {
            const nameInput = document.querySelector('input[name="name"]');
            if (nameInput) {
                nameInput.focus();
                nameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 800);
    });

    let currentUserData = null;
    let currentPaymentMethods = null;
    let selectedPaymentMethod = null;

    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) value = '+' + value;
            else if (value.startsWith('0')) value = value;
            else if (value.length > 0) value = '0' + value;
            e.target.value = value;
        });
    }

    customerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(customerForm);
        const customerData = {
            name: formData.get('name').trim(),
            email: formData.get('email').trim(),
            phone: formData.get('phone').trim()
        };

        if (customerData.name.length < 2) {
            showError('Nama harus minimal 2 karakter');
            return;
        }
        if (!isValidEmail(customerData.email)) {
            showError('Format email tidak valid');
            return;
        }

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
        document.getElementById('modal-amount').textContent = data.formatted_amount;
        paymentModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
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

        paymentMethodsList.innerHTML = '';
        paymentMethods.forEach(method => {
            const methodElement = createPaymentMethodElement(method);
            paymentMethodsList.appendChild(methodElement);
        });

        setTimeout(() => {
            paymentMethodsLoading.classList.add('hidden');
            paymentMethodsContainer.classList.remove('hidden');
        }, 500);
    }

    function createPaymentMethodElement(method) {
        const div = document.createElement('div');
        div.className = 'payment-method-option border-2 border-slate-200 p-4 cursor-pointer hover:border-orange-500 hover:bg-orange-50 transition-all duration-200 rounded-xl';
        div.dataset.paymentMethod = method.paymentMethod;

        div.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden rounded-lg">
                        <img src="${method.paymentImage}" alt="${method.paymentName}" class="max-w-full max-h-full object-contain"
                             onerror="this.style.display='none'; this.parentElement.innerHTML='<span class=\\"text-xs text-slate-500\\">${method.paymentMethod}</span>'">
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">${method.paymentName}</h4>
                        <p class="text-xs text-slate-500">${method.paymentMethod}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    ${method.totalFee === '0' || method.totalFee === 0 ?
                        '<span class="text-green-600 text-sm font-bold">Gratis</span>' :
                        `<span class="text-slate-600 text-xs">+Rp ${parseInt(method.totalFee).toLocaleString('id-ID')}</span>`
                    }
                    <div class="w-6 h-6 border-2 border-slate-300 rounded-full payment-radio transition-all"></div>
                </div>
            </div>
        `;

        div.addEventListener('click', function() {
            selectPaymentMethod(method, div);
        });

        return div;
    }

    function selectPaymentMethod(method, element) {
        document.querySelectorAll('.payment-method-option').forEach(el => {
            el.classList.remove('border-orange-500', 'bg-orange-50');
            const radio = el.querySelector('.payment-radio');
            radio.classList.remove('border-orange-500', 'bg-orange-500');
            radio.innerHTML = '';
        });

        element.classList.add('border-orange-500', 'bg-orange-50');
        const radio = element.querySelector('.payment-radio');
        radio.classList.add('border-orange-500', 'bg-orange-500');
        radio.innerHTML = '<div class="w-3 h-3 bg-white rounded-full mx-auto"></div>';

        selectedPaymentMethod = method;
        proceedPaymentBtn.disabled = false;
        document.getElementById('proceed-text').textContent = `Bayar ${method.paymentName}`;
    }

    function showPaymentMethodsError() {
        paymentMethodsLoading.classList.add('hidden');
        paymentMethodsContainer.classList.add('hidden');
        paymentMethodsError.classList.remove('hidden');
    }

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
                localStorage.setItem('payment_form_data', JSON.stringify({
                    name: currentUserData.name,
                    email: currentUserData.email,
                    invoice_id: data.data.invoice_id,
                    timestamp: Date.now()
                }));
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

    closeModal.addEventListener('click', hidePaymentMethodModal);
    retryBtn.addEventListener('click', function() {
        if (currentUserData) fetchPaymentMethods(currentUserData);
    });

    paymentModal.addEventListener('click', function(e) {
        if (e.target === paymentModal) hidePaymentMethodModal();
    });

    function hidePaymentMethodModal() {
        paymentModal.classList.add('hidden');
        document.body.style.overflow = '';
        selectedPaymentMethod = null;
        proceedPaymentBtn.disabled = true;
        document.getElementById('proceed-text').textContent = 'Pilih Metode Pembayaran';
    }

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
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showError(message) {
        const existingNotifications = document.querySelectorAll('.notification-error');
        existingNotifications.forEach(notif => notif.remove());

        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-red-500 text-white p-4 rounded-xl shadow-2xl z-50 max-w-sm notification-error';
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="text-sm">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 5000);
    }
});
</script>
@endsection
