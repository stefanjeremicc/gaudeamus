@extends('layouts.app')

@section('title', 'Gaudeamus - ' . __('messages.hero_title'))
@section('meta_description', __('messages.hero_subtitle'))

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-72 h-72 bg-accent-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-primary-400 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                    {{ __('messages.hero_title') }}
                </h1>
                <p class="text-lg md:text-xl text-primary-200 mb-10">
                    {{ __('messages.hero_subtitle') }}
                </p>

                <!-- Search Bar -->
                <form action="{{ route('jobs.index', $locale) }}" method="GET" class="flex flex-col sm:flex-row gap-3 max-w-2xl mx-auto">
                    <div class="flex-1 relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" placeholder="{{ __('messages.hero_search_placeholder') }}"
                               class="w-full pl-12 pr-4 py-4 rounded-xl text-slate-800 bg-white focus:outline-none focus:ring-2 focus:ring-accent-400 shadow-lg">
                    </div>
                    <select name="region" class="px-4 py-4 rounded-xl text-slate-800 bg-white focus:outline-none focus:ring-2 focus:ring-accent-400 shadow-lg">
                        <option value="">{{ __('messages.hero_city_placeholder') }}</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->getTranslation('name', $locale) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-cta !py-4 !px-8 shadow-lg text-lg">
                        {{ __('messages.hero_search_button') }}
                    </button>
                </form>

                <!-- Stats -->
                <div class="flex flex-wrap justify-center gap-8 mt-12">
                    <div class="text-center">
                        <div class="font-mono text-3xl md:text-4xl font-bold text-accent-400">{{ $stats['active_jobs'] ?: '0' }}</div>
                        <div class="text-sm text-primary-200 mt-1">{{ __('messages.hero_active_jobs') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="font-mono text-3xl md:text-4xl font-bold text-accent-400">{{ $stats['cities'] ?: '0' }}</div>
                        <div class="text-sm text-primary-200 mt-1">{{ __('messages.hero_cities') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="font-mono text-3xl md:text-4xl font-bold text-accent-400">{{ $stats['students'] ?: '0' }}</div>
                        <div class="text-sm text-primary-200 mt-1">{{ __('messages.hero_students') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    @if($categories->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('jobs.index', [$locale, 'category' => $category->id]) }}"
                   class="bg-white rounded-2xl p-4 text-center shadow-sm hover:shadow-md hover:border-primary-200 border border-transparent transition group">
                    @if($category->icon)
                        <div class="text-3xl mb-2">{{ $category->icon }}</div>
                    @else
                        <div class="w-10 h-10 mx-auto mb-2 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="font-medium text-sm text-slate-700 group-hover:text-primary-600 transition">
                        {{ $category->getTranslation('name', $locale) }}
                    </div>
                    <div class="text-xs text-slate-400 mt-1">{{ $category->job_listings_count }} {{ __('messages.nav_jobs') }}</div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Popular Jobs -->
    @if($featuredJobs->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="section-title">&#128293; {{ __('messages.jobs_popular') }}</h2>
                <p class="section-subtitle">{{ __('messages.hero_subtitle') }}</p>
            </div>
            <a href="{{ route('jobs.index', [$locale, 'sort' => 'popular']) }}" class="btn-outline text-sm !py-2">
                {{ __('messages.view_all') }} &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredJobs as $job)
                @include('components.job-card', ['job' => $job, 'locale' => $locale])
            @endforeach
        </div>
    </section>
    @endif

    <!-- New Jobs -->
    @if($newJobs->count())
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="section-title">&#127381; {{ __('messages.jobs_new') }}</h2>
                </div>
                <a href="{{ route('jobs.index', $locale) }}" class="btn-outline text-sm !py-2">
                    {{ __('messages.view_all') }} &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($newJobs as $job)
                    @include('components.job-card', ['job' => $job, 'locale' => $locale])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Why Gaudeamus -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="section-title text-center mb-12">{{ __('messages.why_title') }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                <div class="w-16 h-16 mx-auto mb-6 bg-primary-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ __('messages.why_secure_title') }}</h3>
                <p class="text-slate-500 leading-relaxed">{{ __('messages.why_secure_desc') }}</p>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                <div class="w-16 h-16 mx-auto mb-6 bg-accent-400/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ __('messages.why_payment_title') }}</h3>
                <p class="text-slate-500 leading-relaxed">{{ __('messages.why_payment_desc') }}</p>
            </div>

            <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-slate-100 hover:shadow-md transition">
                <div class="w-16 h-16 mx-auto mb-6 bg-cta-500/15 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-cta-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">{{ __('messages.why_free_title') }}</h3>
                <p class="text-slate-500 leading-relaxed">{{ __('messages.why_free_desc') }}</p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function toggleBookmark(jobId) {
        fetch(`/{{ $locale }}/poslovi/${jobId}/bookmark`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            // Refresh page or update UI
            window.location.reload();
        });
    }
</script>
@endpush
