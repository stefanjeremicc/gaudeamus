@extends('layouts.app')
@section('title', $post->getTranslation('title', $locale) . ' - Gaudeamus Blog')

@section('content')
<article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('home', $locale) }}" class="hover:text-primary-600">{{ __('messages.nav_home') }}</a>
        <span>/</span>
        <a href="{{ route('blog.index', $locale) }}" class="hover:text-primary-600">{{ __('messages.nav_blog') }}</a>
        <span>/</span>
        <span class="text-slate-800">{{ \Illuminate\Support\Str::limit($post->getTranslation('title', $locale), 40) }}</span>
    </nav>

    @if($post->category)
        <span class="tag-category mb-4 inline-block">{{ $post->category->getTranslation('name', $locale) }}</span>
    @endif

    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">{{ $post->getTranslation('title', $locale) }}</h1>

    <div class="flex items-center space-x-4 text-sm text-slate-500 mb-8">
        <span>{{ $post->author->name }}</span>
        <span>&bull;</span>
        <span>{{ $post->published_at?->format('d. F Y.') }}</span>
    </div>

    @if($post->featured_image_path)
        <img src="{{ asset('storage/' . $post->featured_image_path) }}" alt="{{ $post->getTranslation('title', $locale) }}" class="w-full rounded-2xl mb-8">
    @endif

    <div class="prose prose-lg prose-slate max-w-none">
        {!! nl2br(e($post->getTranslation('body', $locale))) !!}
    </div>

    @if($relatedPosts->count())
    <div class="border-t border-slate-200 mt-12 pt-8">
        <h3 class="text-xl font-bold text-slate-900 mb-6">Slični članci</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($relatedPosts as $rp)
                <a href="{{ route('blog.show', [$locale, $rp->slug]) }}" class="bg-white rounded-xl border border-slate-100 p-4 hover:shadow-sm transition">
                    <h4 class="font-semibold text-slate-900 text-sm">{{ $rp->getTranslation('title', $locale) }}</h4>
                    <span class="text-xs text-slate-400 mt-2 block">{{ $rp->published_at?->format('d.m.Y') }}</span>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</article>
@endsection
