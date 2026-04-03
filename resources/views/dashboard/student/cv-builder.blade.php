@extends('layouts.app')
@section('title', 'CV Builder - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">CV Builder</h1>
            <p class="text-slate-500 mb-8">Popunite sekcije ispod i generišite profesionalni CV u PDF formatu.</p>

            <form method="POST" action="{{ route('student.cv.generate', $locale) }}" class="space-y-6" id="cv-form">
                @csrf

                <!-- Personal Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Lični podaci</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Ime i prezime *</label>
                            <input type="text" name="full_name" value="{{ old('full_name', $user->name) }}" class="input-field" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-field" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Telefon</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Grad</label>
                            <input type="text" name="city" value="{{ old('city', $profile?->city) }}" class="input-field">
                        </div>
                    </div>
                </div>

                <!-- Professional Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Profesionalni rezime</h2>
                    <textarea name="summary" rows="3" class="input-field" placeholder="Kratko opišite sebe, vaše ciljeve i šta tražite...">{{ old('summary') }}</textarea>
                </div>

                <!-- Education -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6" x-data="{ items: [{ institution: '{{ $profile?->university ?? '' }}', degree: '{{ $profile?->faculty ?? '' }}', year: '' }] }">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-900">Obrazovanje</h2>
                        <button type="button" @click="items.push({institution: '', degree: '', year: ''})" class="text-sm text-primary-600 hover:underline">+ Dodaj</button>
                    </div>
                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pb-4 border-b border-slate-100 last:border-0">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Institucija</label>
                                <input type="text" :name="'education['+index+'][institution]'" x-model="item.institution" class="input-field text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Smer / Diploma</label>
                                <input type="text" :name="'education['+index+'][degree]'" x-model="item.degree" class="input-field text-sm">
                            </div>
                            <div class="flex items-end gap-2">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-slate-500 mb-1">Godina</label>
                                    <input type="text" :name="'education['+index+'][year]'" x-model="item.year" class="input-field text-sm" placeholder="2020 - danas">
                                </div>
                                <button type="button" x-show="items.length > 1" @click="items.splice(index, 1)" class="p-2 text-red-400 hover:text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Work Experience -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6" x-data="{ items: [{ company: '', position: '', period: '', description: '' }] }">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-slate-900">Radno iskustvo</h2>
                        <button type="button" @click="items.push({company: '', position: '', period: '', description: ''})" class="text-sm text-primary-600 hover:underline">+ Dodaj</button>
                    </div>
                    <template x-for="(item, index) in items" :key="index">
                        <div class="mb-4 pb-4 border-b border-slate-100 last:border-0">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">Kompanija</label>
                                    <input type="text" :name="'experience['+index+'][company]'" x-model="item.company" class="input-field text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">Pozicija</label>
                                    <input type="text" :name="'experience['+index+'][position]'" x-model="item.position" class="input-field text-sm">
                                </div>
                                <div class="flex items-end gap-2">
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Period</label>
                                        <input type="text" :name="'experience['+index+'][period]'" x-model="item.period" class="input-field text-sm" placeholder="Jun 2024 - Sep 2024">
                                    </div>
                                    <button type="button" x-show="items.length > 1" @click="items.splice(index, 1)" class="p-2 text-red-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Opis zaduženja</label>
                                <textarea :name="'experience['+index+'][description]'" x-model="item.description" rows="2" class="input-field text-sm" placeholder="Opišite šta ste radili..."></textarea>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Skills -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Veštine</h2>
                    <textarea name="skills" rows="2" class="input-field" placeholder="Razdvojite zarezom: PHP, JavaScript, Komunikacija, Excel...">{{ old('skills', $profile?->skills->pluck('name')->map(fn($n) => $n[app()->getLocale()] ?? $n['sr'] ?? '')->implode(', ')) }}</textarea>
                </div>

                <!-- Languages -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Jezici</h2>
                    <textarea name="languages" rows="2" class="input-field" placeholder="Srpski (maternji), Engleski (B2), Nemački (A2)...">{{ old('languages', 'Srpski (maternji)') }}</textarea>
                </div>

                <button type="submit" class="btn-cta text-lg">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Generiši PDF
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
