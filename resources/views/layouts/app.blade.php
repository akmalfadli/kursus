<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $defaultTitle = 'Kursus Ujian Perangkat Desa';
        $defaultDescription = 'Persiapkan diri Anda untuk sukses dalam ujian perangkat desa dengan materi terlengkap dan terpercaya';

        $pageTitle = trim($__env->yieldContent('title', $defaultTitle));
        $pageDescription = trim($__env->yieldContent('description', $defaultDescription));
        $pageCanonical = trim($__env->yieldContent('canonical', url()->current()));

        $ogTitle = trim($__env->yieldContent('og_title', $pageTitle));
        $ogDescription = trim($__env->yieldContent('og_description', $pageDescription));
        $ogImage = trim($__env->yieldContent('og_image', asset('images/graduation.png')));
        $ogUrl = trim($__env->yieldContent('og_url', url()->current()));
        $ogType = trim($__env->yieldContent('og_type', 'website'));

        $twitterTitle = trim($__env->yieldContent('twitter_title', $pageTitle));
        $twitterDescription = trim($__env->yieldContent('twitter_description', $pageDescription));
        $twitterImage = trim($__env->yieldContent('twitter_image', $ogImage));
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="ujian perangkat desa, kursus perangkat desa, latihan soal perangkat desa, bimbingan perangkat desa, digidesa, belajar perangkat desa, simulasi ujian perangkat desa, tryout perangkat desa, seleksi perangkat desa">
    <meta name="author" content="Digidesa">
    <meta name="robots" content="index, follow">

    <link rel="canonical" href="{{ $pageCanonical }}">

    <!-- Open Graph -->
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:type" content="{{ $ogType }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $twitterTitle }}">
    <meta name="twitter:description" content="{{ $twitterDescription }}">
    <meta name="twitter:image" content="{{ $twitterImage }}">


    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles -->
    @stack('styles')
    @stack('head')
</head>
<body class="bg-gray-50">
    @yield('content')

    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html>
