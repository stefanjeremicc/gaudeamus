@extends('layouts.app')
@section('title', 'Sačuvani oglasi - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Sačuvani oglasi</h1>

            @if($bookmarks->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($bookmarks as $bookmark)
                        @include('components.job-card', ['job' => $bookmark->jobListing, 'locale' => $locale])
                    @endforeach
                </div>
                <div class="mt-6">{{ $bookmarks->links() }}</div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                    <p class="text-slate-500">Nemate sačuvanih oglasa.</p>
                    <a href="{{ route('jobs.index', $locale) }}" class="btn-primary mt-4 inline-block">Pretražite poslove</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
