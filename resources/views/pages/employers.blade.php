@extends('layouts.app')
@section('title', __('messages.nav_for_employers') . ' - Gaudeamus')

@section('content')
    <!-- Hero -->
    <section class="bg-gradient-to-br from-primary-900 to-primary-800 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-6">Pronađite idealne radnike za vaše poslovanje</h1>
            <p class="text-xl text-primary-200 mb-8">Pristupite bazi od hiljada motivisanih studenata širom Srbije.</p>
            <a href="{{ route('register.employer', $locale) }}" class="btn-cta text-lg !px-8 !py-4">
                {{ __('messages.auth_register_employer') }} &rarr;
            </a>
        </div>
    </section>

    <!-- Benefits -->
    <section class="max-w-7xl mx-auto px-4 py-16">
        <h2 class="text-2xl font-bold text-center text-slate-900 mb-12">Zašto odabrati Gaudeamus?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-primary-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Velika baza kandidata</h3>
                <p class="text-slate-500">Pristupite hiljadama studenata spremnih za rad u raznim oblastima.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-accent-400/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Legalan rad</h3>
                <p class="text-slate-500">Sva dokumentacija i ugovori su regulisani. Radite u skladu sa zakonom.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-cta-500/15 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-cta-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Brza popuna</h3>
                <p class="text-slate-500">Objavite oglas i primajte prijave u roku od nekoliko sati.</p>
            </div>
        </div>
    </section>

    @if($page)
    <section class="max-w-4xl mx-auto px-4 pb-16">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 prose prose-lg prose-slate max-w-none">
            {!! nl2br(e($page->getTranslation('body', $locale))) !!}
        </div>
    </section>
    @endif
@endsection
