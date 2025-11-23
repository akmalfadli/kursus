<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Kursus Ujian Perangkat Desa')</title>
    <meta name="description" content="@yield('description', 'Persiapkan diri Anda untuk sukses dalam ujian perangkat desa dengan materi terlengkap dan terpercaya')">
    <meta name="keywords" content="ujian perangkat desa, kursus perangkat desa, latihan soal perangkat desa, bimbingan perangkat desa, digidesa, belajar perangkat desa, simulasi ujian perangkat desa, tryout perangkat desa, seleksi perangkat desa">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Kursus Ujian Perangkat Desa')">
    <meta property="og:description" content="@yield('description', 'Persiapkan diri Anda untuk sukses dalam ujian perangkat desa dengan materi terlengkap dan terpercaya')">
    <meta property="og:image" content="@yield('og_image', asset('images/graduation.png.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">


    <meta name="author" content="Digidesa">
    <meta name="robots" content="index, follow">

    <link rel="canonical" href="https://digidesa.id/">

    <!-- Open Graph (Facebook / WhatsApp) -->
    <meta property="og:title" content="Kursus Ujian Perangkat Desa - Digidesa">
    <meta property="og:description" content="Persiapan ujian perangkat desa paling lengkap! Materi, soal latihan, dan mentoring langsung. Garansi lulus hingga 95%.">
    <meta property="og:url" content="https://digidesa.id/">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://digidesa.id/images/graduation.png">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Kursus Ujian Perangkat Desa - Digidesa">
    <meta name="twitter:description" content="Latihan soal, materi, dan mentoring ujian perangkat desa. Tingkatkan peluang lulus hingga 95%!">
    <meta name="twitter:image" content="https://digidesa.id/images/graduation.png">


    <!-- Tailwind CSS CDN (Quick Setup) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#f59e0b',
                    }
                }
            }
        }
    </script>

    <!-- Additional styles -->
    @stack('styles')
</head>
<body class="bg-gray-50">
    @yield('content')

    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html>
