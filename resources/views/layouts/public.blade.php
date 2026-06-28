<!DOCTYPE html>
<html lang="id" data-theme="batik-light"
      x-data
      :data-theme="$store.theme.current">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- SEO --}}
    <title>@yield('title', 'Museum Digital Gerabah Sitiwinangun — Dari Tanah Menjadi Warisan')</title>
    <meta name="description" content="@yield('meta_description', 'Museum digital gerabah Desa Sitiwinangun, Cirebon. Jelajahi koleksi kriya, kisah pengrajin, proses produksi, dan virtual tour 360° desa gerabah bersejarah.')">
    <meta name="keywords" content="gerabah, sitiwinangun, cirebon, kerajinan, kriya, museum digital, batik, tanah liat">
    <meta name="author" content="TPLM Universitas Telkom">
    <meta name="robots" content="@yield('robots', 'index, follow')">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'Museum Digital Gerabah Sitiwinangun')">
    <meta property="og:description" content="@yield('meta_description', 'Museum digital gerabah Desa Sitiwinangun, Cirebon. Dari Tanah Menjadi Warisan.')">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Extra Head --}}
    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-base-100 text-base-content font-sans antialiased">

    {{-- ============================================================
         NAVBAR — Sticky + Glassmorphism + Responsive Collapse
         ============================================================ --}}
    <header class="sticky top-0 z-50 navbar-glass" id="main-navbar"
            x-data="{ scrolled: false, mobileOpen: false }"
            x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
            :class="{ 'scrolled': scrolled }">
        <nav class="navbar max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Brand / Logo --}}
            <div class="navbar-start">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group" id="nav-brand">
                    {{-- Gerabah icon --}}
                    <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary-content">
                            <path d="M9 20h6" />
                            <path d="M9 4h6" />
                            <path d="M10 4v4c-2 1-3.5 3-3.5 5.5S8 19 12 19s5.5-3 5.5-5.5S14 9 12 8V4" />
                            <path d="M16 11c1.5-1 3-1 3-1s-1 2-2.5 3" />
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <span class="font-serif font-bold text-lg text-primary leading-tight">Sitiwinangun</span>
                        <span class="block text-[0.65rem] text-base-content/60 leading-tight -mt-0.5">Museum Digital Gerabah</span>
                    </div>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1 gap-0.5 text-sm font-medium">
                    <li>
                        <a href="{{ route('home') }}"
                           class="{{ request()->routeIs('home') ? 'active font-semibold' : '' }}">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.collections.index') }}"
                           class="{{ request()->routeIs('public.collections.*') ? 'active font-semibold' : '' }}">
                            Galeri Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.artisans.index') }}"
                           class="{{ request()->routeIs('public.artisans.*') ? 'active font-semibold' : '' }}">
                            Pengrajin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.virtual_tour') }}"
                           class="{{ request()->routeIs('public.virtual_tour') ? 'active font-semibold' : '' }}">
                            Virtual Tour
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.production') }}"
                           class="{{ request()->routeIs('public.production') ? 'active font-semibold' : '' }}">
                            Proses Produksi
                        </a>
                    </li>
                    <li>
                        <details>
                            <summary class="{{ request()->routeIs('public.about', 'public.history', 'public.locations', 'public.board', 'public.storytelling') ? 'active font-semibold' : '' }}">
                                Tentang
                            </summary>
                            <ul class="bg-base-100 rounded-box shadow-lg z-50 w-52 p-2 mt-2">
                                <li><a href="{{ route('public.about') }}">Tentang Sitiwinangun</a></li>
                                <li><a href="{{ route('public.history') }}">Sejarah Gerabah</a></li>
                                <li><a href="{{ route('public.locations') }}">Jelajah Desa</a></li>
                                <li><a href="{{ route('public.board') }}">Info Pengurus</a></li>
                                <li><a href="{{ route('public.storytelling') }}">Kisah Kriya</a></li>
                            </ul>
                        </details>
                    </li>
                </ul>
            </div>

            {{-- Navbar End: Theme Toggle + Mobile Hamburger --}}
            <div class="navbar-end gap-2">
                {{-- Theme Toggle (Sun/Moon) --}}
                <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm" id="theme-toggle"
                       aria-label="Toggle tema gelap/terang">
                    <input type="checkbox"
                           class="theme-controller"
                           :checked="$store.theme.isDark()"
                           @change="$store.theme.toggle()"
                           value="batik-dark" />

                    {{-- Sun icon (light mode) --}}
                    <svg class="swap-off h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/>
                    </svg>

                    {{-- Moon icon (dark mode) --}}
                    <svg class="swap-on h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/>
                    </svg>
                </label>

                {{-- Mobile Hamburger --}}
                <button class="btn btn-ghost btn-circle btn-sm lg:hidden"
                        @click="mobileOpen = !mobileOpen"
                        aria-label="Menu navigasi"
                        id="mobile-menu-toggle">
                    {{-- Hamburger icon --}}
                    <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    {{-- Close icon --}}
                    <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </nav>

        {{-- Mobile Menu Dropdown --}}
        <div class="lg:hidden overflow-hidden transition-all duration-300 ease-in-out"
             x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             x-cloak
             id="mobile-menu">
            <ul class="menu bg-base-100 w-full px-4 pb-4 pt-2 gap-0.5 border-t border-base-300/50">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.collections.index') }}" class="{{ request()->routeIs('public.collections.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Galeri Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.artisans.index') }}" class="{{ request()->routeIs('public.artisans.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Pengrajin
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.virtual_tour') }}" class="{{ request()->routeIs('public.virtual_tour') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Virtual Tour
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.production') }}" class="{{ request()->routeIs('public.production') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Proses Produksi
                    </a>
                </li>
                <li class="menu-title mt-2 text-xs uppercase tracking-wider opacity-50">Tentang</li>
                <li>
                    <a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m4 0v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0h-4m4-14h.01M12 7h.01M9 7h.01M15 11h.01M12 11h.01M9 11h.01"/></svg>
                        Tentang Sitiwinangun
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.history') }}" class="{{ request()->routeIs('public.history') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Sejarah Gerabah
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.locations') }}" class="{{ request()->routeIs('public.locations') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Jelajah Desa
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.board') }}" class="{{ request()->routeIs('public.board') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Info Pengurus
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.storytelling') }}" class="{{ request()->routeIs('public.storytelling') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Kisah Kriya
                    </a>
                </li>
            </ul>
        </div>
    </header>

    {{-- ============================================================
         MAIN CONTENT
         ============================================================ --}}
    <main class="flex-1" id="main-content">
        @yield('content')
    </main>

    {{-- ============================================================
         FOOTER — Multi-column + Batik pattern
         ============================================================ --}}
    <footer class="bg-base-300 bg-batik-parang mt-auto" id="main-footer">
        <div class="max-w-7xl mx-auto">
            {{-- Top Section: 4 columns --}}
            <div class="footer sm:footer-horizontal p-10 text-base-content">
                {{-- Column 1: Tentang Kami --}}
                <nav>
                    <h6 class="footer-title font-serif text-primary">Museum Gerabah</h6>
                    <p class="max-w-xs text-sm leading-relaxed opacity-80">
                        Museum Digital Gerabah Desa Sitiwinangun — platform digital storytelling
                        yang mendokumentasikan warisan kriya gerabah Cirebon sejak abad ke-15.
                    </p>
                    <p class="text-xs opacity-60 mt-2 italic">"Dari Tanah Menjadi Warisan"</p>
                </nav>

                {{-- Column 2: Navigasi Utama --}}
                <nav>
                    <h6 class="footer-title">Navigasi</h6>
                    <a href="{{ route('home') }}" class="link link-hover text-sm">Beranda</a>
                    <a href="{{ route('public.collections.index') }}" class="link link-hover text-sm">Galeri Produk</a>
                    <a href="{{ route('public.artisans.index') }}" class="link link-hover text-sm">Kisah Pengrajin</a>
                    <a href="{{ route('public.virtual_tour') }}" class="link link-hover text-sm">Virtual Tour 360°</a>
                    <a href="{{ route('public.production') }}" class="link link-hover text-sm">Proses Produksi</a>
                </nav>

                {{-- Column 3: Halaman Lain --}}
                <nav>
                    <h6 class="footer-title">Informasi</h6>
                    <a href="{{ route('public.about') }}" class="link link-hover text-sm">Tentang Sitiwinangun</a>
                    <a href="{{ route('public.history') }}" class="link link-hover text-sm">Sejarah Gerabah</a>
                    <a href="{{ route('public.locations') }}" class="link link-hover text-sm">Jelajah Desa</a>
                    <a href="{{ route('public.board') }}" class="link link-hover text-sm">Info Pengurus</a>
                    <a href="{{ route('public.storytelling') }}" class="link link-hover text-sm">Kisah Kriya</a>
                </nav>

                {{-- Column 4: Kontak --}}
                <nav>
                    <h6 class="footer-title">Kontak</h6>
                    <div class="flex items-start gap-2 text-sm opacity-80">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Desa Sitiwinangun, Kec. Jamblang,<br>Kab. Cirebon, Jawa Barat</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm opacity-80 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>info@sitiwinangun.id</span>
                    </div>
                </nav>
            </div>

            {{-- Bottom Section: Copyright + Hidden Admin Link --}}
            <div class="footer footer-center p-6 border-t border-base-content/10">
                <div class="flex flex-col sm:flex-row items-center gap-2 text-xs opacity-60">
                    <p>&copy; {{ date('Y') }} Museum Digital Gerabah Sitiwinangun. Tim TPLM Universitas Telkom.</p>
                    <span class="hidden sm:inline">•</span>
                    <a href="{{ route('admin.login') }}" class="hover:opacity-100 transition-opacity" title="Admin" id="admin-login-link">
                        Kelola
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Extra Scripts --}}
    @stack('scripts')
</body>
</html>
