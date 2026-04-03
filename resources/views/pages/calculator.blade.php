@extends('layouts.app')
@section('title', 'Kalkulator zarade - Gaudeamus')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-900">Kalkulator zarade</h1>
        <p class="text-slate-500 mt-2">Izračunajte koliko možete zaraditi kao student kroz Gaudeamus zadrugu.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8" x-data="calculator()">
        <div class="space-y-6">
            <!-- Hourly Rate -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Satnica (RSD)</label>
                <input type="range" x-model="rate" min="200" max="1500" step="10" class="w-full h-2 bg-primary-100 rounded-lg appearance-none cursor-pointer accent-primary-600">
                <div class="flex justify-between text-xs text-slate-400 mt-1">
                    <span>200 RSD</span>
                    <span class="font-mono text-lg font-bold text-primary-600" x-text="rate + ' RSD/h'"></span>
                    <span>1500 RSD</span>
                </div>
            </div>

            <!-- Hours per week -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Sati nedeljno</label>
                <input type="range" x-model="hours" min="5" max="40" step="1" class="w-full h-2 bg-primary-100 rounded-lg appearance-none cursor-pointer accent-primary-600">
                <div class="flex justify-between text-xs text-slate-400 mt-1">
                    <span>5h</span>
                    <span class="font-mono text-lg font-bold text-slate-700" x-text="hours + 'h/ned'"></span>
                    <span>40h</span>
                </div>
            </div>

            <!-- Cooperative Fee -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Provizija zadruge (%)</label>
                <div class="flex items-center gap-4">
                    <input type="range" x-model="fee" min="5" max="25" step="1" class="flex-1 h-2 bg-amber-100 rounded-lg appearance-none cursor-pointer accent-amber-500">
                    <span class="font-mono text-sm font-bold text-amber-600 w-12 text-right" x-text="fee + '%'"></span>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="mt-8 pt-8 border-t border-slate-100">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 rounded-xl p-4 text-center">
                    <div class="text-xs text-slate-500 mb-1">Nedeljno (bruto)</div>
                    <div class="font-mono text-xl font-bold text-slate-700" x-text="formatNumber(weeklyGross) + ' RSD'"></div>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 text-center">
                    <div class="text-xs text-slate-500 mb-1">Mesečno (bruto)</div>
                    <div class="font-mono text-xl font-bold text-slate-700" x-text="formatNumber(monthlyGross) + ' RSD'"></div>
                </div>
                <div class="bg-primary-50 rounded-xl p-4 text-center">
                    <div class="text-xs text-primary-600/70 mb-1">Mesečno (neto)</div>
                    <div class="font-mono text-2xl font-bold text-primary-600" x-text="formatNumber(monthlyNet) + ' RSD'"></div>
                </div>
                <div class="bg-primary-50 rounded-xl p-4 text-center">
                    <div class="text-xs text-primary-600/70 mb-1">Godišnje (neto)</div>
                    <div class="font-mono text-xl font-bold text-primary-600" x-text="formatNumber(yearlyNet) + ' RSD'"></div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <p class="text-xs text-slate-400">Provizija zadruge: <span class="font-mono font-bold text-amber-600" x-text="formatNumber(monthlyFee) + ' RSD/mesec'"></span></p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('jobs.index', $locale) }}" class="btn-cta">Pronađi posao &rarr;</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function calculator() {
    return {
        rate: 400,
        hours: 20,
        fee: 15,
        get weeklyGross() { return this.rate * this.hours; },
        get monthlyGross() { return this.weeklyGross * 4.33; },
        get monthlyFee() { return this.monthlyGross * (this.fee / 100); },
        get monthlyNet() { return this.monthlyGross - this.monthlyFee; },
        get yearlyNet() { return this.monthlyNet * 12; },
        formatNumber(n) { return Math.round(n).toLocaleString('sr-RS'); }
    }
}
</script>
@endpush
@endsection
