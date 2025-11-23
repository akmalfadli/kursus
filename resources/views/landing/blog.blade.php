<section id="blog" class="py-16 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-800 mb-3">
                Artikel Terbaru
            </h2>
            <p class="text-slate-600">Informasi dan tips seputar ujian perangkat desa</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($latestPosts as $post)
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group">
                <!-- Image -->
                <div class="relative h-48 overflow-hidden">
                    @if($post->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                            {{ $post->category->name }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="text-sm text-slate-500 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $post->created_at->format('d M Y') }}
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                        {{ Str::limit(strip_tags($post->content), 100) }}
                    </p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center text-orange-600 font-bold hover:text-orange-700 transition-colors">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-slate-500">Belum ada artikel yang diterbitkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
