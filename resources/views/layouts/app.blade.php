<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Kursus Ujian Perangkat Desa')</title>
    <meta name="description" content="@yield('description', 'Persiapkan diri Anda untuk sukses dalam ujian perangkat desa dengan materi terlengkap dan terpercaya')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Kursus Ujian Perangkat Desa')">
    <meta property="og:description" content="@yield('description', 'Persiapkan diri Anda untuk sukses dalam ujian perangkat desa dengan materi terlengkap dan terpercaya')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles -->
    @stack('styles')
</head>
<body class="bg-gray-50">
    @yield('content')

    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html>
