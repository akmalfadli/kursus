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
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-xl text-slate-400 line-through">Rp 500.000</span>
                        <span class="text-2xl font-bold text-orange-600" id="promo-current-amount">
                            Rp {{ number_format($content['price'], 0, ',', '.') }}
                        </span>
                        <span id="promo-referral-note" class="hidden text-sm font-semibold text-white">
                            Hemat <span id="promo-discount-amount"></span> dengan kode <span id="promo-referral-code"></span>
                        </span>
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
