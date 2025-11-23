<!-- Testimonials - Compact Carousel Style -->
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
</section>
