{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('title', $content['hero_title'] . ' | ' . config('app.name'))
@section('description', $content['hero_subtitle'])
@section('canonical', route('landing'))
@section('og_title', $content['hero_title'] . ' | ' . config('app.name'))
@section('og_description', $content['hero_subtitle'])
@section('twitter_title', $content['hero_title'] . ' | ' . config('app.name'))
@section('twitter_description', $content['hero_subtitle'])
@section('og_image', asset('images/graduation.png'))

@push('head')
    @php
        $organizationSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => route('landing'),
            'logo' => asset('images/graduation.png'),
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => $content['contact_phone'] ?? '+62 857-7439-7927',
                    'contactType' => 'customer support',
                    'areaServed' => 'ID',
                    'availableLanguage' => ['Indonesian']
                ]
            ]
        ];

        $courseSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Course',
            'name' => $content['hero_title'],
            'description' => $content['hero_subtitle'],
            'provider' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'sameAs' => route('landing')
            ]
        ];

        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('app.name'),
            'url' => route('landing'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('blog.index') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string'
            ]
        ];
    @endphp

    <script type="application/ld+json">
        {!! json_encode($organizationSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode($courseSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode($websiteSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50">
    @include('landing.alert-bar')

    @include('landing.hero')

    @include('landing.benefits')

    @include('landing.promo-video')

    <!-- Testimonials Section is commented out in original code -->
    {{--   @include('landing.testimonials')  --}}

    @include('landing.pricing')

    @include('landing.payment-modal')

    @include('landing.promo-popup')

    @include('landing.blog')

    @include('landing.floating-elements')

    @include('landing.footer')
</div>

@include('landing.scripts')
@include('landing.analytics')
@endsection
