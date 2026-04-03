@extends('layouts.app')
@section('title', 'Prijave - ' . $jobListing->getTranslation('title', $locale))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <div class="mb-6">
                <a href="{{ route('employer.jobs', $locale) }}" class="text-sm text-primary-600 hover:underline">&larr; Nazad na oglase</a>
                <h1 class="text-2xl font-bold text-slate-900 mt-2">Prijave za: {{ $jobListing->getTranslation('title', $locale) }}</h1>
            </div>

            @if($applications->count())
                <div class="space-y-4">
                    @foreach($applications as $app)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-semibold text-slate-900">{{ $app->user->name }}</h3>
                                    <p class="text-sm text-slate-500">{{ $app->user->email }} &bull; {{ $app->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ match($app->status) {
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'reviewing' => 'bg-blue-100 text-blue-700',
                                        'accepted' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-600',
                                    } }}">
                                    {{ match($app->status) { 'pending' => 'Na čekanju', 'reviewing' => 'Pregleda se', 'accepted' => 'Prihvaćeno', 'rejected' => 'Odbijeno', default => $app->status } }}
                                </span>
                            </div>

                            @if($app->cover_letter)
                                <div class="bg-slate-50 rounded-xl p-4 mb-4 text-sm text-slate-600">
                                    {{ $app->cover_letter }}
                                </div>
                            @endif

                            @if($app->cv_path)
                                <p class="text-sm text-primary-600 mb-4">📎 CV priložen</p>
                            @endif

                            <form method="POST" action="{{ route('employer.applications.update', [$locale, $jobListing->id, $app->id]) }}" class="flex items-center gap-3">
                                @csrf
                                @method('PUT')
                                <select name="status" class="text-sm border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Na čekanju</option>
                                    <option value="reviewing" {{ $app->status === 'reviewing' ? 'selected' : '' }}>Pregleda se</option>
                                    <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>Prihvati</option>
                                    <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Odbij</option>
                                </select>
                                <input type="text" name="employer_notes" value="{{ $app->employer_notes }}" placeholder="Beleška..." class="text-sm border border-slate-200 rounded-lg px-3 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <button type="submit" class="btn-primary text-sm !py-2">Sačuvaj</button>
                            </form>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $applications->links() }}</div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                    <p class="text-slate-500">Nema prijava za ovaj oglas.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
