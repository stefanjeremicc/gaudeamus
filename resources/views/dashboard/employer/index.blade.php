@extends('layouts.app')
@section('title', 'Poslodavac panel - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-slate-900">{{ $company->name }}</h1>
                <a href="{{ route('employer.jobs.create', $locale) }}" class="btn-cta text-sm">+ Objavi oglas</a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                    <div class="font-mono text-2xl font-bold text-primary-600">{{ $stats['active_jobs'] }}</div>
                    <div class="text-xs text-slate-500 mt-1">Aktivni oglasi</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                    <div class="font-mono text-2xl font-bold text-amber-500">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-slate-500 mt-1">Nove prijave</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                    <div class="font-mono text-2xl font-bold text-slate-600">{{ $stats['total_applications'] }}</div>
                    <div class="text-xs text-slate-500 mt-1">Ukupno prijava</div>
                </div>
            </div>

            <!-- Recent Jobs -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Vaši oglasi</h2>
                @if($recentJobs->count())
                    <div class="space-y-3">
                        @foreach($recentJobs as $job)
                            <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50">
                                <div>
                                    <a href="{{ route('jobs.show', [$locale, $job->slug]) }}" class="font-medium text-slate-900 hover:text-primary-600">
                                        {{ $job->getTranslation('title', $locale) }}
                                    </a>
                                    <div class="flex items-center gap-3 mt-1 text-xs text-slate-500">
                                        <span class="px-2 py-0.5 rounded-full {{ $job->status === 'active' ? 'bg-green-100 text-green-700' : ($job->status === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                            {{ ucfirst($job->status) }}
                                        </span>
                                        <span>{{ $job->applications_count }} prijava</span>
                                        <span>{{ $job->views_count }} pregleda</span>
                                    </div>
                                </div>
                                <a href="{{ route('employer.jobs.applications', [$locale, $job->id]) }}" class="text-sm text-primary-600 hover:underline">
                                    Prijave &rarr;
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-8">Nemate još oglasa. <a href="{{ route('employer.jobs.create', $locale) }}" class="text-primary-600 hover:underline">Objavite prvi oglas</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
