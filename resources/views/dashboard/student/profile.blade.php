@extends('layouts.app')
@section('title', 'Moj profil - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Moj profil</h1>

            <form method="POST" action="{{ route('student.profile.update', $locale) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Osnovni podaci</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Ime i prezime</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Telefon</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Grad</label>
                            <input type="text" name="city" value="{{ old('city', $profile?->city) }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Region</label>
                            <select name="region_id" class="input-field">
                                <option value="">Izaberite region</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id', $profile?->region_id) == $region->id ? 'selected' : '' }}>
                                        {{ $region->getTranslation('name', $locale) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Education -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Obrazovanje</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Univerzitet</label>
                            <input type="text" name="university" value="{{ old('university', $profile?->university) }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Fakultet</label>
                            <input type="text" name="faculty" value="{{ old('faculty', $profile?->faculty) }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Godina studija</label>
                            <select name="year_of_study" class="input-field">
                                <option value="">-</option>
                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ old('year_of_study', $profile?->year_of_study) == $i ? 'selected' : '' }}>{{ $i }}. godina</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Skills -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Veštine</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($skills as $skill)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="skills[]" value="{{ $skill->id }}" class="hidden peer"
                                    {{ in_array($skill->id, old('skills', $userSkills)) ? 'checked' : '' }}>
                                <span class="inline-flex px-4 py-2 rounded-xl text-sm border border-slate-200 peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 hover:border-primary-300 transition">
                                    {{ $skill->getTranslation('name', $locale) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Bio -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">O meni</h2>
                    <textarea name="bio" rows="4" class="input-field" placeholder="Napišite kratko o sebi...">{{ old('bio', $profile?->getTranslation('bio', $locale)) }}</textarea>
                </div>

                <button type="submit" class="btn-primary">Sačuvaj profil</button>
            </form>
        </div>
    </div>
</div>
@endsection
