@extends('layouts.public')

@section('title', 'Virtual Tour 360° — Museum Digital Gerabah Sitiwinangun')
@section('meta_description', $tour ? Str::limit($tour->description, 150) : 'Jelajahi Desa Sitiwinangun dan rumah produksi gerabah dalam panorama 360° interaktif.')

@push('head')
    @if($tourConfig)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
        <style>
            /* Hide default Pannellum UI */
            .pnlm-controls-container { display: none !important; }
            .pnlm-compass { display: none !important; }
            .pnlm-panorama-info { display: none !important; }
            #sitiwinangun-panorama .pnlm-load-box { background: rgba(24, 15, 8, .72); border-radius: 1rem; }

            /* Allow inner hotspot div to overflow outer positioning container */
            #sitiwinangun-panorama .pnlm-hotspot-base {
                overflow: visible !important;
            }

            /* Google-Maps-style floor navigation circle
               NOTE: cssClass is applied to the INNER div (.pnlm-hotspot), not .pnlm-hotspot-base */
            .pnlm-hotspot.floor-nav-hotspot {
                background: rgba(255, 255, 255, 0.88) !important;
                border-radius: 50% !important;
                width: 52px !important;
                height: 52px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border: 3px solid rgba(18, 18, 18, 0.80) !important;
                box-shadow: 0 4px 18px rgba(0, 0, 0, 0.50), 0 1px 4px rgba(0,0,0,0.25) !important;
                cursor: pointer !important;
                position: relative !important;
                overflow: visible !important;
                transition: background 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease !important;
                /* Reset Pannellum default sprite styles */
                background-image: none !important;
                background-position: unset !important;
            }
            .pnlm-hotspot.floor-nav-hotspot:hover {
                background: rgba(255, 255, 255, 1) !important;
                border-color: rgba(0, 0, 0, 0.92) !important;
                box-shadow: 0 6px 28px rgba(0, 0, 0, 0.60), 0 2px 6px rgba(0,0,0,0.3) !important;
                transform: scale(1.14) !important;
            }
            .pnlm-hotspot.floor-nav-hotspot svg {
                color: rgba(20, 20, 20, 0.88);
                flex-shrink: 0;
                pointer-events: none;
            }
            /* Tooltip shown on hover */
            .pnlm-hotspot.floor-nav-hotspot .vt-hs-label {
                position: absolute;
                bottom: calc(100% + 10px);
                left: 50%;
                transform: translateX(-50%) translateY(5px);
                background: rgba(12, 8, 4, 0.86);
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
                color: #fef3c7;
                font-size: 0.68rem;
                font-weight: 600;
                padding: 4px 12px;
                border-radius: 999px;
                white-space: nowrap;
                opacity: 0;
                transition: opacity 0.2s ease, transform 0.2s ease;
                pointer-events: none;
                letter-spacing: 0.04em;
                border: 1px solid rgba(245, 158, 11, 0.40);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.45);
            }
            .pnlm-hotspot.floor-nav-hotspot:hover .vt-hs-label {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }

            /* Edge overlay navigation arrows */
            .vt-edge-arrow {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                z-index: 35;
                width: 52px;
                height: 52px;
                border-radius: 999px;
                background: rgba(0, 0, 0, 0.55);
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
                border: 2px solid rgba(255, 255, 255, 0.15);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                font-size: 1.4rem;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
                pointer-events: auto;
                opacity: 0.7;
            }
            .vt-edge-arrow:hover {
                opacity: 1;
                background: rgba(245, 158, 11, 0.85);
                border-color: rgba(245, 158, 11, 0.5);
                transform: translateY(-50%) scale(1.1);
                box-shadow: 0 6px 24px rgba(0, 0, 0, 0.4);
            }
            .vt-edge-arrow.prev { left: 8px; }
            .vt-edge-arrow.next { right: 8px; }

            /* Fullscreen fixes */
            #vt-shell:fullscreen .vt-edge-arrow {
                width: 64px;
                height: 64px;
                font-size: 1.8rem;
            }
            #vt-shell:fullscreen .vt-edge-arrow.prev { left: 20px; }
            #vt-shell:fullscreen .vt-edge-arrow.next { right: 20px; }
        </style>
    @endif
@endpush

@section('content')

<section class="bg-base-200 bg-batik-pattern py-16 px-4">
    <div class="max-w-6xl mx-auto text-center">
        <span class="text-sm font-semibold uppercase tracking-wider text-primary">Pengalaman Virtual 360°</span>
        <h1 class="section-heading text-center text-3xl md:text-4xl animate-fade-in-up">Jelajahi Sitiwinangun dalam 360°</h1>
        <p class="text-base-content/60 max-w-2xl mx-auto mt-4 leading-relaxed animate-fade-in-up" style="animation-delay:0.15s">
            @if($tour)
                {{ $tour->description }}
            @else
                Jelajahi desa wisata gerabah, rumah produksi, dan ruang kriya Sitiwinangun dari layar Anda.
            @endif
        </p>
    </div>
</section>

<section class="py-12 px-4" id="virtual-tour-section">
    <div class="max-w-7xl mx-auto">
        @if($tour && $tour->is_active && $tourConfig)
            <div
                x-data="virtualTour360()"
                x-init="init()"
                @fullscreenchange.window="isFullscreen = !!document.fullscreenElement"
                class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-6"
            >
                <div id="vt-shell" class="relative rounded-[1.5rem] overflow-hidden bg-[#130d08] shadow-2xl border border-amber-500/20 min-h-[360px] md:min-h-[620px] fullscreen:rounded-none fullscreen:border-0 fullscreen:shadow-none">
                    <div id="sitiwinangun-panorama" class="w-full h-[360px] md:h-[620px] fullscreen:h-screen"></div>

                    <div x-show="isLoading" x-transition.opacity class="absolute inset-0 z-20 flex items-center justify-center bg-[#130d08]/80 backdrop-blur-sm">
                        <div class="text-center">
                            <span class="loading loading-spinner loading-lg text-warning"></span>
                            <p class="mt-4 text-sm tracking-[.25em] uppercase text-amber-100/70">Memuat panorama</p>
                        </div>
                    </div>

                    <div class="absolute left-4 right-4 top-4 z-30 flex flex-wrap items-start justify-between gap-3 pointer-events-none">
                        <div class="rounded-2xl bg-black/55 backdrop-blur-md border border-white/10 px-4 py-3 text-white shadow-xl pointer-events-auto">
                            <p class="text-xs uppercase tracking-[.22em] text-amber-200/80">Lokasi aktif</p>
                            <p class="font-semibold" x-text="currentTitle"></p>
                        </div>
                        <div class="flex gap-2 pointer-events-auto">
                            <button type="button" @click="showSceneList = !showSceneList" class="btn btn-warning btn-sm btn-circle shadow-xl" title="Daftar Panorama">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            <button id="vt-fullscreen-btn" type="button" @click="toggleFullscreen()" class="btn btn-warning btn-sm rounded-full shadow-xl">
                                <span x-text="isFullscreen ? 'Keluar Fullscreen' : 'Layar Penuh'"></span>
                            </button>
                        </div>
                    </div>

                    <div x-show="showSceneList"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-x-2"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-2"
                         class="absolute left-4 top-20 bottom-20 z-40 w-[200px] overflow-y-auto rounded-2xl bg-black/85 backdrop-blur-md border border-white/20 p-3 shadow-2xl pointer-events-auto">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-bold text-xs uppercase tracking-wider">Panorama</h3>
                            <button @click="showSceneList = false" class="text-white/60 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <template x-for="scene in sceneList" :key="scene.id">
                                <button @click="loadScene(scene.id); showSceneList = false"
                                        :class="currentScene === scene.id ? 'bg-warning text-black' : 'bg-white/10 text-white hover:bg-white/20'"
                                        class="px-3 py-2.5 rounded-lg text-xs font-medium transition-colors flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate" x-text="scene.title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Floor hotspot arrows added dynamically via JS --}}

                    {{-- Edge overlay navigation arrows --}}
                    <button type="button" class="vt-edge-arrow prev" @click="goRelative(-1)" title="Sebelumnya" aria-label="Panorama sebelumnya">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="button" class="vt-edge-arrow next" @click="goRelative(1)" title="Selanjutnya" aria-label="Panorama selanjutnya">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    {{-- Floor hotspot info card (appears at bottom when a floor arrow is clicked) --}}
                    <div x-show="showInfoCard"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-3"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-3"
                         class="absolute bottom-5 left-1/2 -translate-x-1/2 z-40 pointer-events-auto"
                         style="min-width:270px;max-width:340px">
                        <div class="rounded-2xl bg-black/78 backdrop-blur-md border border-white/12 px-5 py-4 shadow-2xl text-center relative">
                            <button @click="showInfoCard = false"
                                    class="absolute top-2.5 right-3 text-white/40 hover:text-white transition-colors"
                                    aria-label="Tutup">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <p class="text-amber-400 font-bold text-sm tracking-wide mb-3" x-text="infoCardTitle"></p>
                            <div class="flex gap-2 justify-center">
                                <button @click="loadScene(infoCardPrevId); showInfoCard = false"
                                        class="flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition-colors border border-white/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Sebelumnya
                                </button>
                                <button @click="loadScene(infoCardNextId); showInfoCard = false"
                                        class="flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-amber-500/80 hover:bg-amber-400 text-black text-xs font-semibold transition-colors">
                                    Berikutnya
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-4 left-4 right-4 z-30 flex items-center justify-center pointer-events-none" x-show="!showInfoCard">
                        <div class="rounded-2xl bg-black/55 backdrop-blur-md border border-white/10 px-4 py-2.5 text-white/80 shadow-xl text-xs pointer-events-auto opacity-0 hover:opacity-100 transition-opacity duration-1000">
                            Drag/geser · Scroll/pinch zoom · ◄ ► di panorama · ← → keyboard
                        </div>
                    </div>                </div>
                </div>

                <aside class="space-y-4">
                    <div class="card bg-base-100 shadow-xl border border-base-300/70">
                        <div class="card-body">
                            <h2 class="card-title font-serif text-2xl">Titik Panorama</h2>
                            <p class="text-sm text-base-content/60">Pilih salah satu dari {{ count($tourConfig['scenes'] ?? []) }} titik dokumentasi 360°.</p>
                            <select id="vt-scene-select" class="select select-bordered w-full mt-2" x-model="currentScene" @change="loadScene(currentScene)">
                                <template x-for="scene in sceneList" :key="scene.id">
                                    <option :value="scene.id" x-text="scene.title"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div class="card bg-gradient-to-br from-primary to-neutral text-primary-content shadow-xl overflow-hidden">
                        <div class="card-body">
                            <span class="text-xs uppercase tracking-[.28em] text-primary-content/70 font-semibold">Dari Tanah Menjadi Warisan</span>
                            <h3 class="font-serif text-2xl font-bold">Tur Rumah Produksi & Desa</h3>
                            <p class="text-sm leading-relaxed text-primary-content/75">
                                Dokumentasi ini membantu pengunjung merasakan atmosfer ruang kerja kriya Sitiwinangun secara imersif sebelum berkunjung langsung.
                            </p>
                            <div class="stats stats-vertical bg-primary-content/10 text-primary-content mt-2">
                                <div class="stat py-3">
                                    <div class="stat-title text-primary-content/60">Panorama</div>
                                    <div class="stat-value text-2xl">{{ count($tourConfig['scenes'] ?? []) }}</div>
                                </div>
                                <div class="stat py-3">
                                    <div class="stat-title text-primary-content/60">Viewer</div>
                                    <div class="stat-value text-2xl">Pannellum</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        @elseif($tour && $tour->is_active && $tour->sanitized_code)
            {{-- Marzipano / iframe embed mode --}}
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-6">
                    {{-- Viewer --}}
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between gap-4 bg-accent/10 text-base-content px-4 py-3 rounded-2xl border border-accent/20 text-sm">
                            <p class="font-medium">🖱 Drag/geser untuk 360° · Scroll/pinch zoom · Klik ikon panah untuk berpindah lokasi</p>
                            <button
                                onclick="(function(){var el=document.getElementById('marzipano-frame-wrap');el.requestFullscreen?el.requestFullscreen():el.webkitRequestFullscreen&&el.webkitRequestFullscreen()})()"
                                class="btn btn-warning btn-sm rounded-full shrink-0"
                                id="marzipano-fullscreen-btn"
                            >⛶ Layar Penuh</button>
                        </div>
                        <div id="marzipano-frame-wrap"
                             class="relative w-full rounded-[1.5rem] overflow-hidden shadow-2xl border border-amber-500/20 bg-[#120b06]"
                             style="height: 400px;"
                        >
                            {{-- Loading overlay --}}
                            <div id="marzipano-loader"
                                 class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-[#120b06] gap-4"
                            >
                                <span class="loading loading-spinner loading-lg text-warning"></span>
                                <p class="text-xs tracking-[.25em] uppercase text-amber-100/60">Memuat virtual tour…</p>
                            </div>
                            <iframe
                                id="marzipano-iframe"
                                src="/marzipano/sitiwinangun/index.html"
                                width="100%"
                                height="100%"
                                frameborder="0"
                                allow="fullscreen"
                                allowfullscreen
                                title="Virtual Tour 360° Desa Sitiwinangun"
                                style="display:block;border:0;width:100%;height:100%;"
                                onload="document.getElementById('marzipano-loader').style.display='none'"
                            ></iframe>
                        </div>
                        <p class="text-xs text-base-content/45 text-center">Powered by Marzipano · <a href="/marzipano/sitiwinangun/index.html" target="_blank" class="underline hover:text-primary">Buka di tab baru ↗</a></p>
                    </div>

                    {{-- Info sidebar --}}
                    <aside class="space-y-4">
                        <div class="card bg-gradient-to-br from-primary to-neutral text-primary-content shadow-xl overflow-hidden">
                            <div class="card-body">
                                <span class="text-xs uppercase tracking-[.28em] text-primary-content/70 font-semibold">Dari Tanah Menjadi Warisan</span>
                                <h2 class="card-title font-serif text-xl">{{ $tour->title }}</h2>
                                <p class="text-sm leading-relaxed text-primary-content/75">{{ $tour->description }}</p>
                                <div class="stats stats-vertical bg-primary-content/10 text-primary-content mt-2">
                                    <div class="stat py-3">
                                        <div class="stat-title text-primary-content/60">Titik Panorama</div>
                                        <div class="stat-value text-2xl">31</div>
                                    </div>
                                    <div class="stat py-3">
                                        <div class="stat-title text-primary-content/60">Viewer</div>
                                        <div class="stat-value text-2xl">Marzipano</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-base-100 shadow-md border border-base-300/50">
                            <div class="card-body">
                                <h3 class="font-bold text-sm text-base-content/70 uppercase tracking-wider mb-2">Rute Tour</h3>
                                <ul class="text-sm space-y-1.5 text-base-content/80">
                                    <li class="flex items-center gap-2"><span class="text-amber-500">📍</span> Kampung Gerabah (Start)</li>
                                    <li class="flex items-center gap-2"><span class="text-amber-500">🏺</span> Pengrajin 1, 2, 3 &amp; 4</li>
                                    <li class="flex items-center gap-2"><span class="text-amber-500">🕌</span> Masjid Keramat Sitiwinangun</li>
                                </ul>
                                <a href="/marzipano/sitiwinangun/index.html" target="_blank" class="btn btn-outline btn-primary btn-sm mt-4 w-full">
                                    Buka Fullscreen ↗
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
            <script>
            // Auto-resize Marzipano iframe to fill viewport height better
            (function() {
                var wrap = document.getElementById('marzipano-frame-wrap');
                if (!wrap) return;
                function resize() {
                    var h = Math.max(400, Math.min(window.innerHeight - 260, 720));
                    wrap.style.height = h + 'px';
                }
                resize();
                window.addEventListener('resize', resize);
            })();
            </script>
        @else
            <div class="card bg-base-100 shadow-md border border-base-200/50 p-8 md:p-12 text-center max-w-2xl mx-auto" id="fallback-tour">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-base-200 flex items-center justify-center text-base-content/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-base-content/80 mb-3">Virtual Tour Belum Tersedia</h3>
                <p class="text-base-content/60 leading-relaxed mb-8">
                    Pihak pengelola museum sedang mempersiapkan panorama interaktif 360° Desa Sitiwinangun.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                    <a href="{{ route('public.collections.index') }}" class="btn btn-outline btn-primary">Galeri Produk Kriya</a>
                    <a href="{{ route('public.artisans.index') }}" class="btn btn-outline btn-accent">Kisah Para Pengrajin</a>
                </div>
            </div>
        @endif
    </div>
</section>

@if($tourConfig)
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
    <script>
        function virtualTour360() {
            return {
                viewer: null,
                isFullscreen: false,
                isLoading: true,
                showSceneList: false,
                config: @json($tourConfig),
                sceneList: [],
                currentScene: null,
                currentTitle: 'Memuat...',
                STORAGE_KEY: 'sitiwinangun_vt_last_scene',
                // Floor hotspot info card
                showInfoCard: false,
                infoCardTitle: '',
                infoCardPrevId: null,
                infoCardNextId: null,

                init() {
                    this.sceneList = Object.entries(this.config.scenes || {}).map(([id, scene]) => ({
                        id,
                        title: scene.title || id,
                    }));

                    // Restore last visited scene from localStorage, fallback to default first scene
                    const savedScene = this.savedScene();
                    this.currentScene = savedScene && this.sceneList.some((s) => s.id === savedScene)
                        ? savedScene
                        : (this.config.default?.firstScene || this.sceneList[0]?.id);
                    this.currentTitle = this.sceneList.find((scene) => scene.id === this.currentScene)?.title || 'Panorama';

                    // Inject floor navigation hotspots (Street-View style arrows on the panorama floor)
                    this.sceneList.forEach((scene, index) => {
                        const prevIdx = (index - 1 + this.sceneList.length) % this.sceneList.length;
                        const nextIdx = (index + 1) % this.sceneList.length;
                        const prevId  = this.sceneList[prevIdx].id;
                        const nextId  = this.sceneList[nextIdx].id;
                        const prevTitle = this.sceneList[prevIdx].title;
                        const nextTitle = this.sceneList[nextIdx].title;

                        if (this.config.scenes[scene.id]) {
                            this.config.scenes[scene.id].hotSpotDebug = false;
                            this.config.scenes[scene.id].hotSpots = [
                                {
                                    // Previous scene — floor-left
                                    pitch: -50,
                                    yaw: -25,
                                    type: 'info',
                                    cssClass: 'floor-nav-hotspot',
                                    createTooltipFunc: (div) => {
                                        // Inline styles — bypass Pannellum sprite CSS completely
                                        Object.assign(div.style, {
                                            background: 'rgba(255,255,255,0.90)',
                                            backgroundImage: 'none',
                                            borderRadius: '50%',
                                            width: '54px',
                                            height: '54px',
                                            display: 'flex',
                                            alignItems: 'center',
                                            justifyContent: 'center',
                                            border: '3px solid rgba(20,20,20,0.75)',
                                            boxShadow: '0 4px 20px rgba(0,0,0,0.50)',
                                            cursor: 'pointer',
                                            position: 'relative',
                                            overflow: 'visible',
                                            transition: 'all 0.18s ease',
                                        });
                                        div.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(20,20,20,0.85)" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 15 12 9 18 15"/></svg>';
                                        div.addEventListener('mouseenter', () => {
                                            div.style.background = 'rgba(255,255,255,1)';
                                            div.style.transform = 'scale(1.14)';
                                            div.style.boxShadow = '0 6px 28px rgba(0,0,0,0.65)';
                                        });
                                        div.addEventListener('mouseleave', () => {
                                            div.style.background = 'rgba(255,255,255,0.90)';
                                            div.style.transform = '';
                                            div.style.boxShadow = '0 4px 20px rgba(0,0,0,0.50)';
                                        });
                                    },
                                    clickHandlerFunc: () => {
                                        this.infoCardTitle = prevTitle;
                                        this.infoCardPrevId = prevId;
                                        this.infoCardNextId = nextId;
                                        this.showInfoCard = true;
                                    },
                                },
                                {
                                    // Next scene — floor-right
                                    pitch: -50,
                                    yaw: 25,
                                    type: 'info',
                                    cssClass: 'floor-nav-hotspot',
                                    createTooltipFunc: (div) => {
                                        Object.assign(div.style, {
                                            background: 'rgba(255,255,255,0.90)',
                                            backgroundImage: 'none',
                                            borderRadius: '50%',
                                            width: '54px',
                                            height: '54px',
                                            display: 'flex',
                                            alignItems: 'center',
                                            justifyContent: 'center',
                                            border: '3px solid rgba(20,20,20,0.75)',
                                            boxShadow: '0 4px 20px rgba(0,0,0,0.50)',
                                            cursor: 'pointer',
                                            position: 'relative',
                                            overflow: 'visible',
                                            transition: 'all 0.18s ease',
                                        });
                                        div.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(20,20,20,0.85)" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 15 12 9 18 15"/></svg>';
                                        div.addEventListener('mouseenter', () => {
                                            div.style.background = 'rgba(255,255,255,1)';
                                            div.style.transform = 'scale(1.14)';
                                            div.style.boxShadow = '0 6px 28px rgba(0,0,0,0.65)';
                                        });
                                        div.addEventListener('mouseleave', () => {
                                            div.style.background = 'rgba(255,255,255,0.90)';
                                            div.style.transform = '';
                                            div.style.boxShadow = '0 4px 20px rgba(0,0,0,0.50)';
                                        });
                                    },
                                    clickHandlerFunc: () => {
                                        this.infoCardTitle = nextTitle;
                                        this.infoCardPrevId = prevId;
                                        this.infoCardNextId = nextId;
                                        this.showInfoCard = true;
                                    },
                                },
                            ];
                        }
                    });

                    this.viewer = pannellum.viewer('sitiwinangun-panorama', this.config);
                    this.viewer.on('load', () => {
                        this.isLoading = false;
                        this.currentScene = this.viewer.getScene();
                        this.currentTitle = this.sceneList.find((scene) => scene.id === this.currentScene)?.title || 'Panorama';
                    });
                    this.viewer.on('scenechange', (sceneId) => {
                        this.isLoading = true;
                        this.currentScene = sceneId;
                        this.currentTitle = this.sceneList.find((scene) => scene.id === sceneId)?.title || 'Panorama';
                        this.persistScene(sceneId);
                    });

                    // Keyboard navigation: left/right arrow keys
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'ArrowLeft') {
                            this.goRelative(-1);
                        } else if (e.key === 'ArrowRight') {
                            this.goRelative(1);
                        }
                    });
                },
                savedScene() {
                    try {
                        return localStorage.getItem(this.STORAGE_KEY);
                    } catch {
                        return null;
                    }
                },
                persistScene(sceneId) {
                    try {
                        localStorage.setItem(this.STORAGE_KEY, sceneId);
                    } catch {
                        // localStorage unavailable — silently ignore
                    }
                },
                loadScene(sceneId) {
                    if (!this.viewer || !sceneId) return;
                    this.isLoading = true;
                    this.viewer.loadScene(sceneId);
                },
                goRelative(offset) {
                    const index = this.sceneList.findIndex((scene) => scene.id === this.currentScene);
                    if (index === -1) return;
                    const next = (index + offset + this.sceneList.length) % this.sceneList.length;
                    this.loadScene(this.sceneList[next].id);
                },
                toggleFullscreen() {
                    const elem = document.getElementById('vt-shell');
                    if (!elem) return;
                    if (!document.fullscreenElement) {
                        elem.requestFullscreen?.();
                    } else {
                        document.exitFullscreen?.();
                    }
                },
            };
        }
    </script>
@endpush
@endif

@endsection
