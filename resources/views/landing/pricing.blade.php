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
                🔥 PAKET TERLARIS - HEMAT 50%
            </div>

            <div class="p-8 lg:p-12">
                <!-- Price -->
                <div class="text-center mb-8">
                    <div class="text-slate-500 text-lg line-through mb-2">Rp 500.000</div>
                    <div class="space-y-2">
                        <div class="text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-red-600">
                            <span id="pricing-current-amount" data-base-price="{{ (int) $content['price'] }}">
                                Rp {{ number_format($content['price'], 0, ',', '.') }}
                            </span>
                        </div>
                        <p id="pricing-referral-note" class="hidden text-base font-semibold text-orange-600">
                            Hemat <span id="pricing-discount-amount"></span> dengan kode <span id="pricing-referral-code"></span>
                        </p>
                    </div>
                    <div class="text-slate-600 font-medium">Pembayaran Sekali - Akses 1 Tahun</div>
                </div>

                <!-- Features -->
                <div class="grid md:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-slate-700"><strong>500+</strong> Soal Latihan Premium</span>
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
                <form id="customer-form" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="text" name="name" placeholder="Nama Lengkap *" required
                            class="w-full px-4 py-4 border-2 border-slate-200 focus:border-orange-500 focus:outline-none rounded-xl text-base transition-colors"
                            maxlength="255">
                        <input type="email" name="email" placeholder="Email Aktif *" required
                            class="w-full px-4 py-4 border-2 border-slate-200 focus:border-orange-500 focus:outline-none rounded-xl text-base transition-colors"
                            maxlength="255">
                    </div>
                    <input type="tel" name="phone" placeholder="Nomor WhatsApp"
                        class="w-full px-4 py-4 border-2 border-slate-200 focus:border-orange-500 focus:outline-none rounded-xl text-base transition-colors"
                        pattern="^(\+62|62|0)[0-9]{8,13}$">

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="referral-code-input" class="text-sm font-semibold text-slate-700">Kode Referral (Opsional)</label>
                            <span id="referral-status-chip" class="hidden text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700"></span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input type="text" name="referral_code" id="referral-code-input" placeholder="Contoh: KANDAR2026"
                                class="flex-1 px-4 py-4 border-2 border-slate-200 focus:border-orange-500 focus:outline-none rounded-xl text-base transition-colors uppercase"
                                maxlength="50" autocomplete="off">
                            <button type="button" id="check-referral-btn"
                                class="sm:w-40 w-full bg-slate-900 text-white font-semibold rounded-xl px-4 py-3 shadow hover:shadow-lg transition-all">
                                Cek Kode
                            </button>
                        </div>
                        <p id="referral-feedback" class="text-sm text-slate-500"></p>
                    </div>

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
