@props(['job', 'locale' => 'sr'])

<a href="{{ route('jobs.show', [$locale, $job->slug]) }}" class="job-card block group">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center space-x-3">
            @if($job->company->logo_path)
                <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100">
            @else
                <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-lg">
                    {{ strtoupper(substr($job->company->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h3 class="font-semibold text-slate-900 group-hover:text-primary-600 transition">
                    {{ $job->getTranslation('title', $locale) }}
                </h3>
                <p class="text-sm text-slate-500">{{ $job->company->name }} &bull; {{ $job->city ?? $job->region?->getTranslation('name', $locale) }}</p>
            </div>
        </div>

        @auth
            <button onclick="event.preventDefault(); toggleBookmark({{ $job->id }})" class="p-2 rounded-lg hover:bg-slate-100 transition">
                <svg class="w-5 h-5 {{ auth()->user()->hasBookmarked($job) ? 'text-red-500 fill-current' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        @endauth
    </div>

    <div class="flex flex-wrap gap-2 mb-4">
        <span class="tag-category">{{ $job->category?->getTranslation('name', $locale) }}</span>
        @if($job->is_featured)
            <span class="tag-urgent">&#9733; {{ $locale === 'sr' ? 'Istaknuto' : ($locale === 'ru' ? 'Избранное' : 'Featured') }}</span>
        @endif
        <span class="tag-type">
            {{ match($job->ad_type) {
                'full_time' => __('messages.filter_full_time'),
                'part_time' => __('messages.filter_part_time'),
                'seasonal' => __('messages.filter_seasonal'),
                'one_time' => __('messages.filter_one_time'),
                default => $job->ad_type,
            } }}
        </span>
    </div>

    <div class="flex items-center justify-between text-sm">
        <div class="flex items-center space-x-4 text-slate-500">
            @if($job->hourly_rate_min || $job->hourly_rate_max)
                <span class="flex items-center space-x-1">
                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-mono font-semibold text-primary-600">
                        {{ $job->hourly_rate_min ? number_format($job->hourly_rate_min) : '' }}{{ $job->hourly_rate_max ? '-' . number_format($job->hourly_rate_max) : '' }} {{ __('messages.jobs_per_hour') }}
                    </span>
                </span>
            @endif

            @if($job->working_hours_per_week)
                <span class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $job->working_hours_per_week }}{{ __('messages.jobs_hours_week') }}</span>
                </span>
            @endif

            @if($job->positions_count > 1)
                <span class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $job->positions_count }} {{ __('messages.jobs_positions') }}</span>
                </span>
            @endif
        </div>

        @if($job->published_at)
            <span class="text-xs text-slate-400">{{ $job->published_at->diffForHumans() }}</span>
        @endif
    </div>
</a>
