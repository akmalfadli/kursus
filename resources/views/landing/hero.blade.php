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
                        <div class="text-3xl font-bold text-orange-600">500+</div>
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
                        class="flex-1 sm:flex-none bg-gradient-to-r from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-center">
                        🎯 Daftar Sekarang
                    </button>
                    <button onclick="scrollToSection('benefits')"
                        class="flex-1 sm:flex-none border-2 border-orange-600 text-orange-600 hover:bg-orange-50 px-8 py-4 rounded-xl font-semibold transition-all duration-300 text-center">
                        Lihat Benefit
                    </button>
                    <a href="{{ route('blog.index') }}"
                    class="flex-1 sm:flex-none border-2 border-orange-500 text-orange-600 hover:bg-orange-10 px-8 py-4 rounded-xl font-semibold transition-all duration-300 text-center">
                        Blog
                    </a>

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
                                <div class="text-sm text-slate-600">Belajar dengan mentor berpengalaman dan terstruktur meningkatkan peluang kelulusan dan percaya diri saat menjalani ujian</div>
                                <div class="text-2xl font-bold text-orange-600">95%</div>
                            </div>
                            <div class="w-10 h-10 bg-gradient-to-r from-orange-400 to-red-400 rounded-full flex items-center justify-center">
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
