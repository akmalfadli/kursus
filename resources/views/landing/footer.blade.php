<footer class="py-8 px-4 bg-slate-900 text-white pb-32 lg:pb-8">
    <div class="max-w-4xl mx-auto">

        <div class="grid md:grid-cols-4 lg:grid-cols-4 gap-8 mb-6 md:text-left">

            <div>
                <h3 class="text-xl font-bold mb-3">{{ $content['course_name'] }}</h3>
                <p class="text-slate-400 text-sm">Persiapan terbaik untuk ujian perangkat desa</p>
            </div>

            <div class="ml-0 md:ml-0">
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

            <div>
                <h4 class="font-bold mb-3">Ikuti Kami</h4>
                <div class="flex md:justify-start gap-4 mt-4">

                    <a href="{{ $content['social_instagram'] }}" target="_blank" rel="noopener"
                       class="text-slate-400 hover:text-pink-500 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7.05 2h9.9c2.78 0 5.05 2.27 5.05 5.05v9.9c0 2.78-2.27 5.05-5.05 5.05h-9.9c-2.78 0-5.05-2.27-5.05-5.05v-9.9c0-2.78 2.27-5.05 5.05-5.05zm4.95 5.92a4.91 4.91 0 100 9.82 4.91 4.91 0 000-9.82zm-4.13 0a.82.82 0 111.64 0 .82.82 0 01-1.64 0z"/>
                        </svg>
                    </a>

                    <a href="{{ $content['social_facebook'] }}" target="_blank" rel="noopener"
                       class="text-slate-400 hover:text-blue-600 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 13.5h2v2h-2v4h-3v-4h-2v-2h2v-1.25c0-2.27 1.34-3.5 3.53-3.5h2.47v2.63h-1.85c-.93 0-1.15.42-1.15 1.14v.98z"/>
                            <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15.5h-2v-3h2V10c0-2.07 1.26-3.8 3.09-4.57 1.09-.45 2.3-.68 3.51-.68H20V6.5h-1.5c-1.2 0-2.42.23-3.51.68C13.26 7.8 12 9.53 12 11.5v2h-2v3h2v6.3c4.56-.93 8-4.96 8-9.8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-800 text-center text-slate-400 text-sm">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</footer>
