@extends('layouts.app')
@section('title', '403 - Pristup odbijen')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <div class="font-mono text-8xl font-bold text-amber-200 mb-4">403</div>
        <h1 class="text-2xl font-bold text-slate-900 mb-4">Pristup odbijen</h1>
        <p class="text-slate-500 mb-8">Nemate dozvolu za pristup ovoj stranici.</p>
        <a href="{{ url('/' . app()->getLocale()) }}" class="btn-primary">Početna</a>
    </div>
</div>
@endsection
