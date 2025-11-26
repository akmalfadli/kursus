@extends('layouts.app')

@section('title', $post->title)
@section('description', Str::limit(strip_tags($post->content), 150))
@section('og_image', $post->image ? \Illuminate\Support\Facades\Storage::url($post->image) : asset('images/graduation.png'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">

    <!-- Header/Nav -->
    <nav class="bg-white/90 backdrop-blur-sm shadow-sm sticky top-0 z-40 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 py-3 md:py-4 flex items-center justify-between">
            <a href="{{ route('blog.index') }}" class="flex items-center gap-2 text-slate-600 hover:text-orange-600 font-bold transition-colors text-sm md:text-base">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali ke Beranda</span>
                <span class="sm:hidden">Kembali</span>
            </a>
            <span class="text-xs md:text-sm font-bold text-orange-600 bg-orange-50 px-2 md:px-3 py-1 rounded-full">
                {{ $post->category->name }}
            </span>
        </div>
    </nav>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-4 py-6 md:py-12 grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-12">

        <!-- Left Sidebar - Mobile Horizontal, Desktop Vertical -->
        <aside class="lg:col-span-2 order-3 lg:order-1 h-full">
            <div class="sticky top-32 z-30 text-center h-fit bg-gradient-to-br from-slate-50 via-white to-blue-50 lg:bg-transparent py-3 lg:py-0 rounded-lg lg:rounded-none shadow-sm lg:shadow-none border-b lg:border-b-0 border-slate-200 lg:border-slate-200">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 lg:mb-4">Bagikan</p>
                <div class="flex flex-row lg:flex-col gap-3 justify-center lg:items-center">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank"
                       class="w-10 h-10 rounded-full bg-slate-100 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors flex-shrink-0"
                       title="Bagikan ke Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}"
                       target="_blank"
                       class="w-10 h-10 rounded-full bg-slate-100 hover:bg-green-500 hover:text-white flex items-center justify-center transition-colors flex-shrink-0"
                       title="Bagikan ke WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Article -->
        <article class="col-span-1 lg:col-span-7 order-1 lg:order-2">
            <header class="mb-6 md:mb-8 text-center lg:text-left">
                <h1 class="text-2xl sm:text-xl md:text-2xl lg:text-4xl font-extrabold text-slate-900 mb-4 md:mb-6 leading-tight">
                    {{ $post->title }}
                </h1>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 sm:gap-6 text-slate-500 text-xs sm:text-sm border-b border-slate-100 pb-4 md:pb-8">
                    <span class="font-medium text-slate-700">{{ $post->user ? $post->user->name : 'Admin' }}</span>
                    <span>{{ $post->created_at->format('d F Y') }}</span>
                    <span>{{ number_format($post->views) }} views</span>
                </div>
            </header>

            @if($post->image)
            <div class="rounded-lg md:rounded-2xl overflow-hidden shadow-lg mb-6 md:mb-10">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
            </div>
            @endif

            <div class="prose prose-sm md:prose-lg prose-slate max-w-none bg-white p-0">
                {!! $post->content !!}
            </div>
        </article>

        <!-- Right Sidebar -->
        <aside class="col-span-1 lg:col-span-3 order-2 lg:order-3 space-y-4 md:space-y-6 lg:space-y-8 h-full">
            <div class="sticky top-32 lg:top-32 h-fit z-30 lg:space-y-6 space-y-4">
                <!-- Mini CTA -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-lg md:rounded-2xl p-4 md:p-6 shadow-xl">
                    <h3 class="font-bold text-lg md:text-xl mb-2">Lulus Ujian Tahun Ini?</h3>
                    <p class="text-slate-300 text-xs md:text-sm mb-4">Dapatkan materi eksklusif dan bimbingan intensif sekarang.</p>
                    <a href="{{ route('landing') }}#pricing" class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 md:py-3 rounded-lg md:rounded-xl transition-colors text-sm md:text-base">
                        Daftar Kelas
                    </a>
                </div>

                <div class="bg-white rounded-lg md:rounded-2xl p-4 md:p-6 shadow-lg border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-3 md:mb-4 border-b border-slate-100 pb-2 text-sm md:text-base">Artikel Lainnya</h3>
                    <div class="space-y-3 md:space-y-4">
                        @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->slug) }}" class="flex gap-2 md:gap-3 group">
                            <div class="w-12 h-12 md:w-16 md:h-16 rounded-lg overflow-hidden flex-shrink-0 bg-slate-100">
                                @if($related->image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($related->image) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <h4 class="text-xs md:text-sm font-bold text-slate-700 line-clamp-2">{{ $related->title }}</h4>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

    </div>

    <!-- CTA Section -->
    <section class="max-w-4xl mx-auto px-4 pb-12 md:pb-20">
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-lg md:rounded-2xl mt-6 p-6 md:p-12 text-center text-white shadow-2xl relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold mb-3 md:mb-4">Ingin Lulus Ujian Perangkat Desa?</h3>
                <p class="text-orange-100 mb-6 md:mb-8 text-sm md:text-lg">Bergabunglah dengan kursus intensif kami dan dapatkan materi lengkap serta bimbingan langsung.</p>
                <a href="{{ route('landing') }}#pricing" class="inline-block bg-white text-orange-600 font-bold px-6 md:px-8 py-2 md:py-4 rounded-lg md:rounded-xl hover:bg-orange-50 transition-all shadow-lg transform hover:-translate-y-1 text-sm md:text-base">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </section>

    @include('landing.footer')
</div>
@endsection
