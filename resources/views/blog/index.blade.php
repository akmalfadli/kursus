@extends('layouts.app')

@section('title', 'Artikel & Berita - ' . config('app.name'))
@section('description', 'Dapatkan informasi terbaru, tips, dan panduan lengkap seputar ujian perangkat desa.')

@section('content')
<div class="min-h-screen bg-slate-50/50">

    <!-- Header/Nav - Improved Mobile -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('landing') }}" class="flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50 text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition-colors flex-shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg sm:text-xl font-bold text-slate-900 leading-none truncate">Blog & Artikel</h1>
                    <p class="text-xs text-slate-500 mt-0.5 sm:mt-1 truncate">Update terbaru seputar materi dan ujian</p>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto p-10 px-4 sm:px-6 py-6 sm:py-8 grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 mb-12">

        <!-- LEFT COLUMN: Categories & Search (Desktop Only) -->
        <aside class="hidden lg:block lg:col-span-2 xl:col-span-3 space-y-8 h-full">
            <div class="sticky top-24 space-y-8">
                <!-- Categories Widget (Clean List) -->
                <div>
                    <h3 class="font-bold text-slate-900 mb-4 text-sm uppercase tracking-wider">Topik Bahasan</h3>
                    <nav class="space-y-1">
                        <a href="{{ route('blog.index') }}"
                           class="group flex items-center justify-between py-2 text-sm transition-colors {{ !request('category') ? 'text-orange-600 font-semibold' : 'text-slate-600 hover:text-slate-900' }}">
                            <span class="group-hover:translate-x-1 transition-transform">Semua Artikel</span>
                            @if(!request('category'))
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                            @endif
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('blog.index', array_merge(request()->all(), ['category' => $cat->slug])) }}"
                           class="group flex items-center justify-between py-2 text-sm transition-colors {{ request('category') == $cat->slug ? 'text-orange-600 font-semibold' : 'text-slate-600 hover:text-slate-900' }}">
                            <span class="group-hover:translate-x-1 transition-transform">{{ $cat->name }}</span>
                            <span class="text-xs text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full group-hover:bg-slate-100 transition-colors">
                                {{ $cat->posts_count }}
                            </span>
                        </a>
                        @endforeach
                    </nav>
                </div>
                <!-- Platform Preview Widget (Mobile App Style) -->
                <div class="justify-start">
                    <h3 class="font-bold text-slate-900 mb-4 text-sm uppercase tracking-wider">Platform Belajar</h3>
                    <p class="text-sm mb-4">Dapatkan platform belajar dengan latihan Try Out ratusan soal disertai pembahasan, materi dan sistem papan peringkat</p>
                    <div class="rounded-2xl overflow-hidden shadow-xl border border-slate-100 bg-slate-900 relative group">
                        <!-- Slider Container -->
                        <div class="w-full aspect-[9/16] overflow-hidden relative">

                            <div id="screenshot-track" class="flex h-full transition-transform duration-1000 ease-in-out">
                                @foreach($screenshots as $index => $screenshot)
                                <div class="w-full h-full relative bg-slate-800 shrink-0">
                                    <img src="{{ $screenshot['url'] }}"
                                        alt="{{ $screenshot['title'] }}"
                                        class="w-full h-full object-cover opacity-90">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MIDDLE COLUMN: Article List -->
        <main class="lg:col-span-7 xl:col-span-6 space-y-6 mb-10">

            <!-- Mobile Search & Filter -->
            <div class="lg:hidden space-y-4">
                <!-- Horizontal Scroll Categories -->
                <div class="relative -mx-4 sm:-mx-6">
                    <div class="flex gap-2 overflow-x-auto px-4 sm:px-6 pb-2 scrollbar-hide snap-x snap-mandatory">
                        <a href="{{ route('blog.index') }}"
                           class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium border transition-all snap-start flex-shrink-0 {{ !request('category') ? 'bg-orange-50 border-orange-200 text-orange-700 shadow-sm' : 'bg-white border-slate-200 text-slate-600 hover:border-slate-300' }}">
                            Semua
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                           class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium border transition-all snap-start flex-shrink-0 {{ request('category') == $cat->slug ? 'bg-orange-50 border-orange-200 text-orange-700 shadow-sm' : 'bg-white border-slate-200 text-slate-600 hover:border-slate-300' }}">
                            {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>
                    <!-- Fade effect on right edge -->
                    <div class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-slate-50/50 to-transparent pointer-events-none"></div>
                </div>
            </div>

            <!-- Article List - Improved Cards -->
            <div class="space-y-4 sm:space-y-5">
                @forelse($posts as $post)
                <article class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-5 shadow-sm border border-slate-100 hover:shadow-md hover:border-orange-100 transition-all group">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
                        <div class="flex gap-4 sm:gap-5 items-start">
                            <!-- Image - Small Left Side -->
                            <div class="shrink-0 w-24 h-24 sm:w-32 sm:h-32 rounded-lg sm:rounded-xl overflow-hidden bg-slate-100 relative">
                                @if($post->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}"
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-300">
                                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0 flex flex-col">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs sm:text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">
                                        {{ $post->category->name }}
                                    </span>
                                    <span class="text-xs sm:text-xs text-slate-400">
                                        {{ $post->created_at->format('d M Y') }}
                                    </span>
                                </div>

                                <h2 class="text-base sm:text-lg font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors leading-snug">
                                    {{ $post->title }}
                                </h2>

                                <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 mb-auto leading-relaxed hidden sm:block">
                                    {{ Str::limit(strip_tags($post->content), 250) }}
                                </p>

                                <!-- Mobile only excerpt (shorter) -->
                                <p class="text-xs text-slate-500 line-clamp-2 mb-auto leading-relaxed sm:hidden">
                                    {{ Str::limit(strip_tags($post->content), 200) }}
                                </p>

                                <div class="mt-auto mt-4 flex items-center gap-1.5">
                                    <span class="text-xs text-slate-500 font-small">
                                        Dibuat oleh {{ $post->user->name ?? 'Admin' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
                @empty
                <div class="text-center py-12 sm:py-16 bg-white rounded-xl sm:rounded-2xl border border-slate-100 border-dashed">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900">Belum ada artikel</h3>
                    <p class="text-slate-500 text-sm mt-1">Coba cari dengan kata kunci lain.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="pt-2 sm:pt-4">
                {{ $posts->appends(request()->query())->links() }}
            </div>
            @endif

            <!-- Upsell Banner (Center) -->
            <div class="mt-8 rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 p-8 text-white relative overflow-hidden shadow-xl">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-2xl font-bold mb-2">Siap Hadapi Ujian Tahun Ini?</h3>
                        <p class="text-orange-100 mb-6 text-sm leading-relaxed max-w-lg">
                            Jangan biarkan kesempatan lulus hilang begitu saja. Dapatkan akses penuh ke bank soal premium, materi video, dan sesi mentoring eksklusif.
                        </p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm font-medium text-orange-100 mb-6">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                500+ Soal Latihan
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Video Materi
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Mentoring
                            </div>
                        </div>
                        <a href="{{ route('landing') }}#pricing" class="inline-flex items-center justify-center px-8 py-3 bg-white text-orange-600 rounded-xl font-bold hover:bg-orange-50 transition-all shadow-lg">
                            Daftar Sekarang
                        </a>
                    </div>
                    <div class="shrink-0 hidden md:block">
                        <div class="w-32 h-32 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white/30">
                            <span class="text-3xl font-bold">95%</span>
                        </div>
                        <div class="text-center text-xs font-medium text-orange-100 mt-2">Tingkat Kelulusan</div>
                    </div>
                </div>
            </div>
        </main>

        <!-- RIGHT COLUMN: Promotion (Desktop & Tablet) -->
        <aside class="lg:col-span-3 xl:col-span-3 space-y-8 h-full">
            <div class="sticky top-24 space-y-8">

                <!-- Search Widget (Right Sidebar) -->
                <div class="relative">
                    <form action="{{ route('blog.index') }}" method="GET">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari artikel..."
                            class="w-full pl-12 pr-4 p-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all text-sm font-medium placeholder:text-slate-400 shadow-sm">
                    </form>
                </div>

                <!-- Premium Course Card (Glassmorphism) -->
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 p-6 text-white shadow-xl">
                    <!-- Abstract Shapes -->
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-orange-500/20 blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-blue-500/20 blur-xl"></div>

                    <div class="relative z-10">
                        <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium backdrop-blur-sm border border-white/10">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                            </span>
                            Pendaftaran Dibuka
                        </div>

                        <h3 class="mb-2 text-xl font-bold leading-tight">
                            Ingin Lulus Ujian <span class="text-orange-400">Perangkat Desa?</span>
                        </h3>

                        <p class="mb-6 text-sm text-slate-300 leading-relaxed">
                            Bergabunglah dengan 500+ alumni yang berhasil lolos seleksi tahun ini.
                        </p>

                        <a href="{{ route('landing') }}#pricing"
                           class="group flex items-center justify-center gap-2 w-full rounded-xl bg-white py-3 text-sm font-bold text-slate-900 hover:bg-orange-50 transition-all shadow-lg hover:shadow-orange-500/20">
                            Lihat Materi Premium
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>

                        <div class="mt-4 flex items-center justify-center gap-3 border-t border-white/10 pt-4">
                            <div class="flex -space-x-2">
                                <div class="h-6 w-6 rounded-full border border-slate-800 bg-slate-700"></div>
                                <div class="h-6 w-6 rounded-full border border-slate-800 bg-slate-600"></div>
                                <div class="h-6 w-6 rounded-full border border-slate-800 bg-slate-500"></div>
                            </div>
                            <span class="text-xs text-slate-400">4.9/5 Rating Siswa</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Contact (Clean) -->
                <div class="rounded-2xl border border-slate-100 bg-white p-6 text-center">
                    <div class="mb-4 mx-auto w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h4 class="font-bold text-slate-900">Butuh Konsultasi?</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-4">Tanyakan seputar materi ujian</p>
                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $content['contact_phone']) }}"
                       class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </aside>

    </div>

    @include('landing.footer')
</div>

<style>
/* Hide scrollbar for horizontal scroll categories */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Smooth scroll for category pills */
.snap-x {
    scroll-behavior: smooth;
}
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('screenshot-track');
        if (!track) return;

        const slides = track.children;
        if (slides.length === 0) return;

        let currentIndex = 0;

        setInterval(() => {
            currentIndex = (currentIndex + 1) % slides.length;
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
        }, 3000);
    });
</script>
@endpush
