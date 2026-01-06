{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('title', $content['hero_title'])
@section('description', $content['hero_subtitle'])

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
