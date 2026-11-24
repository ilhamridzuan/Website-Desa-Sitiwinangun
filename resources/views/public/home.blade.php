@extends('layouts.public')

@section('title', 'Museum Digital Gerabah Sitiwinangun | Dari Tanah Menjadi Warisan')
@section('meta_description', 'Museum digital gerabah Desa Sitiwinangun, Cirebon. Jelajahi koleksi kriya, kisah pengrajin, 7 tahap proses produksi, dan virtual tour 360 derajat desa gerabah bersejarah.')

@section('content')

{{-- ============================================================
     SECTION 1: HERO
     ============================================================ --}}
<section class="hero-photo min-h-[85vh] relative overflow-hidden" id="hero-section">
    {{-- Slideshow Background Images --}}
    <div class="hero-slideshow absolute inset-0" aria-hidden="true">
        @foreach($heroSlides as $index => $slide)
            <div class="hero-slide absolute inset-0 {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index + 1 }}">
                <img src="{{ asset($slide['src']) }}"
                     alt="{{ $slide['alt'] }}"
                     width="1600"
                     height="1067"
                     class="w-full h-full object-cover object-center"
                     @if($index === 0) fetchpriority="high" @else loading="lazy" @endif>
            </div>
        @endforeach
    </div>

    {{-- Scrim Overlay for WCAG AA text readability across bright and dark photos --}}
    <div class="absolute inset-0 z-[2] bg-gradient-to-t from-black/75 via-black/45 to-black/30"></div>

    {{-- Hero Content --}}
    <div class="hero-content w-full max-w-none text-center relative z-10 flex-col items-center justify-center min-h-[85vh] pb-20 pt-28 px-4">
        <div class="max-w-3xl mx-auto">
            {{-- Main heading --}}
            <h1 class="animate-fade-in-up text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-serif font-bold text-white leading-[1.1] tracking-tight hero-text-shadow">
                Dari Tanah<br>
                <span class="text-accent hero-accent-glow">Menjadi Warisan</span>
            </h1>

            {{-- Subheading --}}
            <p class="animate-fade-in-up py-6 text-lg md:text-xl text-white/95 max-w-xl mx-auto leading-relaxed hero-text-shadow-sm" style="animation-delay: 0.15s">
                Museum Digital Gerabah Desa Sitiwinangun, Cirebon. Menyimpan cerita tanah, tangan pengrajin, dan tradisi kriya sejak abad ke-15.
            </p>

            {{-- CTA Buttons --}}
            <div class="animate-fade-in-up flex flex-wrap gap-3 justify-center" style="animation-delay: 0.25s">
                <a href="{{ route('public.collections.index') }}" class="btn btn-lg bg-white text-primary hover:bg-white/90 border-0 shadow-xl shadow-black/20 gap-2 min-h-[48px]" id="hero-cta-galeri">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Lihat Galeri Koleksi
                </a>
                <a href="{{ route('public.virtual_tour') }}" class="btn btn-lg bg-black/45 text-white border border-white/40 hover:bg-black/65 hover:border-white/70 backdrop-blur-xs gap-2 min-h-[48px]" id="hero-cta-tour">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Buka Virtual Tour 360°
                </a>
            </div>
        </div>
    </div>

    {{-- Accessible Slideshow Controls (R-39: pause control for motion > 5s) --}}
    @if(count($heroSlides) > 1)
        <div class="absolute bottom-5 right-4 sm:right-6 z-20 flex items-center gap-2">
            <span id="hero-slide-counter"
                  class="rounded-md bg-black/60 text-white/90 text-xs font-medium px-2.5 py-2 tabular-nums border border-white/15"
                  aria-live="off">
                1 / {{ count($heroSlides) }}
            </span>
            <button type="button"
                    id="hero-slideshow-toggle"
                    aria-pressed="false"
                    aria-label="Jeda pergantian foto latar"
                    class="inline-flex items-center gap-1.5 rounded-md bg-black/60 hover:bg-black/80 text-white text-xs font-medium px-3 py-2 min-h-[44px] border border-white/20 cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-colors">
                <svg id="hero-icon-pause" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6"/>
                </svg>
                <svg id="hero-icon-play" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-5.197-3.03A1 1 0 008 9.03v5.94a1 1 0 001.555.832l5.197-3.03a1 1 0 000-1.664z"/>
                </svg>
                <span id="hero-toggle-label">Jeda</span>
            </button>
        </div>
    @endif
</section>

{{-- ============================================================
     SECTION 2: 4 BLOK FITUR UTAMA
     ============================================================ --}}
<section class="py-20 px-4 bg-base-100" id="features-section">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="section-heading text-center text-3xl md:text-4xl">Telusuri Warisan Sitiwinangun</h2>
            <p class="text-base-content/70 max-w-2xl mx-auto mt-4">
                Empat pintu masuk untuk mengenal sejarah, cara kerja, pengrajin, dan suasana desa gerabah kami.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-children">
            {{-- Block 1: Warisan Gerabah --}}
            <a href="{{ route('public.storytelling') }}" class="card bg-base-200 card-hover-lift group cursor-pointer animate-fade-in-up" id="feature-warisan">
                <div class="card-body items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="card-title text-lg font-serif">Warisan Gerabah</h3>
                    <p class="text-sm text-base-content/70 leading-relaxed">Sejarah kriya gerabah sejak abad ke-15, motif pesisir, dan kearifan lokal warga desa.</p>
                    <span class="text-primary text-sm font-medium inline-flex items-center gap-1">
                        Baca Kisah Kriya
                    </span>
                </div>
            </a>

            {{-- Block 2: Dibuat dengan Tangan --}}
            <a href="{{ route('public.production') }}" class="card bg-base-200 card-hover-lift group cursor-pointer animate-fade-in-up" id="feature-produksi">
                <div class="card-body items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M9 20h6" />
                            <path d="M9 4h6" />
                            <path d="M10 4v4c-2 1-3.5 3-3.5 5.5S8 19 12 19s5.5-3 5.5-5.5S14 9 12 8V4" />
                        </svg>
                    </div>
                    <h3 class="card-title text-lg font-serif">Dibuat dengan Tangan</h3>
                    <p class="text-sm text-base-content/70 leading-relaxed">7 tahap produksi dari pengolahan tanah liat hingga pembakaran terbuka.</p>
                    <span class="text-primary text-sm font-medium inline-flex items-center gap-1">
                        Lihat 7 Tahap
                    </span>
                </div>
            </a>

            {{-- Block 3: Kisah Pengrajin --}}
            <a href="{{ route('public.artisans.index') }}" class="card bg-base-200 card-hover-lift group cursor-pointer animate-fade-in-up" id="feature-pengrajin">
                <div class="card-body items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    </div>
                    <h3 class="card-title text-lg font-serif">Kisah Pengrajin</h3>
                    <p class="text-sm text-base-content/70 leading-relaxed">Profil pengrajin yang menekuni kriya gerabah di bengkel-bengkel Sitiwinangun.</p>
                    <span class="text-primary text-sm font-medium inline-flex items-center gap-1">
                        Kenali Pengrajin
                    </span>
                </div>
            </a>

            {{-- Block 4: Jelajah Desa --}}
            <a href="{{ route('public.virtual_tour') }}" class="card bg-base-200 card-hover-lift group cursor-pointer animate-fade-in-up" id="feature-jelajah">
                <div class="card-body items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                    </div>
                    <h3 class="card-title text-lg font-serif">Jelajah Desa</h3>
                    <p class="text-sm text-base-content/70 leading-relaxed">Virtual tour 360° menyusuri jalan desa dan rumah produksi pengrajin gerabah.</p>
                    <span class="text-primary text-sm font-medium inline-flex items-center gap-1">
                        Mulai Tur 360°
                    </span>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 3: KOLEKSI UNGGULAN
     ============================================================ --}}
<section class="py-20 px-4 bg-base-200/50 bg-batik-pattern" id="featured-collections">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-12 gap-4">
            <div>
                <h2 class="section-heading text-3xl md:text-4xl">Koleksi Unggulan</h2>
                <p class="text-base-content/70 mt-4 max-w-lg">
                    Pilihan karya gerabah terbaru dari para pengrajin Desa Sitiwinangun, mulai dari perkakas dapur hingga patung terakota.
                </p>
            </div>
            <a href="{{ route('public.collections.index') }}" class="btn btn-primary btn-outline btn-sm min-h-[44px] gap-1 shrink-0" id="cta-all-collections">
                Lihat Semua Koleksi
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
                                     width="800"
                                     height="600"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                            @else
                                <div class="img-placeholder w-full h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
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
                            <div class="flex items-center justify-between text-xs text-base-content/65">
                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <p class="text-base-content/65">Belum ada koleksi yang dipublikasikan.</p>
            </div>
        @endif
    </div>
</section>

{{-- ============================================================
     SECTION 4: PENGRAJIN UNGGULAN
     ============================================================ --}}
<section class="py-20 px-4 bg-base-100" id="featured-artisans">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="section-heading text-center text-3xl md:text-4xl">Pengrajin Desa Sitiwinangun</h2>
            <p class="text-base-content/70 max-w-2xl mx-auto mt-4">
                Mengenal para pengrajin yang menjaga tradisi gerabah Cirebon di bengkel kerja mereka masing-masing.
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
                                     width="600"
                                     height="800"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                            @else
                                <div class="img-placeholder w-full h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/15" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif

                            {{-- Gradient overlay for text readability --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/15 to-transparent"></div>

                            {{-- Name overlay --}}
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <h3 class="font-serif font-bold text-lg leading-tight">{{ $artisan->name }}</h3>
                                @if($artisan->specialty)
                                    <p class="text-white/85 text-xs mt-0.5">{{ $artisan->specialty }}</p>
                                @endif
                            </div>
                        </figure>

                        <div class="card-body p-4 gap-2">
                            {{-- Pull quote --}}
                            @if($artisan->quote)
                                <p class="text-sm italic text-base-content/70 leading-relaxed line-clamp-3">
                                    "{{ Str::limit($artisan->quote, 100) }}"
                                </p>
                            @endif

                            {{-- Years active --}}
                            @if($artisan->years_active)
                                <div class="flex items-center gap-1.5 text-xs text-base-content/60 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $artisan->years_active }}
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('public.artisans.index') }}" class="btn btn-outline btn-primary min-h-[44px] gap-2" id="cta-all-artisans">
                    Lihat Semua Pengrajin
                </a>
            </div>
        @else
            {{-- Empty state --}}
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-base-300 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-base-content/65">Profil pengrajin belum tersedia.</p>
            </div>
        @endif
    </div>
</section>

{{-- ============================================================
     SECTION 5: CTA VIRTUAL TOUR
     ============================================================ --}}
<section class="relative overflow-hidden" id="cta-virtual-tour">
    {{-- Live 360 Panorama Background --}}
    <div class="absolute inset-0 w-full h-full z-0">
        <iframe src="/marzipano/sitiwinangun/index.html?bg=1" title="Pratinjau panorama 360 derajat Desa Sitiwinangun" class="w-full h-full border-0 pointer-events-auto" allow="fullscreen"></iframe>
        <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/45 to-black/75 pointer-events-none"></div>
        <div class="absolute inset-0 bg-batik-kawung opacity-10 mix-blend-overlay pointer-events-none"></div>
    </div>

    <div class="py-24 px-4 relative z-10 text-center">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold text-white leading-tight mb-6">
                Jelajahi Desa Sitiwinangun<br>
                <span class="text-accent">dalam 360°</span>
            </h2>

            <p class="text-white/90 text-lg max-w-2xl mx-auto mb-8 leading-relaxed">
                Kunjungi rumah produksi, lihat suasana desa, dan rasakan lingkungan tempat lahirnya karya gerabah Cirebon secara interaktif dari layar Anda.
            </p>

            @if($activeTour)
                <div class="bg-black/40 backdrop-blur-xs rounded-2xl p-4 max-w-lg mx-auto mb-8 border border-white/15">
                    <div class="flex items-center gap-3 text-left">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-xs uppercase tracking-wider">Tur Aktif</h3>
                            <p class="text-white/90 text-sm font-serif mt-0.5">{{ $activeTour->title }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <a href="{{ route('public.virtual_tour') }}" class="btn btn-lg bg-white text-primary hover:bg-white/90 border-0 shadow-xl gap-2 min-h-[48px]" id="cta-start-tour">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
    if (slides.length < 2) return;

    const TOTAL = slides.length;
    const INTERVAL = 6000;
    const counter = document.getElementById('hero-slide-counter');
    const toggleBtn = document.getElementById('hero-slideshow-toggle');
    const toggleLabel = document.getElementById('hero-toggle-label');
    const iconPause = document.getElementById('hero-icon-pause');
    const iconPlay = document.getElementById('hero-icon-play');
    const prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const hero = document.getElementById('hero-section');
    let current = 0;
    let timer = null;
    let isVisible = true;
    let userPaused = prefersReducedMotion;

    function syncPausedClass() {
        if (hero) {
            hero.classList.toggle('hero-paused', userPaused || !isVisible || document.hidden);
        }
    }

    function updateToggleUi() {
        syncPausedClass();
        if (!toggleBtn) return;
        toggleBtn.setAttribute('aria-pressed', userPaused ? 'true' : 'false');
        toggleBtn.setAttribute('aria-label', userPaused ? 'Putar pergantian foto latar' : 'Jeda pergantian foto latar');
        if (toggleLabel) toggleLabel.textContent = userPaused ? 'Putar' : 'Jeda';
        if (iconPause) iconPause.classList.toggle('hidden', userPaused);
        if (iconPlay) iconPlay.classList.toggle('hidden', !userPaused);
    }

    function goToSlide(index) {
        slides[current].classList.remove('active');
        current = index % TOTAL;
        const nextSlide = slides[current];

        if (!prefersReducedMotion) {
            const img = nextSlide.querySelector('img');
            if (img) {
                const anim = img.style.animation;
                img.style.animation = 'none';
                img.offsetHeight;
                img.style.animation = anim || '';
            }
        }

        nextSlide.classList.add('active');
        if (counter) counter.textContent = `${current + 1} / ${TOTAL}`;
    }

    function startSlideshow() {
        syncPausedClass();
        if (timer || userPaused) return;
        timer = setInterval(() => {
            if (isVisible && !userPaused) goToSlide(current + 1);
        }, INTERVAL);
    }

    function stopSlideshow() {
        clearInterval(timer);
        timer = null;
        syncPausedClass();
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            userPaused = !userPaused;
            updateToggleUi();
            if (userPaused) {
                stopSlideshow();
            } else {
                goToSlide(current + 1);
                startSlideshow();
            }
        });
    }

    if (hero && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(([entry]) => {
            isVisible = entry.isIntersecting;
            if (isVisible && !userPaused) startSlideshow();
            else stopSlideshow();
        }, { threshold: 0.15 });
        observer.observe(hero);
    }

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stopSlideshow();
        else if (isVisible && !userPaused) startSlideshow();
    });

    updateToggleUi();
    startSlideshow();
});
</script>
@endpush
