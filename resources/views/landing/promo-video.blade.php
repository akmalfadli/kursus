@if (!empty($content['promo_video_embed']))
    <section class="bg-gradient-to-br from-white to-orange-50 relative overflow-hidden">
        <!-- Decoration Background -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-orange-100 rounded-full blur-3xl opacity-60 -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-30 translate-y-1/2 -translate-x-1/2"></div>

        <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-8 lg:gap-16 items-center relative mt-8 mb-8 z-10">
            <!-- Text Content -->
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 mr-8 rounded-full bg-orange-100 border border-orange-200 text-orange-600 text-xs font-bold uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    Cuplikan Materi
                </div>

                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight">
                    Intip Suasana Belajar di <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-red-500">{{ $content['hero_title'] }} </span>99% pasti Lulus!
                </h2>

                <p class="text-slate-600 text-lg leading-relaxed mr-10">
                    Simak video singkat ini untuk melihat langsung kualitas materi, metode penyampaan, dan testimoni nyata dari para alumni yang telah sukses.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 ">
                    <div class="flex items-start gap-3 p-4 bg-white rounded-xl shadow-sm border border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Pembahasan Tuntas</h4>
                            <p class="text-sm text-slate-500">Bedah soal latihan secara mendalam dan terstruktur</p>
                       </div>
                    </div>
                </div>
            </div>

            <!-- Video Player -->
            <div class="relative group">
                <!-- Abstract blobs decoration behind video -->
                <div class="absolute -top-4 -right-4 w-34 h-40 bg-orange-200 rounded-full blur-xl opacity-60 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="absolute -bottom-4 -left-4 w-34 h-40 bg-blue-200 rounded-full blur-xl opacity-60 group-hover:scale-150 transition-transform duration-500"></div>

                <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white bg-slate-900 transform transition-transform duration-300 hover:scale-[1.02]">
                    <div class="w-full" style="aspect-ratio: 16 / 9;">
                        <iframe
                            class="w-full h-full"
                            src="{{ $content['promo_video_embed'] }}"
                            title="Promo Video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            referrerpolicy="strict-origin-when-cross-origin"
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
