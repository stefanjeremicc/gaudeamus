@php $locale = app()->getLocale(); $user = auth()->user(); @endphp

<aside class="lg:w-64 flex-shrink-0">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-20">
        <!-- User Info -->
        <div class="flex items-center space-x-3 mb-6 pb-6 border-b border-slate-100">
            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-bold text-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="font-semibold text-slate-900">{{ $user->name }}</div>
                <div class="text-xs text-slate-500">{{ $user->email }}</div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1">
            @if($user->isStudent())
                <a href="{{ route('student.dashboard', $locale) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('student.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Pregled</span>
                </a>
                <a href="{{ route('student.applications', $locale) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('student.applications') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Moje prijave</span>
                </a>
                <a href="{{ route('student.bookmarks', $locale) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('student.bookmarks') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span>Sacuvani oglasi</span>
                </a>
                <a href="{{ route('student.profile', $locale) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('student.profile') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Moj profil</span>
                </a>
            @elseif($user->isEmployer())
                <a href="{{ route('employer.dashboard', $locale) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('employer.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Pregled</span>
                </a>
                <a href="{{ route('employer.jobs.create', $locale) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('employer.jobs.create') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Objavi oglas</span>
                </a>
                <a href="{{ route('employer.jobs', $locale) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('employer.jobs') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>Moji oglasi</span>
                </a>
                <a href="{{ route('employer.company', $locale) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('employer.company') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Kompanija</span>
                </a>
            @endif
        </nav>
    </div>
</aside>
