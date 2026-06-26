@extends('layouts.public')

@section('title', 'Jelajah Sitiwinangun — Peta Rumah Produksi Gerabah')
@section('meta_description', 'Peta lokasi rumah produksi gerabah Sitiwinangun. Temukan pengrajin, informasi kunjungan, dan aktivitas edukasi.')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    /* Fix Leaflet style conflict with daisyUI themes */
    .leaflet-popup-content-wrapper, .leaflet-popup-tip {
        background-color: var(--color-base-100, #fff) !important;
        color: var(--color-base-content, #000) !important;
        border: 1px solid oklch(38% 0.085 48 / 0.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .leaflet-container a.leaflet-popup-close-button {
        color: var(--color-base-content, #666) !important;
        font-weight: bold;
    }
</style>
@endpush

@section('content')

{{-- Header --}}
<section class="bg-base-200 bg-batik-pattern py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <span class="text-sm font-semibold uppercase tracking-wider text-primary">Jelajah Budaya</span>
        <h1 class="section-heading text-3xl md:text-4xl animate-fade-in-up">Jelajah Sitiwinangun</h1>
        <p class="text-base-content/60 max-w-2xl mt-4 animate-fade-in-up leading-relaxed" style="animation-delay:0.15s">
            Temukan lokasi rumah produksi, bengkel kriya, dan sanggar belajar pembuatan gerabah di seluruh penjuru Desa Sitiwinangun.
        </p>
    </div>
</section>

{{-- Peta & List --}}
<section class="py-12 px-4" x-data="{
    activeLocationId: null,
    panToLocation(lat, lng, id) {
        this.activeLocationId = id;
        if (window.leafletMap) {
            window.leafletMap.setView([lat, lng], 18, { animate: true, duration: 1.5 });
            if (window.mapMarkers && window.mapMarkers[id]) {
                window.mapMarkers[id].openPopup();
            }
        }
        if (window.innerWidth < 1024) {
            document.getElementById('map-container').scrollIntoView({ behavior: 'smooth' });
        }
    }
}">
    {{-- Reactive Theme Watcher using Alpine.js effect --}}
    <div x-effect="
        let isDark = $store.theme.current === 'batik-dark';
        if (window.updateLeafletTiles) {
            window.updateLeafletTiles(isDark);
        }
    "></div>

    <div class="max-w-7xl mx-auto">
        @if($locations->count())
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- List Lokasi --}}
                <div class="lg:col-span-5 flex flex-col gap-4 overflow-y-auto max-h-[600px] pr-2" id="locations-list">
                    @foreach($locations as $loc)
                        <div @click="panToLocation({{ $loc->latitude }}, {{ $loc->longitude }}, {{ $loc->id }})"
                             class="card bg-base-100 shadow-sm border cursor-pointer hover:border-primary/40 transition-all duration-300"
                             :class="activeLocationId === {{ $loc->id }} ? 'border-primary ring-2 ring-primary/10' : 'border-base-200/50'"
                             id="location-card-{{ $loc->id }}">
                            <div class="card-body p-5 gap-3">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-serif font-bold text-lg text-primary leading-snug">
                                        {{ $loc->name }}
                                    </h3>
                                    @if($loc->is_open_visit)
                                        <span class="badge badge-success badge-sm text-success-content font-medium flex-shrink-0">
                                            Menerima Kunjungan
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-base-content/60 flex items-start gap-1.5 leading-relaxed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/40 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $loc->address }}
                                </p>
                                <div class="divider my-0 opacity-50"></div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-base-content/75">
                                    @if($loc->main_products)
                                        <div>
                                            <span class="font-semibold block text-base-content">Produk Utama:</span>
                                            {{ $loc->main_products }}
                                        </div>
                                    @endif
                                    @if($loc->visit_capacity)
                                        <div>
                                            <span class="font-semibold block text-base-content">Kapasitas Kunjungan:</span>
                                            {{ $loc->visit_capacity }}
                                        </div>
                                    @endif
                                </div>
                                @if($loc->edu_activities)
                                    <div class="bg-base-200/50 p-2.5 rounded-box text-xs mt-1">
                                        <span class="font-semibold block text-base-content mb-0.5">Aktivitas Edukasi:</span>
                                        <span class="text-base-content/70 leading-relaxed">{{ $loc->edu_activities }}</span>
                                    </div>
                                @endif
                                @if($loc->phone)
                                    <div class="card-actions justify-end mt-2 pt-2 border-t border-base-200/30">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $loc->phone) }}" 
                                           target="_blank" 
                                           @click.stop 
                                           class="btn btn-xs btn-outline btn-accent gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            Hubungi Kontak
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Map Container --}}
                <div class="lg:col-span-7" id="map-container">
                    <div class="card bg-base-100 shadow-sm border border-base-200/50 overflow-hidden sticky top-24">
                        <div class="p-4 bg-base-100 border-b border-base-200/50 flex items-center justify-between">
                            <h3 class="font-serif text-lg font-bold text-primary">Peta Interaktif Rumah Produksi</h3>
                            <span class="text-xs text-base-content/50">Klik kartu di kiri untuk memfokuskan peta</span>
                        </div>
                        <div id="locations-map" class="w-full h-[500px] bg-base-200"></div>
                    </div>
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 bg-base-100 shadow-sm border border-base-200/50 rounded-box max-w-2xl mx-auto" id="empty-locations">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-base-200 flex items-center justify-center text-base-content/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-serif font-semibold text-base-content/70 mb-2">Lokasi Rumah Produksi Belum Tersedia</h3>
                <p class="text-base-content/50 max-w-md mx-auto">
                    Data sebaran rumah produksi dan tempat pelatihan gerabah sedang dikurasi oleh pihak pengurus.
                </p>
            </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
@if($locations->count())
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var centerLat = -6.718889;
        var centerLng = 108.552222;

        var map = L.map('locations-map').setView([centerLat, centerLng], 17);
        window.leafletMap = map;

        // Tile layer matching theme (light/dark)
        var isDark = document.documentElement.getAttribute('data-theme') === 'batik-dark';
        var tileUrl = isDark 
            ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
            : 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';

        L.tileLayer(tileUrl, {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
            maxZoom: 20
        }).addTo(map);

        // Track markers
        window.mapMarkers = {};

        var locations = @json($locations);
        
        locations.forEach(function(loc) {
            if (loc.latitude && loc.longitude) {
                var popupContent = `
                    <div class="text-sm font-sans p-1">
                        <h4 class="font-serif font-bold text-primary text-base" style="margin-bottom: 4px;">\${loc.name}</h4>
                        <p class="text-xs text-base-content/70" style="margin-bottom: 6px;">\${loc.address}</p>
                        \${loc.main_products ? `<p class="text-xs" style="margin-bottom: 2px;"><strong>Produk:</strong> \${loc.main_products}</p>` : ''}
                        \${loc.visit_capacity ? `<p class="text-xs" style="margin-bottom: 8px;"><strong>Kapasitas:</strong> \${loc.visit_capacity}</p>` : ''}
                        <a href="https://maps.google.com/?q=\${loc.latitude},\${loc.longitude}" target="_blank" class="btn btn-xs btn-primary text-white w-full text-center">Petunjuk Rute</a>
                    </div>
                `;
                var marker = L.marker([loc.latitude, loc.longitude]).addTo(map).bindPopup(popupContent);
                window.mapMarkers[loc.id] = marker;
            }
        });

        // Theme updater helper function called by x-effect watcher
        window.updateLeafletTiles = function(newIsDark) {
            var newTileUrl = newIsDark 
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
            
            map.eachLayer(function(layer) {
                if (layer instanceof L.TileLayer) {
                    map.removeLayer(layer);
                }
            });

            L.tileLayer(newTileUrl, {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
                maxZoom: 20
            }).addTo(map);
        };
    });
</script>
@endif
@endpush
