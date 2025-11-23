<footer class="py-8 px-4 bg-slate-900 text-white pb-32 lg:pb-8">
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
