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
