@extends('layouts.app')
@section('title', 'Moje prijave - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Moje prijave</h1>

            @if($applications->count())
                <div class="space-y-4">
                    @foreach($applications as $app)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                                        {{ strtoupper(substr($app->jobListing->company->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('jobs.show', [$locale, $app->jobListing->slug]) }}" class="text-lg font-semibold text-slate-900 hover:text-primary-600">
                                            {{ $app->jobListing->getTranslation('title', $locale) }}
                                        </a>
                                        <p class="text-sm text-slate-500">{{ $app->jobListing->company->name }} &bull; {{ $app->jobListing->city ?? $app->jobListing->region?->getTranslation('name', $locale) }}</p>
                                        <p class="text-xs text-slate-400 mt-1">Prijavljeno {{ $app->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ match($app->status) {
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'reviewing' => 'bg-blue-100 text-blue-700',
                                        'accepted' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-600',
                                    } }}">
                                    {{ match($app->status) {
                                        'pending' => 'Na čekanju',
                                        'reviewing' => 'Pregleda se',
                                        'accepted' => 'Prihvaćeno',
                                        'rejected' => 'Odbijeno',
                                        default => $app->status,
                                    } }}
                                </span>
                            </div>
                            @if($app->cover_letter)
                                <p class="text-sm text-slate-500 mt-3 bg-slate-50 rounded-xl p-3">{{ \Illuminate\Support\Str::limit($app->cover_letter, 200) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $applications->links() }}</div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                    <p class="text-slate-500">Nemate još prijava.</p>
                    <a href="{{ route('jobs.index', $locale) }}" class="btn-primary mt-4 inline-block">Pretražite poslove</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
