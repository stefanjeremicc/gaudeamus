@extends('layouts.app')
@section('title', 'Moji oglasi - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Moji oglasi</h1>
                <a href="{{ route('employer.jobs.create', $locale) }}" class="btn-cta text-sm">+ Novi oglas</a>
            </div>

            @if($jobs->count())
                <div class="space-y-4">
                    @foreach($jobs as $job)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <a href="{{ route('jobs.show', [$locale, $job->slug]) }}" class="text-lg font-semibold text-slate-900 hover:text-primary-600">
                                        {{ $job->getTranslation('title', $locale) }}
                                    </a>
                                    <div class="flex items-center gap-3 mt-2 text-sm text-slate-500">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $job->status === 'active' ? 'bg-green-100 text-green-700' : ($job->status === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                            {{ match($job->status) { 'active' => 'Aktivan', 'draft' => 'Draft', 'closed' => 'Zatvoren', 'expired' => 'Istekao', default => $job->status } }}
                                        </span>
                                        <span>{{ $job->applications_count }} prijava</span>
                                        <span>{{ $job->views_count }} pregleda</span>
                                        <span>{{ $job->city }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('employer.jobs.applications', [$locale, $job->id]) }}" class="btn-outline text-sm !py-2">
                                    Prijave ({{ $job->applications_count }})
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $jobs->links() }}</div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                    <p class="text-slate-500">Nemate još oglasa.</p>
                    <a href="{{ route('employer.jobs.create', $locale) }}" class="btn-cta mt-4 inline-block">Objavite prvi oglas</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
