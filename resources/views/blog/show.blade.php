@extends('layouts.app')

@section('title', $post->title)
@section('description', Str::limit(strip_tags($post->content), 150))
@section('og_image', $post->image ? \Illuminate\Support\Facades\Storage::url($post->image) : asset('images/graduation.png'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
    
    <!-- Header/Nav (Simple back button) -->
    <nav class="bg-white/90 backdrop-blur-sm shadow-sm sticky top-0 z-40 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 text-slate-600 hover:text-orange-600 font-bold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <span class="text-sm font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-full">
                {{ $post->category->name }}
            </span>
        </div>
    </nav>

    <!-- Article Content -->
    <div class="max-w-7xl mx-auto px-4 py-12 grid lg:grid-cols-12 gap-12">
        
        <!-- Sidebar Left (Optional: Share/TOC) -->
        <aside class="hidden lg:block lg:col-span-2 space-y-8 sticky top-32 h-fit">
            <div class="text-center">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Bagikan</p>
                <div class="flex flex-col gap-3 items-center">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                       target="_blank" 
                       class="w-10 h-10 rounded-full bg-slate-100 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors"
                       title="Bagikan ke Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    
                    <!-- Twitter / X -->
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" 
                       target="_blank"
                       class="w-10 h-10 rounded-full bg-slate-100 hover:bg-black hover:text-white flex items-center justify-center transition-colors"
                       title="Bagikan ke Twitter">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    
                    <!-- WhatsApp -->
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" 
                       target="_blank"
                       class="w-10 h-10 rounded-full bg-slate-100 hover:bg-green-500 hover:text-white flex items-center justify-center transition-colors"
                       title="Bagikan ke WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.52-.075-.149-.669-1.611-.916-2.206-.242-.579-.487-.506-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <article class="col-span-12 lg:col-span-7">
            <!-- Title & Meta -->
            <header class="mb-8 text-center lg:text-left">
                <div class="mb-4">
                    <span class="inline-block bg-orange-100 text-orange-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        {{ $post->category->name }}
                    </span>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight">
                    {{ $post->title }}
                </h1>
                <div class="flex items-center justify-center lg:justify-start gap-6 text-slate-500 text-sm border-b border-slate-100 pb-8">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-slate-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ $post->user ? urlencode($post->user->name) : 'Admin' }}&background=random" alt="Author" class="w-full h-full">
                        </div>
                        <span class="font-medium text-slate-700">{{ $post->user ? $post->user->name : 'Admin Digidesa' }}</span>
                    </div>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ number_format($post->views) }} views
                    </span>
                </div>
            </header>

            <!-- Featured Image -->
            @if($post->image)
            <div class="rounded-2xl overflow-hidden shadow-lg mb-10">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-auto object-cover">
            </div>
            @endif

            <!-- Content Body -->
            <div class="prose prose-lg prose-slate max-w-none bg-white p-0">
                {!! $post->content !!}
            </div>
        </article>

        <!-- Sidebar Right (CTA & Related) -->
        <aside class="hidden lg:block lg:col-span-3 space-y-8">
            <!-- Sticky Container -->
            <div class="sticky top-32 space-y-6">
                <!-- Mini CTA -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-6 shadow-xl">
                    <h3 class="font-bold text-xl mb-2">Lulus Ujian Tahun Ini?</h3>
                    <p class="text-slate-300 text-sm mb-4">Dapatkan materi eksklusif dan bimbingan intensif sekarang.</p>
                    <a href="{{ route('landing') }}#pricing" class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition-colors">
                        Daftar Kelas
                    </a>
                </div>

                <!-- Related/Latest Posts -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Artikel Lainnya</h3>
                    <div class="space-y-4">
                        @foreach(\App\Models\Post::where('id', '!=', $post->id)->where('is_published', true)->latest()->take(3)->get() as $related)
                        <a href="{{ route('blog.show', $related->slug) }}" class="flex gap-3 group">
                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-slate-100">
                                @if($related->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($related->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-700 group-hover:text-orange-600 line-clamp-2 transition-colors">{{ $related->title }}</h4>
                                <span class="text-xs text-slate-400">{{ $related->created_at->format('d M Y') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

    </div>

    <!-- CTA Section -->
    <section class="max-w-4xl mx-auto px-4 pb-20">
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl p-8 md:p-12 text-center text-white shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('/images/pattern.png')] opacity-10"></div>
            <div class="relative z-10">
                <h3 class="text-2xl md:text-3xl font-bold mb-4">Ingin Lulus Ujian Perangkat Desa?</h3>
                <p class="text-orange-100 mb-8 text-lg">Bergabunglah dengan kursus intensif kami dan dapatkan materi lengkap serta bimbingan langsung.</p>
                <a href="{{ route('landing') }}#pricing" class="inline-block bg-white text-orange-600 font-bold px-8 py-4 rounded-xl hover:bg-orange-50 transition-all shadow-lg transform hover:-translate-y-1">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </section>

    @include('landing.footer')
</div>

@include('landing.floating-elements')
@include('landing.analytics')
@endsection
