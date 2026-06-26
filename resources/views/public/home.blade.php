@extends('layouts.public')

@section('title', 'Museum Digital Gerabah Sitiwinangun — Dari Tanah Menjadi Warisan')
@section('meta_description', 'Museum digital gerabah Desa Sitiwinangun, Cirebon. Jelajahi koleksi kriya, kisah pengrajin, proses produksi, dan virtual tour 360° desa gerabah bersejarah.')

@section('content')

{{-- ============================================================
     SECTION 1 — HERO
     ============================================================ --}}
<section class="hero-photo min-h-[85vh] relative overflow-hidden" id="hero-section">
    {{-- ===== Slideshow Background Images with Ken Burns ===== --}}
    <div class="hero-slideshow absolute inset-0" aria-hidden="true">
        @for($i = 1; $i <= 8; $i++)
            <div class="hero-slide absolute inset-0 {{ $i === 1 ? 'active' : '' }}" data-slide="{{ $i }}">
                <img src="{{ asset('heroimg/' . $i . '.png') }}"
                     alt="Desa Sitiwinangun {{ $i }}"
                     class="w-full h-full object-cover"
                     @if($i === 1) fetchpriority="high" @else loading="lazy" @endif>
            </div>
        @endfor
    </div>

    {{-- ===== Very Subtle Gradient Overlay ===== --}}
    {{-- Bottom gradient only — keeps photo crisp at top, gentle fade at bottom for text --}}
    <div class="absolute inset-0 z-[2] bg-gradient-to-t from-black/50 via-black/15 to-transparent"></div>
    {{-- Extremely subtle radial vignette for depth --}}
    <div class="absolute inset-0 z-[2]" style="background: radial-gradient(ellipse at center, transparent 40%, rgba(0,0,0,0.15) 100%);"></div>

    {{-- ===== Hero Content ===== --}}
    <div class="hero-content w-full max-w-none text-center relative z-10 flex-col items-center justify-center min-h-[85vh] pb-16 pt-32 px-4">
        <div class="max-w-3xl mx-auto">
            {{-- Tagline pill --}}
            <div class="animate-fade-in inline-flex items-center gap-2 bg-white/15 backdrop-blur-md text-white px-4 py-1.5 rounded-full text-sm font-medium mb-6 border border-white/20 shadow-lg">
                Museum Digital Gerabah
            </div>

            {{-- Main heading --}}
            <h1 class="animate-fade-in-up text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-serif font-bold text-white leading-[1.1] tracking-tight hero-text-shadow">
                Dari Tanah<br>
                <span class="text-accent hero-accent-glow">Menjadi Warisan</span>
            </h1>

            {{-- Subheading --}}
            <p class="animate-fade-in-up py-6 text-lg md:text-xl text-white/85 max-w-xl mx-auto leading-relaxed hero-text-shadow-sm" style="animation-delay: 0.2s">
                Desa Sitiwinangun, Cirebon — menyimpan cerita tanah, tangan, dan tradisi kriya gerabah sejak abad ke-15.
            </p>

            {{-- CTA Buttons --}}
            <div class="animate-fade-in-up flex flex-wrap gap-3 justify-center" style="animation-delay: 0.35s">
                <a href="{{ route('public.collections.index') }}" class="btn btn-lg bg-white text-primary hover:bg-white/90 border-0 shadow-xl shadow-black/20 gap-2" id="hero-cta-galeri">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Jelajahi Koleksi
                </a>
                <a href="{{ route('public.virtual_tour') }}" class="btn btn-lg btn-ghost text-white border border-white/30 hover:bg-white/15 hover:border-white/50 backdrop-blur-sm gap-2" id="hero-cta-tour">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Virtual Tour 360°
                </a>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="animate-bounce-down mt-12 text-white/50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 2 — 4 BLOK FITUR UTAMA
     ============================================================ --}}
<section class="py-20 px-4 bg-base-100" id="features-section">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="section-heading text-center text-3xl md:text-4xl">Jelajahi Warisan Sitiwinangun</h2>
            <p class="text-base-content/60 max-w-2xl mx-auto mt-4">
                Empat pintu masuk untuk mengenal lebih dalam kekayaan budaya gerabah desa kami.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-children">
            {{-- Block 1: Warisan Gerabah --}}
            <a href="{{ route('public.history') }}" class="card bg-base-200 card-hover-lift group cursor-pointer animate-fade-in-up" id="feature-warisan">
                <div class="card-body items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 group-hover:scale-110 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="card-title text-lg font-serif">Warisan Gerabah</h3>
                    <p class="text-sm text-base-content/60 leading-relaxed">Sejarah panjang kriya gerabah sejak abad ke-15, warisan lintas generasi.</p>
                    <span class="text-primary text-sm font-medium group-hover:gap-2 inline-flex items-center gap-1 transition-all">
                        Baca Sejarah
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>

            {{-- Block 2: Dibuat dengan Tangan --}}
            <a href="{{ route('public.production') }}" class="card bg-base-200 card-hover-lift group cursor-pointer animate-fade-in-up" id="feature-produksi">
                <div class="card-body items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 group-hover:scale-110 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>
                    </div>
                    <h3 class="card-title text-lg font-serif">Dibuat dengan Tangan</h3>
                    <p class="text-sm text-base-content/60 leading-relaxed">5 tahap produksi dari tanah liat mentah hingga karya bernilai budaya.</p>
                    <span class="text-primary text-sm font-medium group-hover:gap-2 inline-flex items-center gap-1 transition-all">
                        Lihat Proses
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>

            {{-- Block 3: Kisah Pengrajin --}}
            <a href="{{ route('public.artisans.index') }}" class="card bg-base-200 card-hover-lift group cursor-pointer animate-fade-in-up" id="feature-pengrajin">
                <div class="card-body items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 group-hover:scale-110 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    </div>
                    <h3 class="card-title text-lg font-serif">Kisah Pengrajin</h3>
                    <p class="text-sm text-base-content/60 leading-relaxed">Mengenal maestro di balik setiap karya — kisah, dedikasi, dan harapan mereka.</p>
                    <span class="text-primary text-sm font-medium group-hover:gap-2 inline-flex items-center gap-1 transition-all">
                        Kenali Mereka
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>

            {{-- Block 4: Jelajah Desa --}}
            <a href="{{ route('public.virtual_tour') }}" class="card bg-base-200 card-hover-lift group cursor-pointer animate-fade-in-up" id="feature-jelajah">
                <div class="card-body items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 group-hover:scale-110 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                    </div>
                    <h3 class="card-title text-lg font-serif">Jelajah Desa</h3>
                    <p class="text-sm text-base-content/60 leading-relaxed">Virtual tour 360° menyusuri desa dan rumah produksi pengrajin gerabah.</p>
                    <span class="text-primary text-sm font-medium group-hover:gap-2 inline-flex items-center gap-1 transition-all">
                        Mulai Tur
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 3 — KOLEKSI UNGGULAN
     ============================================================ --}}
<section class="py-20 px-4 bg-base-200/50 bg-batik-pattern" id="featured-collections">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-12 gap-4">
            <div>
                <h2 class="section-heading text-3xl md:text-4xl">Koleksi Unggulan</h2>
                <p class="text-base-content/60 mt-4 max-w-lg">
                    Pilihan karya terbaik dari para pengrajin Sitiwinangun — setiap gerabah menyimpan cerita tentang tanah, tangan, dan tradisi.
                </p>
            </div>
            <a href="{{ route('public.collections.index') }}" class="btn btn-primary btn-outline btn-sm gap-1 shrink-0" id="cta-all-collections">
                Lihat Semua Koleksi
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        @if($featuredCollections->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger-children">
                @foreach($featuredCollections as $collection)
                    <a href="{{ route('public.collections.show', $collection->slug) }}"
                       class="card bg-base-100 shadow-sm card-hover-lift group animate-fade-in-up overflow-hidden"
                       id="collection-card-{{ $collection->id }}">
                        {{-- Image --}}
                        <figure class="relative overflow-hidden aspect-[4/3]">
                            @if($collection->photo_url)
                                <img src="{{ asset('storage/' . $collection->photo_url) }}"
                                     alt="{{ $collection->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                            @else
                                <div class="img-placeholder w-full h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif

                            {{-- Category badge --}}
                            @if($collection->category)
                                <div class="absolute top-3 left-3">
                                    <span class="badge badge-sm badge-primary text-primary-content font-medium shadow-sm">
                                        {{ $collection->category->name }}
                                    </span>
                                </div>
                            @endif
                        </figure>

                        <div class="card-body p-4 gap-2">
                            <h3 class="card-title text-base font-serif group-hover:text-primary transition-colors">
                                {{ $collection->name }}
                            </h3>
                            <div class="flex items-center justify-between text-xs text-base-content/50">
                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ $collection->artisan->name ?? '-' }}
                                </span>
                                <span>{{ $collection->year }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- Empty state --}}
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-base-300 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <p class="text-base-content/50">Koleksi sedang disiapkan. Nantikan segera!</p>
            </div>
        @endif
    </div>
</section>

{{-- ============================================================
     SECTION 4 — PENGRAJIN UNGGULAN
     ============================================================ --}}
<section class="py-20 px-4 bg-base-100" id="featured-artisans">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="section-heading text-center text-3xl md:text-4xl">Para Maestro Gerabah</h2>
            <p class="text-base-content/60 max-w-2xl mx-auto mt-4">
                Di balik setiap karya, ada tangan-tangan terampil yang menjaga tradisi. Kenali kisah mereka.
            </p>
        </div>

        @if($featuredArtisans->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-children">
                @foreach($featuredArtisans as $artisan)
                    <a href="{{ route('public.artisans.show', $artisan->id) }}"
                       class="card bg-base-200 card-hover-lift group animate-fade-in-up overflow-hidden"
                       id="artisan-card-{{ $artisan->id }}">
                        {{-- Photo --}}
                        <figure class="relative overflow-hidden aspect-[3/4]">
                            @if($artisan->photo_url)
                                <img src="{{ asset('storage/' . $artisan->photo_url) }}"
                                     alt="{{ $artisan->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                            @else
                                <div class="img-placeholder w-full h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif

                            {{-- Gradient overlay for text readability --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                            {{-- Name overlay --}}
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <h3 class="font-serif font-bold text-lg leading-tight">{{ $artisan->name }}</h3>
                                @if($artisan->specialty)
                                    <p class="text-white/70 text-xs mt-0.5">{{ $artisan->specialty }}</p>
                                @endif
                            </div>
                        </figure>

                        <div class="card-body p-4 gap-2">
                            {{-- Pull quote --}}
                            @if($artisan->quote)
                                <p class="text-sm italic text-base-content/60 leading-relaxed line-clamp-3">
                                    "{{ Str::limit($artisan->quote, 100) }}"
                                </p>
                            @endif

                            {{-- Years active --}}
                            @if($artisan->years_active)
                                <div class="flex items-center gap-1.5 text-xs text-base-content/40 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $artisan->years_active }}
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('public.artisans.index') }}" class="btn btn-outline btn-primary gap-2" id="cta-all-artisans">
                    Kenali Lebih Dekat
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        @else
            {{-- Empty state --}}
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-base-300 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-base-content/50">Profil pengrajin sedang disiapkan.</p>
            </div>
        @endif
    </div>
</section>

{{-- ============================================================
     SECTION 5 — CTA VIRTUAL TOUR
     ============================================================ --}}
<section class="relative overflow-hidden" id="cta-virtual-tour">
    <!-- Live 360° Panorama Background -->
    <div class="absolute inset-0 w-full h-full z-0">
        <iframe src="/marzipano/sitiwinangun/index.html?bg=1" class="w-full h-full border-0 pointer-events-auto" allow="fullscreen"></iframe>
        <!-- Dark gradient overlay to ensure text contrast and premium feel -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary/55 via-neutral/25 to-black/65 pointer-events-none"></div>
        <div class="absolute inset-0 bg-batik-kawung opacity-10 mix-blend-overlay pointer-events-none"></div>
    </div>

    <div class="py-24 px-4 relative z-10 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/10 px-4 py-1.5 rounded-full text-white/80 text-sm font-medium mb-6 backdrop-blur-sm border border-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                Pengalaman 360°
            </div>

            <h2 class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold text-white leading-tight mb-6 animate-fade-in">
                Jelajahi Desa Sitiwinangun<br>
                <span class="text-accent">dalam 360°</span>
            </h2>

            <p class="text-white/70 text-lg max-w-2xl mx-auto mb-8 leading-relaxed">
                Kunjungi rumah produksi, lihat suasana desa, dan rasakan atmosfer tempat lahirnya karya gerabah — tanpa perlu ke Cirebon.
            </p>

            @if($activeTour)
                {{-- Tour info badge --}}
                <div class="bg-black/20 backdrop-blur-sm rounded-2xl p-4 max-w-lg mx-auto mb-8 border border-white/10">
                    <div class="flex items-center gap-3 text-left">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold text-xs uppercase tracking-wider">Sedang Ditampilkan:</h4>
                            <p class="text-white/80 text-sm font-serif mt-0.5">{{ $activeTour->title }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <a href="{{ route('public.virtual_tour') }}" class="btn btn-lg bg-white text-primary hover:bg-white/90 border-0 shadow-xl gap-2" id="cta-start-tour">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Mulai Virtual Tour
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.hero-slide');
    if (!slides.length) return;

    const TOTAL = slides.length;
    const INTERVAL = 6000;  // 6 seconds per slide
    let current = 0;
    let timer = null;
    let isVisible = true;

    function goToSlide(index) {
        slides[current].classList.remove('active');
        current = index % TOTAL;
        const nextSlide = slides[current];

        // Restart Ken Burns animation on new slide
        const img = nextSlide.querySelector('img');
        if (img) {
            const anim = img.style.animation;
            img.style.animation = 'none';
            img.offsetHeight; // force reflow
            img.style.animation = anim || '';
        }

        nextSlide.classList.add('active');
    }

    function startSlideshow() {
        if (timer) return;
        timer = setInterval(() => {
            if (isVisible) goToSlide(current + 1);
        }, INTERVAL);
    }

    function stopSlideshow() {
        clearInterval(timer);
        timer = null;
    }

    // Pause when hero scrolls out of view
    const hero = document.getElementById('hero-section');
    if (hero && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(([entry]) => {
            isVisible = entry.isIntersecting;
            if (isVisible) startSlideshow();
            else stopSlideshow();
        }, { threshold: 0.15 });
        observer.observe(hero);
    }

    // Pause on tab hidden
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stopSlideshow();
        else if (isVisible) startSlideshow();
    });

    startSlideshow();
});
</script>
@endpush
