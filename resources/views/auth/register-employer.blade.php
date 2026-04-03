@extends('layouts.app')
@section('title', __('messages.auth_register_employer') . ' - Gaudeamus')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-900">{{ __('messages.auth_register_employer') }}</h1>
            <p class="text-slate-500 mt-2">Pronađite mlade, motivisane radnike za vaše poslovanje.</p>
        </div>

        <!-- Toggle -->
        <div class="flex bg-slate-100 rounded-xl p-1 mb-6">
            <a href="{{ route('register', $locale) }}" class="flex-1 py-2.5 text-center rounded-lg text-sm font-semibold text-slate-500 hover:text-slate-700 transition">
                {{ __('messages.filter_status_student') }}
            </a>
            <a href="{{ route('register.employer', $locale) }}" class="flex-1 py-2.5 text-center rounded-lg text-sm font-semibold bg-white shadow text-primary-600">
                {{ __('messages.nav_for_employers') }}
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <form method="POST" action="{{ route('register.employer', $locale) }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">{{ __('messages.auth_name') }}</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus class="input-field">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">{{ __('messages.auth_email') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="input-field">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">Naziv firme</label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required class="input-field">
                        @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="pib" class="block text-sm font-medium text-slate-700 mb-1">PIB (opciono)</label>
                        <input type="text" name="pib" id="pib" value="{{ old('pib') }}" class="input-field" placeholder="123456789">
                        @error('pib') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">{{ __('messages.auth_password') }}</label>
                            <input type="password" name="password" id="password" required class="input-field">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">{{ __('messages.auth_confirm_password') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="input-field">
                        </div>
                    </div>

                    <button type="submit" class="btn-cta w-full text-lg">{{ __('messages.auth_register_employer') }} &rarr;</button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-slate-500">
                    {{ __('messages.auth_has_account') }}
                    <a href="{{ route('login', $locale) }}" class="text-primary-600 font-semibold hover:underline">{{ __('messages.auth_login') }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
