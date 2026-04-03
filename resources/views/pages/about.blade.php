@extends('layouts.app')
@section('title', __('messages.nav_about') . ' - Gaudeamus')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-8">{{ __('messages.nav_about') }}</h1>

    @if($page)
        <div class="prose prose-lg prose-slate max-w-none bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            {!! nl2br(e($page->getTranslation('body', $locale))) !!}
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <p class="text-slate-500">Sadržaj stranice će uskoro biti dodat.</p>
        </div>
    @endif
</div>
@endsection
