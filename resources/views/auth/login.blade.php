@extends('layouts.app')
@section('title', __('messages.auth_login') . ' - Gaudeamus')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-900">{{ __('messages.auth_login') }}</h1>
            <p class="text-slate-500 mt-2">{{ __('messages.hero_subtitle') }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <form method="POST" action="{{ route('login', $locale) }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">{{ __('messages.auth_email') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               class="input-field" placeholder="email@primer.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">{{ __('messages.auth_password') }}</label>
                        <input type="password" name="password" id="password" required
                               class="input-field" placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-sm text-slate-600">{{ __('messages.auth_remember') }}</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary w-full text-lg">{{ __('messages.auth_login') }}</button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-slate-500">
                    {{ __('messages.auth_no_account') }}
                    <a href="{{ route('register', $locale) }}" class="text-primary-600 font-semibold hover:underline">{{ __('messages.auth_register') }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
