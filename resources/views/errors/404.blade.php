@extends('layouts.app')
@section('title', '404 - Stranica nije pronađena')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <div class="font-mono text-8xl font-bold text-primary-200 mb-4">404</div>
        <h1 class="text-2xl font-bold text-slate-900 mb-4">Stranica nije pronađena</h1>
        <p class="text-slate-500 mb-8">Stranica koju tražite ne postoji ili je premeštena.</p>
        <div class="flex justify-center gap-4">
            <a href="{{ url('/' . app()->getLocale()) }}" class="btn-primary">Početna</a>
            <a href="{{ url('/' . app()->getLocale() . '/poslovi') }}" class="btn-outline">Poslovi</a>
        </div>
    </div>
</div>
@endsection
