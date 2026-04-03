@extends('layouts.app')
@section('title', 'Moj nalog - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Dobrodošli, {{ $user->name }}!</h1>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                    <div class="font-mono text-2xl font-bold text-primary-600">{{ $stats['applications'] }}</div>
                    <div class="text-xs text-slate-500 mt-1">Ukupno prijava</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                    <div class="font-mono text-2xl font-bold text-amber-500">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-slate-500 mt-1">Na čekanju</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                    <div class="font-mono text-2xl font-bold text-green-500">{{ $stats['accepted'] }}</div>
                    <div class="text-xs text-slate-500 mt-1">Prihvaćeno</div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                    <div class="font-mono text-2xl font-bold text-slate-600">{{ $stats['bookmarks'] }}</div>
                    <div class="text-xs text-slate-500 mt-1">Sačuvano</div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900">Poslednje prijave</h2>
                    <a href="{{ route('student.applications', $locale) }}" class="text-sm text-primary-600 hover:underline">Pogledaj sve &rarr;</a>
                </div>

                @if($recentApplications->count())
                    <div class="space-y-4">
                        @foreach($recentApplications as $app)
                            <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-sm">
                                        {{ strtoupper(substr($app->jobListing->company->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('jobs.show', [$locale, $app->jobListing->slug]) }}" class="font-medium text-slate-900 hover:text-primary-600">
                                            {{ $app->jobListing->getTranslation('title', $locale) }}
                                        </a>
                                        <p class="text-xs text-slate-500">{{ $app->jobListing->company->name }} &bull; {{ $app->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ match($app->status) {
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'reviewing' => 'bg-blue-100 text-blue-700',
                                        'accepted' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        'withdrawn' => 'bg-slate-100 text-slate-600',
                                        default => 'bg-slate-100 text-slate-600',
                                    } }}">
                                    {{ match($app->status) {
                                        'pending' => 'Na čekanju',
                                        'reviewing' => 'Pregleda se',
                                        'accepted' => 'Prihvaćeno',
                                        'rejected' => 'Odbijeno',
                                        'withdrawn' => 'Povučeno',
                                        default => $app->status,
                                    } }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-8">Nemate još prijava. <a href="{{ route('jobs.index', $locale) }}" class="text-primary-600 hover:underline">Pretražite poslove</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
