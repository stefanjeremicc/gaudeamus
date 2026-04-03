@extends('layouts.app')
@section('title', '500 - Greška na serveru')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <div class="font-mono text-8xl font-bold text-red-200 mb-4">500</div>
        <h1 class="text-2xl font-bold text-slate-900 mb-4">Greška na serveru</h1>
        <p class="text-slate-500 mb-8">Došlo je do greške. Molimo pokušajte ponovo.</p>
        <a href="{{ url('/' . app()->getLocale()) }}" class="btn-primary">Početna</a>
    </div>
</div>
@endsection
