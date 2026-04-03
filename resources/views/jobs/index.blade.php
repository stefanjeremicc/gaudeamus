@extends('layouts.app')

@section('title', __('messages.jobs_title') . ' - Gaudeamus')
@section('meta_description', __('messages.hero_subtitle'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">{{ __('messages.jobs_title') }}</h1>
            <p class="text-slate-500 mt-2">{{ $jobs->total() }} {{ __('messages.hero_active_jobs') }}</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-72 flex-shrink-0" x-data="{ filtersOpen: false }">
                <button @click="filtersOpen = !filtersOpen" class="lg:hidden w-full btn-outline mb-4 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    {{ __('messages.filter_title') }}
                </button>

                <form method="GET" action="{{ route('jobs.index', $locale) }}"
                      class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-6"
                      :class="{ 'hidden lg:block': !filtersOpen, 'block': filtersOpen }">

                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('messages.search') }}</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.hero_search_placeholder') }}"
                               class="input-field text-sm">
                    </div>

                    <!-- Region -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('messages.filter_region') }}</label>
                        <select name="region" class="input-field text-sm">
                            <option value="">{{ __('messages.filter_status_both') }}</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>
                                    {{ $region->getTranslation('name', $locale) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('messages.filter_category') }}</label>
                        <select name="category" class="input-field text-sm">
                            <option value="">{{ __('messages.filter_status_both') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->icon }} {{ $cat->getTranslation('name', $locale) }} ({{ $cat->job_listings_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Employment Status -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('messages.filter_status') }}</label>
                        <select name="status" class="input-field text-sm">
                            <option value="">{{ __('messages.filter_status_both') }}</option>
                            <option value="student" {{ request('status') === 'student' ? 'selected' : '' }}>{{ __('messages.filter_status_student') }}</option>
                            <option value="unemployed" {{ request('status') === 'unemployed' ? 'selected' : '' }}>{{ __('messages.filter_status_unemployed') }}</option>
                        </select>
                    </div>

                    <!-- Shift Type -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('messages.filter_shift') }}</label>
                        <select name="shift" class="input-field text-sm">
                            <option value="">{{ __('messages.filter_status_both') }}</option>
                            <option value="morning" {{ request('shift') === 'morning' ? 'selected' : '' }}>{{ __('messages.filter_shift_morning') }}</option>
                            <option value="afternoon" {{ request('shift') === 'afternoon' ? 'selected' : '' }}>{{ __('messages.filter_shift_afternoon') }}</option>
                            <option value="night" {{ request('shift') === 'night' ? 'selected' : '' }}>{{ __('messages.filter_shift_night') }}</option>
                            <option value="flexible" {{ request('shift') === 'flexible' ? 'selected' : '' }}>{{ __('messages.filter_shift_flexible') }}</option>
                        </select>
                    </div>

                    <!-- Job Type -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('messages.filter_ad_type') }}</label>
                        <select name="ad_type" class="input-field text-sm">
                            <option value="">{{ __('messages.filter_status_both') }}</option>
                            <option value="full_time" {{ request('ad_type') === 'full_time' ? 'selected' : '' }}>{{ __('messages.filter_full_time') }}</option>
                            <option value="part_time" {{ request('ad_type') === 'part_time' ? 'selected' : '' }}>{{ __('messages.filter_part_time') }}</option>
                            <option value="seasonal" {{ request('ad_type') === 'seasonal' ? 'selected' : '' }}>{{ __('messages.filter_seasonal') }}</option>
                            <option value="one_time" {{ request('ad_type') === 'one_time' ? 'selected' : '' }}>{{ __('messages.filter_one_time') }}</option>
                        </select>
                    </div>

                    <!-- Hourly Rate Range -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('messages.filter_rate') }} (RSD)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="rate_min" value="{{ request('rate_min') }}" placeholder="Min" class="input-field text-sm w-1/2">
                            <span class="text-slate-400">-</span>
                            <input type="number" name="rate_max" value="{{ request('rate_max') }}" placeholder="Max" class="input-field text-sm w-1/2">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary flex-1 text-sm !py-2">
                            {{ __('messages.filter_apply') }}
                        </button>
                        <a href="{{ route('jobs.index', $locale) }}" class="btn-outline flex-1 text-sm !py-2 text-center">
                            {{ __('messages.filter_clear') }}
                        </a>
                    </div>
                </form>
            </aside>

            <!-- Job Listings Grid -->
            <div class="flex-1">
                <!-- Sort Bar -->
                <div class="flex items-center justify-between mb-6">
                    <p class="text-sm text-slate-500">
                        {{ $jobs->total() }} {{ __('messages.jobs_title') }}
                    </p>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-slate-500">Sort:</label>
                        <select onchange="window.location.href=this.value" class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="{{ route('jobs.index', array_merge([$locale], request()->except('sort'), ['sort' => 'latest'])) }}" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>
                                Najnoviji
                            </option>
                            <option value="{{ route('jobs.index', array_merge([$locale], request()->except('sort'), ['sort' => 'popular'])) }}" {{ request('sort') === 'popular' ? 'selected' : '' }}>
                                Najpopularniji
                            </option>
                            <option value="{{ route('jobs.index', array_merge([$locale], request()->except('sort'), ['sort' => 'rate_high'])) }}" {{ request('sort') === 'rate_high' ? 'selected' : '' }}>
                                Satnica ↓
                            </option>
                            <option value="{{ route('jobs.index', array_merge([$locale], request()->except('sort'), ['sort' => 'rate_low'])) }}" {{ request('sort') === 'rate_low' ? 'selected' : '' }}>
                                Satnica ↑
                            </option>
                        </select>
                    </div>
                </div>

                @if($jobs->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($jobs as $job)
                            @include('components.job-card', ['job' => $job, 'locale' => $locale])
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $jobs->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <h3 class="text-lg font-semibold text-slate-700 mb-2">{{ __('messages.jobs_no_results') }}</h3>
                        <a href="{{ route('jobs.index', $locale) }}" class="btn-primary mt-4 text-sm">{{ __('messages.filter_clear') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
