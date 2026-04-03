@extends('layouts.app')
@section('title', 'Profil kompanije - Gaudeamus')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('dashboard.partials.sidebar')

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Profil kompanije</h1>

            <form method="POST" action="{{ route('employer.company.update', $locale) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Naziv kompanije *</label>
                            <input type="text" name="name" value="{{ old('name', $company->name) }}" class="input-field" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">PIB</label>
                            <input type="text" name="pib" value="{{ old('pib', $company->pib) }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Website</label>
                            <input type="url" name="website" value="{{ old('website', $company->website) }}" class="input-field" placeholder="https://">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Adresa</label>
                            <input type="text" name="address" value="{{ old('address', $company->address) }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Grad</label>
                            <input type="text" name="city" value="{{ old('city', $company->city) }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Region</label>
                            <select name="region_id" class="input-field">
                                <option value="">-</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id', $company->region_id) == $region->id ? 'selected' : '' }}>{{ $region->getTranslation('name', $locale) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Opis kompanije</label>
                            <textarea name="description" rows="4" class="input-field" placeholder="Opišite vašu kompaniju...">{{ old('description', $company->getTranslation('description', $locale)) }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Sačuvaj podatke</button>
            </form>
        </div>
    </div>
</div>
@endsection
