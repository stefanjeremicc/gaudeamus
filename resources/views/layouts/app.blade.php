<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Gaudeamus - Studentska Zadruga')</title>
    <meta name="description" content="@yield('meta_description', 'Gaudeamus studentska zadruga - Pronađite idealan studentski posao u Srbiji.')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Gaudeamus - Studentska Zadruga')">
    <meta property="og:description" content="@yield('meta_description', 'Gaudeamus studentska zadruga - Pronađite idealan studentski posao u Srbiji.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="{{ app()->getLocale() }}">

    <!-- Hreflang -->
    @foreach(['sr', 'en', 'ru'] as $lang)
        <link rel="alternate" hreflang="{{ $lang }}" href="{{ url('/' . $lang . '/' . request()->segment(2, '')) }}">
    @endforeach

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-slate-50">
    @include('layouts.partials.navbar')

    <main class="flex-1">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg">
                {{ session('success') }}
                <button @click="show = false" class="ml-3 text-white/80 hover:text-white">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg">
                {{ session('error') }}
                <button @click="show = false" class="ml-3 text-white/80 hover:text-white">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @stack('scripts')
</body>
</html>
