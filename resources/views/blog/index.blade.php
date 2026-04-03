@extends('layouts.app')
@section('title', __('messages.nav_blog') . ' - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">{{ __('messages.nav_blog') }}</h1>
        <p class="text-slate-500 mt-2">Saveti, novosti i vodiči za studente.</p>
    </div>

    <!-- Categories -->
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('blog.index', $locale) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('category') ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:border-primary-300' }} transition">
            Sve
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('blog.index', [$locale, 'category' => $cat->id]) }}"
               class="px-4 py-2 rounded-xl text-sm font-medium {{ request('category') == $cat->id ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:border-primary-300' }} transition">
                {{ $cat->getTranslation('name', $locale) }} ({{ $cat->posts_count }})
            </a>
        @endforeach
    </div>

    @if($posts->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <a href="{{ route('blog.show', [$locale, $post->slug]) }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition group">
                    @if($post->featured_image_path)
                        <img src="{{ asset('storage/' . $post->featured_image_path) }}" alt="{{ $post->getTranslation('title', $locale) }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                    <div class="p-6">
                        @if($post->category)
                            <span class="tag-category text-xs mb-2 inline-block">{{ $post->category->getTranslation('name', $locale) }}</span>
                        @endif
                        <h2 class="text-lg font-bold text-slate-900 group-hover:text-primary-600 transition mb-2">
                            {{ $post->getTranslation('title', $locale) }}
                        </h2>
                        @if($post->getTranslation('excerpt', $locale))
                            <p class="text-sm text-slate-500 line-clamp-2">{{ $post->getTranslation('excerpt', $locale) }}</p>
                        @endif
                        <div class="flex items-center justify-between mt-4 text-xs text-slate-400">
                            <span>{{ $post->author->name }}</span>
                            <span>{{ $post->published_at?->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $posts->links() }}</div>
    @else
        <div class="bg-white rounded-2xl p-12 text-center">
            <p class="text-slate-500">Nema objava u ovoj kategoriji.</p>
        </div>
    @endif
</div>
@endsection
