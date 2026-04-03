@extends('layouts.app')
@section('title', $company->name . ' - Gaudeamus')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Company Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
        <div class="flex items-start space-x-4">
            @if($company->logo_path)
                <img src="{{ asset('storage/' . $company->logo_path) }}" alt="{{ $company->name }}" class="w-20 h-20 rounded-2xl object-cover">
            @else
                <div class="w-20 h-20 rounded-2xl bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-3xl">
                    {{ strtoupper(substr($company->name, 0, 1)) }}
                </div>
            @endif
            <div class="flex-1">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-slate-900">{{ $company->name }}</h1>
                    @if($company->is_verified)
                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Verifikovan
                        </span>
                    @endif
                </div>
                @if($company->avg_rating > 0)
                    <div class="flex items-center gap-2 mt-2">
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($company->avg_rating) ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            @endfor
                        </div>
                        <span class="font-mono font-bold text-slate-700">{{ $company->avg_rating }}</span>
                        <span class="text-sm text-slate-500">({{ $company->reviews_count }} recenzija)</span>
                    </div>
                @endif
                <p class="text-slate-500 mt-2">{{ $company->city }}{{ $company->region ? ', ' . $company->region->getTranslation('name', $locale) : '' }}</p>
            </div>
        </div>
        @if($company->getTranslation('description', $locale))
            <p class="mt-4 text-slate-600 leading-relaxed">{{ $company->getTranslation('description', $locale) }}</p>
        @endif
    </div>

    <!-- Active Jobs -->
    @if($jobs->count())
    <div class="mb-8">
        <h2 class="text-xl font-bold text-slate-900 mb-4">Aktivni oglasi ({{ $jobs->count() }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($jobs as $job)
                @include('components.job-card', ['job' => $job, 'locale' => $locale])
            @endforeach
        </div>
    </div>
    @endif

    <!-- Reviews -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-slate-900 mb-4">Recenzije</h2>

        @if($reviews->count())
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-bold text-sm">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-900 text-sm">{{ $review->user->name }}</span>
                            </div>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                @endfor
                            </div>
                        </div>
                        @if($review->comment)
                            <p class="text-sm text-slate-600">{{ $review->comment }}</p>
                        @endif
                        <span class="text-xs text-slate-400 mt-2 block">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-slate-500 bg-white rounded-2xl p-6 text-center">Nema jos recenzija za ovu kompaniju.</p>
        @endif
    </div>

    <!-- Leave Review -->
    @auth
        @if(auth()->user()->isStudent())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Ostavite recenziju</h3>
            <form method="POST" action="{{ route('company.review', [$locale, $company->id]) }}">
                @csrf
                <div class="mb-4" x-data="{ rating: 0 }">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Ocena *</label>
                    <div class="flex gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" @click="rating = {{ $i }}" class="focus:outline-none">
                                <svg class="w-8 h-8 transition" :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-slate-200'" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" x-model="rating">
                    @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Komentar (opciono)</label>
                    <textarea name="comment" rows="3" class="input-field text-sm" placeholder="Opisite vase iskustvo rada sa ovom kompanijom..."></textarea>
                </div>
                <button type="submit" class="btn-primary text-sm">Posalji recenziju</button>
            </form>
        </div>
        @endif
    @endauth
</div>
@endsection
