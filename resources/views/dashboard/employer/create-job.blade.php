@extends('layouts.app')
@section('title', 'Objavi oglas - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Objavi novi oglas</h1>

            <form method="POST" action="{{ route('employer.jobs.store', $locale) }}" class="space-y-6">
                @csrf

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Osnovni podaci</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Naziv pozicije *</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="input-field" required placeholder="npr. Junior Web Developer">
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Opis posla *</label>
                            <textarea name="description" rows="6" class="input-field" required placeholder="Detaljno opišite poziciju, odgovornosti i benefite...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Potrebne veštine i uslovi</label>
                            <textarea name="requirements" rows="3" class="input-field" placeholder="Potrebne kvalifikacije, iskustvo, veštine...">{{ old('requirements') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Dodatni uslovi</label>
                            <textarea name="additional_conditions" rows="2" class="input-field" placeholder="Npr. vozačka dozvola, sopstveni alat...">{{ old('additional_conditions') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Detalji pozicije</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Kategorija *</label>
                            <select name="job_category_id" class="input-field" required>
                                <option value="">Izaberite kategoriju</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('job_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->getTranslation('name', $locale) }}</option>
                                @endforeach
                            </select>
                            @error('job_category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Region *</label>
                            <select name="region_id" class="input-field" required>
                                <option value="">Izaberite region</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->getTranslation('name', $locale) }}</option>
                                @endforeach
                            </select>
                            @error('region_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Grad</label>
                            <input type="text" name="city" value="{{ old('city') }}" class="input-field" placeholder="Beograd">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Broj mesta *</label>
                            <input type="number" name="positions_count" value="{{ old('positions_count', 1) }}" min="1" class="input-field" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Min satnica (RSD)</label>
                            <input type="number" name="hourly_rate_min" value="{{ old('hourly_rate_min') }}" min="0" class="input-field" placeholder="300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Max satnica (RSD)</label>
                            <input type="number" name="hourly_rate_max" value="{{ old('hourly_rate_max') }}" min="0" class="input-field" placeholder="500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Sati nedeljno</label>
                            <input type="number" name="working_hours_per_week" value="{{ old('working_hours_per_week') }}" min="1" max="60" class="input-field" placeholder="20">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Smena *</label>
                            <select name="shift_type" class="input-field" required>
                                <option value="flexible" {{ old('shift_type') === 'flexible' ? 'selected' : '' }}>Fleksibilna</option>
                                <option value="morning" {{ old('shift_type') === 'morning' ? 'selected' : '' }}>Jutarnja</option>
                                <option value="afternoon" {{ old('shift_type') === 'afternoon' ? 'selected' : '' }}>Popodnevna</option>
                                <option value="night" {{ old('shift_type') === 'night' ? 'selected' : '' }}>Noćna</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tip oglasa *</label>
                            <select name="ad_type" class="input-field" required>
                                <option value="part_time" {{ old('ad_type') === 'part_time' ? 'selected' : '' }}>Skraćeno radno vreme</option>
                                <option value="full_time" {{ old('ad_type') === 'full_time' ? 'selected' : '' }}>Puno radno vreme</option>
                                <option value="seasonal" {{ old('ad_type') === 'seasonal' ? 'selected' : '' }}>Sezonski</option>
                                <option value="one_time" {{ old('ad_type') === 'one_time' ? 'selected' : '' }}>Jednokratno</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status kandidata *</label>
                            <select name="employment_status_required" class="input-field" required>
                                <option value="both" {{ old('employment_status_required') === 'both' ? 'selected' : '' }}>Svi</option>
                                <option value="student" {{ old('employment_status_required') === 'student' ? 'selected' : '' }}>Samo studenti</option>
                                <option value="unemployed" {{ old('employment_status_required') === 'unemployed' ? 'selected' : '' }}>Samo nezaposleni</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn-cta text-lg">Objavi oglas &rarr;</button>
                    <a href="{{ route('employer.jobs', $locale) }}" class="btn-outline">Otkaži</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
