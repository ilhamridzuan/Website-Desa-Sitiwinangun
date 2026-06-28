<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data
      x-bind:data-theme="$store.theme.current"
      x-init="$store.theme.init()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') — {{ config('app.name', 'Desa Sitiwinangun') }}</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-100 text-base-content font-sans antialiased">

<div class="drawer lg:drawer-open">
    <input id="admin-drawer" type="checkbox" class="drawer-toggle"/>

    <div class="drawer-content flex flex-col h-screen overflow-y-auto">
        {{-- Navbar --}}
        <div class="navbar bg-base-100 border-b border-base-300 sticky top-0 z-30 shadow-sm">
            {{-- Hamburger for mobile --}}
            <div class="flex-none lg:hidden">
                <label for="admin-drawer" aria-label="buka sidebar" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-5 w-5 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>
            </div>

            {{-- Brand / Title --}}
            <div class="flex-1 px-2 lg:px-4 flex items-center gap-2">
                <span class="font-serif font-bold text-lg text-primary hidden lg:block">
                    Desa Sitiwinangun
                </span>
                <div class="text-sm breadcrumbs hidden lg:block ml-4 text-base-content/50">
                    <ul>
                        <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @yield('breadcrumb')
                    </ul>
                </div>
                <span class="font-semibold text-base-content/70 text-sm lg:hidden truncate">
                    @yield('title')
                </span>
            </div>

            {{-- Right Section --}}
            <div class="flex-none flex items-center gap-2">
                {{-- Theme Toggle --}}
                <label id="theme-toggle" class="swap swap-rotate btn btn-ghost btn-circle" title="Toggle tema" x-on:click="$store.theme.toggle()">
                    <svg x-show="$store.theme.isDark()" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-accent" viewBox="0 0 24 24">
                        <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/>
                    </svg>
                    <svg x-show="!$store.theme.isDark()" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-base-content/70" viewBox="0 0 24 24">
                        <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/>
                    </svg>
                </label>

                {{-- User Dropdown --}}
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost flex items-center gap-2 px-2 rounded-btn">
                        <div class="avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-8 h-8 flex items-center justify-center">
                                <span class="text-xs font-bold">
                                    {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                                </span>
                            </div>
                        </div>
                        <span class="text-sm font-medium hidden sm:block max-w-48 truncate" title="{{ Auth::user()->name }}">
                            {{ Auth::user()->name }}
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-50 mt-3 w-52 p-2 shadow-xl border border-base-300">
                        <li class="menu-title">
                            <span>{{ Auth::user()->email }}</span>
                        </li>
                        <li>
                            <a class="text-base-content/70">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="text-base-content/70">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Pengaturan
                            </a>
                        </li>
                        <div class="divider my-0.5"></div>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" id="btn-logout" class="w-full text-left text-error flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Main Content Area --}}
        <main class="flex-1 p-5 lg:p-8 bg-base-200 bg-batik-parang">
            @include('admin.partials._form-errors')
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="footer footer-center text-base-content/40 border-t border-base-300 bg-base-100 p-4">
            <aside>
                <p class="text-xs">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Desa Sitiwinangun') }} &mdash; Sistem Informasi Digital Kriya
                </p>
            </aside>
        </footer>
    </div>

    {{-- Drawer Side (Sidebar navigation) --}}
    <div class="drawer-side z-40">
        <label for="admin-drawer" aria-label="tutup sidebar" class="drawer-overlay"></label>
        <aside class="bg-base-100 border-r border-base-300 min-h-full w-64 flex flex-col">
            {{-- Brand header --}}
            <div class="flex items-center gap-3 px-5 py-4 border-b border-base-300 bg-primary/5">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary to-accent/60 flex items-center justify-center shrink-0 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary-content">
                        <path d="M9 20h6" />
                        <path d="M9 4h6" />
                        <path d="M10 4v4c-2 1-3.5 3-3.5 5.5S8 19 12 19s5.5-3 5.5-5.5S14 9 12 8V4" />
                        <path d="M16 11c1.5-1 3-1 3-1s-1 2-2.5 3" />
                    </svg>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-serif font-bold text-sm text-primary truncate leading-tight">
                        Admin Panel
                    </span>
                    <span class="text-xs text-base-content/50 truncate">
                        Desa Sitiwinangun
                    </span>
                </div>
            </div>

            {{-- Nav menu --}}
            <nav class="flex-1 py-4 px-3 overflow-y-auto">
                <ul class="menu menu-sm gap-0.5 w-full p-0">
                    <li class="menu-title text-xs uppercase tracking-widest mb-1">Utama</li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : 'text-base-content/75 hover:text-base-content' }} font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <div class="divider my-1 text-xs text-base-content/40">Konten</div>
                    <li>
                        <a href="{{ route('admin.collections.index') }}" class="{{ request()->routeIs('admin.collections.*') ? 'active' : 'text-base-content/75 hover:text-base-content' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Koleksi Kriya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.artisans.index') }}" class="{{ request()->routeIs('admin.artisans.*') ? 'active' : 'text-base-content/75 hover:text-base-content' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Kisah Pengrajin
                        </a>
                    </li>

                    <div class="divider my-1 text-xs text-base-content/40">Halaman Statis</div>
                    <li>
                        <a href="{{ route('admin.village-profile.edit') }}" class="{{ request()->routeIs('admin.village-profile.*') ? 'active' : 'text-base-content/75 hover:text-base-content' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Profil Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.history.edit') }}" class="{{ request()->routeIs('admin.history.*') ? 'active' : 'text-base-content/75 hover:text-base-content' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Sejarah Gerabah
                        </a>
                    </li>

                    <div class="divider my-1 text-xs text-base-content/40">Administrasi</div>
                    <li>
                        <a href="{{ route('admin.locations.index') }}" class="{{ request()->routeIs('admin.locations.*') ? 'active' : 'text-base-content/75 hover:text-base-content' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Jelajah Desa
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.board-members.index') }}" class="{{ request()->routeIs('admin.board-members.*') ? 'active' : 'text-base-content/75 hover:text-base-content' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Info Pengurus
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.storytelling.index') }}" class="{{ request()->routeIs('admin.storytelling.*') ? 'active' : 'text-base-content/75 hover:text-base-content' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Kisah Kriya
                        </a>
                    </li>

                    <div class="divider my-1 text-xs text-base-content/40">Sistem</div>
                    <li>
                        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : 'text-base-content/75 hover:text-base-content' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Pengaturan
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- Sidebar footer: user info + logout --}}
            <div class="border-t border-base-300 p-3 bg-base-200/50">
                <div class="flex items-center gap-3 px-2 py-1.5 mb-2">
                    <div class="avatar placeholder">
                        <div class="bg-primary text-primary-content rounded-full w-8 h-8 flex items-center justify-center">
                            <span class="text-xs font-bold">
                                {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-sm font-semibold truncate" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>
                        <span class="text-xs text-base-content/50 capitalize truncate">{{ Auth::user()->role }}</span>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm btn-block text-error hover:bg-error/10 justify-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar (Logout)
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>

@include('admin.partials._delete-modal')
@include('admin.partials._flash-toast')

@stack('scripts')
</body>
</html>
