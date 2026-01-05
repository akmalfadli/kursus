<div id="payment-method-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white max-w-2xl w-full max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl">
        <div class="sticky top-0 p-6 border-b bg-gradient-to-r from-orange-300 to-orange-500 text-white rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">Pilih Metode Pembayaran</h3>
                    <p class="text-sm opacity-90 mt-1">Total: <span id="modal-amount" class="font-bold"></span></p>
                    <p id="modal-referral-note" class="text-xs mt-1 hidden">
                        Termasuk diskon <span id="modal-discount-amount" class="font-semibold"></span> (<span id="modal-referral-code" class="font-semibold"></span>)
                    </p>
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
