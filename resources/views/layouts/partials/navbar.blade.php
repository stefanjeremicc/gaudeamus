@php $locale = app()->getLocale(); @endphp

<nav class="bg-primary-900 text-white sticky top-0 z-50 shadow-lg" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home', $locale) }}" class="flex items-center space-x-2">
                <span class="text-2xl font-bold tracking-tight">
                    <span class="text-white">Gaude</span><span class="text-accent-400">amus</span>
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('home', $locale) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 transition {{ request()->routeIs('home') ? 'bg-white/15' : '' }}">
                    {{ __('messages.nav_home') }}
                </a>
                <a href="{{ route('jobs.index', $locale) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 transition {{ request()->routeIs('jobs.*') ? 'bg-white/15' : '' }}">
                    {{ __('messages.nav_jobs') }}
                </a>
                <a href="{{ route('pages.about', $locale) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 transition {{ request()->routeIs('pages.about') ? 'bg-white/15' : '' }}">
                    {{ __('messages.nav_about') }}
                </a>
                <a href="{{ route('blog.index', $locale) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 transition {{ request()->routeIs('blog.*') ? 'bg-white/15' : '' }}">
                    {{ __('messages.nav_blog') }}
                </a>
                <a href="{{ route('pages.employers', $locale) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium text-accent-400 hover:bg-white/10 transition {{ request()->routeIs('pages.employers') ? 'bg-white/15' : '' }}">
                    {{ __('messages.nav_for_employers') }}
                </a>
            </div>

            <!-- Right side: Language + Auth -->
            <div class="hidden md:flex items-center space-x-3">
                <!-- Language Switcher -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-1 px-3 py-2 rounded-lg text-sm hover:bg-white/10 transition">
                        <span class="uppercase font-medium">{{ $locale }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-lg py-1 z-50">
                        @foreach(['sr' => 'Srpski', 'en' => 'English', 'ru' => 'Русский'] as $code => $name)
                            <a href="{{ url('/' . $code . '/' . (request()->segment(2) ?? '')) }}"
                               class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50 {{ $locale === $code ? 'font-bold text-primary-600' : '' }}">
                                {{ $name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-white/10 transition">
                            <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50">{{ __('messages.nav_my_account') }}</a>
                            <form method="POST" action="{{ route('logout', $locale) }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    {{ __('messages.nav_logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login', $locale) }}" class="px-4 py-2 text-sm font-medium hover:bg-white/10 rounded-lg transition">
                        {{ __('messages.nav_login') }}
                    </a>
                    <a href="{{ route('register', $locale) }}" class="btn-cta text-sm !py-2 !px-4">
                        {{ __('messages.nav_register') }}
                    </a>
                @endauth
            </div>

            <!-- Mobile hamburger -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg hover:bg-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileOpen" x-transition class="md:hidden bg-primary-950 border-t border-white/10">
        <div class="px-4 py-4 space-y-2">
            <a href="{{ route('home', $locale) }}" class="block px-4 py-2 rounded-lg hover:bg-white/10">{{ __('messages.nav_home') }}</a>
            <a href="{{ route('jobs.index', $locale) }}" class="block px-4 py-2 rounded-lg hover:bg-white/10">{{ __('messages.nav_jobs') }}</a>
            <a href="{{ route('pages.about', $locale) }}" class="block px-4 py-2 rounded-lg hover:bg-white/10">{{ __('messages.nav_about') }}</a>
            <a href="{{ route('blog.index', $locale) }}" class="block px-4 py-2 rounded-lg hover:bg-white/10">{{ __('messages.nav_blog') }}</a>
            <a href="{{ route('pages.employers', $locale) }}" class="block px-4 py-2 rounded-lg text-accent-400 hover:bg-white/10">{{ __('messages.nav_for_employers') }}</a>

            <div class="border-t border-white/10 pt-2 mt-2">
                <div class="flex space-x-2 px-4 py-2">
                    @foreach(['sr', 'en', 'ru'] as $code)
                        <a href="{{ url('/' . $code . '/' . (request()->segment(2) ?? '')) }}"
                           class="px-3 py-1 rounded-lg text-sm uppercase {{ $locale === $code ? 'bg-white/20 font-bold' : 'hover:bg-white/10' }}">
                            {{ $code }}
                        </a>
                    @endforeach
                </div>
            </div>

            @auth
                <a href="#" class="block px-4 py-2 rounded-lg hover:bg-white/10">{{ __('messages.nav_my_account') }}</a>
                <form method="POST" action="{{ route('logout', $locale) }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 rounded-lg text-red-300 hover:bg-white/10">{{ __('messages.nav_logout') }}</button>
                </form>
            @else
                <a href="{{ route('login', $locale) }}" class="block px-4 py-2 rounded-lg hover:bg-white/10">{{ __('messages.nav_login') }}</a>
                <a href="{{ route('register', $locale) }}" class="block px-4 py-2 rounded-lg bg-cta-500 text-center font-semibold">{{ __('messages.nav_register') }}</a>
            @endauth
        </div>
    </div>
</nav>
