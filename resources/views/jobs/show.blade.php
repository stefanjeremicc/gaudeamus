@extends('layouts.app')

@section('title', $job->getTranslation('title', $locale) . ' - ' . $job->company->name . ' | Gaudeamus')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($job->getTranslation('description', $locale)), 160))
@section('og_type', 'article')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-6">
            <a href="{{ route('home', $locale) }}" class="hover:text-primary-600 transition">{{ __('messages.nav_home') }}</a>
            <span>/</span>
            <a href="{{ route('jobs.index', $locale) }}" class="hover:text-primary-600 transition">{{ __('messages.nav_jobs') }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">{{ $job->getTranslation('title', $locale) }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="flex-1">
                <!-- Job Header -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            @if($job->company->logo_path)
                                <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}" class="w-16 h-16 rounded-xl object-cover">
                            @else
                                <div class="w-16 h-16 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-2xl">
                                    {{ strtoupper(substr($job->company->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-slate-900">{{ $job->getTranslation('title', $locale) }}</h1>
                                <p class="text-lg text-slate-500 mt-1">{{ $job->company->name }} &bull; {{ $job->city ?? $job->region?->getTranslation('name', $locale) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            @auth
                                <button onclick="toggleBookmark({{ $job->id }})" class="p-3 rounded-xl border border-slate-200 hover:bg-slate-50 transition" title="{{ __('messages.jobs_save') }}">
                                    <svg class="w-5 h-5 {{ $isBookmarked ? 'text-red-500 fill-current' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            @endauth
                            <button onclick="navigator.share ? navigator.share({title: '{{ $job->getTranslation('title', $locale) }}', url: window.location.href}) : navigator.clipboard.writeText(window.location.href)"
                                    class="p-3 rounded-xl border border-slate-200 hover:bg-slate-50 transition" title="{{ __('messages.jobs_share') }}">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mb-6">
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
                        <span class="tag-type">
                            {{ match($job->shift_type) {
                                'morning' => __('messages.filter_shift_morning'),
                                'afternoon' => __('messages.filter_shift_afternoon'),
                                'night' => __('messages.filter_shift_night'),
                                'flexible' => __('messages.filter_shift_flexible'),
                                default => $job->shift_type,
                            } }}
                        </span>
                    </div>

                    <!-- Key Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if($job->hourly_rate_min || $job->hourly_rate_max)
                        <div class="bg-primary-50 rounded-xl p-4 text-center">
                            <div class="font-mono text-xl font-bold text-primary-600">
                                {{ $job->hourly_rate_min ? number_format($job->hourly_rate_min) : '' }}{{ $job->hourly_rate_max ? '-' . number_format($job->hourly_rate_max) : '' }}
                            </div>
                            <div class="text-xs text-primary-600/70 mt-1">{{ __('messages.jobs_per_hour') }}</div>
                        </div>
                        @endif
                        @if($job->working_hours_per_week)
                        <div class="bg-slate-50 rounded-xl p-4 text-center">
                            <div class="font-mono text-xl font-bold text-slate-700">{{ $job->working_hours_per_week }}</div>
                            <div class="text-xs text-slate-500 mt-1">{{ __('messages.jobs_hours_week') }}</div>
                        </div>
                        @endif
                        <div class="bg-slate-50 rounded-xl p-4 text-center">
                            <div class="font-mono text-xl font-bold text-slate-700">{{ $job->positions_count }}</div>
                            <div class="text-xs text-slate-500 mt-1">{{ __('messages.jobs_positions') }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 text-center">
                            <div class="font-mono text-xl font-bold text-slate-700">{{ $job->views_count }}</div>
                            <div class="text-xs text-slate-500 mt-1">{{ __('messages.jobs_views') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Opis posla</h2>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                        {!! nl2br(e($job->getTranslation('description', $locale))) !!}
                    </div>
                </div>

                <!-- Requirements -->
                @if($job->getTranslation('requirements', $locale))
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Potrebne veštine i uslovi</h2>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                        {!! nl2br(e($job->getTranslation('requirements', $locale))) !!}
                    </div>
                </div>
                @endif

                <!-- Skills -->
                @if($job->skills->count())
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Tražene veštine</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($job->skills as $skill)
                            <span class="px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-medium">
                                {{ $skill->getTranslation('name', $locale) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Additional Conditions -->
                @if($job->getTranslation('additional_conditions', $locale))
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Dodatni uslovi</h2>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                        {!! nl2br(e($job->getTranslation('additional_conditions', $locale))) !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="lg:w-96 flex-shrink-0 space-y-6">
                <!-- Apply Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-20">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">{{ __('messages.jobs_apply_now') }}</h3>

                    @auth
                        @php
                            $hasApplied = \App\Models\Application::where('user_id', auth()->id())->where('job_listing_id', $job->id)->exists();
                        @endphp

                        @if($hasApplied)
                            <div class="bg-green-50 text-green-700 rounded-xl p-4 text-center">
                                <svg class="w-8 h-8 mx-auto mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="font-semibold">Već ste se prijavili</p>
                                <p class="text-sm mt-1">Vaša prijava je poslata.</p>
                            </div>
                        @else
                            <form method="POST" action="{{ route('application.store', [$locale, $job->slug]) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Motivaciono pismo (opciono)</label>
                                        <textarea name="cover_letter" rows="4" class="input-field text-sm" placeholder="Zašto ste idealan kandidat za ovu poziciju?">{{ old('cover_letter') }}</textarea>
                                        @error('cover_letter')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">CV (PDF, DOC - opciono)</label>
                                        <input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                        @error('cv')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn-cta w-full text-lg">
                                        {{ __('messages.jobs_apply_now') }} &rarr;
                                    </button>
                                </div>
                            </form>
                        @endif
                    @else
                        <p class="text-slate-500 mb-4 text-sm">Prijavite se da biste se prijavili na ovaj oglas.</p>
                        <a href="{{ route('login', $locale) }}" class="btn-primary w-full text-center block mb-2">{{ __('messages.nav_login') }}</a>
                        <a href="{{ route('register', $locale) }}" class="btn-outline w-full text-center block text-sm">{{ __('messages.nav_register') }}</a>
                    @endauth

                    <!-- Job Meta -->
                    <div class="border-t border-slate-100 mt-6 pt-6 space-y-3 text-sm text-slate-500">
                        @if($job->published_at)
                        <div class="flex items-center justify-between">
                            <span>{{ __('messages.jobs_posted') }}</span>
                            <span class="font-medium text-slate-700">{{ $job->published_at->diffForHumans() }}</span>
                        </div>
                        @endif
                        @if($job->expires_at)
                        <div class="flex items-center justify-between">
                            <span>{{ __('messages.jobs_deadline') }}</span>
                            <span class="font-medium text-slate-700">{{ $job->expires_at->format('d.m.Y') }}</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between">
                            <span>{{ __('messages.filter_status') }}</span>
                            <span class="font-medium text-slate-700">
                                {{ match($job->employment_status_required) {
                                    'student' => __('messages.filter_status_student'),
                                    'unemployed' => __('messages.filter_status_unemployed'),
                                    default => __('messages.filter_status_both'),
                                } }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Company Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">O kompaniji</h3>
                    <div class="flex items-center space-x-3 mb-4">
                        @if($job->company->logo_path)
                            <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}" class="w-12 h-12 rounded-xl object-cover">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-lg">
                                {{ strtoupper(substr($job->company->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-slate-900">{{ $job->company->name }}</h4>
                            @if($job->company->is_verified)
                                <span class="text-xs text-green-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Verifikovan
                                </span>
                            @endif
                        </div>
                    </div>
                    @if($job->company->getTranslation('description', $locale))
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $job->company->getTranslation('description', $locale) }}</p>
                    @endif
                    @if($job->company->website)
                        <a href="{{ $job->company->website }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-sm text-primary-600 hover:underline mt-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            {{ $job->company->website }}
                        </a>
                    @endif
                </div>
            </aside>
        </div>

        <!-- Related Jobs -->
        @if($relatedJobs->count())
        <section class="mt-12">
            <h2 class="section-title mb-6">Slični oglasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedJobs as $relJob)
                    @include('components.job-card', ['job' => $relJob, 'locale' => $locale])
                @endforeach
            </div>
        </section>
        @endif
    </div>

    <!-- JSON-LD Structured Data -->
    @push('head')
    @php
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'title' => $job->getTranslation('title', $locale),
            'description' => \Illuminate\Support\Str::limit(strip_tags($job->getTranslation('description', $locale)), 500),
            'datePosted' => $job->published_at?->toIso8601String(),
            'employmentType' => $job->ad_type === 'full_time' ? 'FULL_TIME' : 'PART_TIME',
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => $job->company->name,
                'sameAs' => $job->company->website ?? '',
            ],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job->city ?? '',
                    'addressCountry' => 'RS',
                ],
            ],
        ];
        if ($job->expires_at) {
            $jsonLd['validThrough'] = $job->expires_at->toIso8601String();
        }
        if ($job->hourly_rate_min) {
            $jsonLd['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => 'RSD',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => $job->hourly_rate_min,
                    'maxValue' => $job->hourly_rate_max ?? $job->hourly_rate_min,
                    'unitText' => 'HOUR',
                ],
            ];
        }
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
    @endpush
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
        .then(() => window.location.reload());
    }
</script>
@endpush
