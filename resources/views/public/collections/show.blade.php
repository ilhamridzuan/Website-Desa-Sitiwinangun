@extends('layouts.public')

@section('title', $collection->name . ' — Museum Digital Gerabah Sitiwinangun')
@section('meta_description', Str::limit($collection->description, 155))
@section('og_title', $collection->name . ' | Koleksi Gerabah Sitiwinangun')
@if($collection->photo_url)
    @section('og_image', asset('storage/' . $collection->photo_url))
@endif

@section('content')

{{-- Breadcrumb --}}
<div class="bg-base-200/50 border-b border-base-300/50 py-3 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="breadcrumbs text-sm">
            <ul>
                <li><a href="{{ route('home') }}" class="text-base-content/50 hover:text-primary">Beranda</a></li>
                <li><a href="{{ route('public.collections.index') }}" class="text-base-content/50 hover:text-primary">Galeri</a></li>
                <li class="text-primary font-medium">{{ Str::limit($collection->name, 40) }}</li>
            </ul>
        </div>
    </div>
</div>

{{-- Main Content --}}
<section class="py-10 px-4" id="collection-detail"
         x-data="{ lightboxOpen: false, activeTab: 'sejarah' }">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">

            {{-- ==========================================
                 LEFT COLUMN — Photo + Quick Info (2/5)
                 ========================================== --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Main Photo --}}
                <div class="relative group cursor-pointer rounded-xl overflow-hidden shadow-md"
                     @click="lightboxOpen = true"
                     id="main-photo">
                    <figure class="aspect-[4/3] overflow-hidden">
                        @if($collection->photo_url)
                            <img src="{{ asset('storage/' . $collection->photo_url) }}"
                                 alt="{{ $collection->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="img-placeholder w-full h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif

                        {{-- Zoom overlay --}}
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="bg-white/90 rounded-full p-3 shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                </div>
                            </div>
                        </div>
                    </figure>
                </div>

                {{-- Quick Info Cards --}}
                <div class="space-y-3">
                    {{-- Category --}}
                    @if($collection->category)
                        <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                            <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $collection->category->color_hex ?? '#6B3D14' }}"></div>
                            <div>
                                <span class="text-xs text-base-content/40">Kategori</span>
                                <p class="text-sm font-medium">{{ $collection->category->name }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Artisan --}}
                    @if($collection->artisan)
                        <a href="{{ route('public.artisans.show', $collection->artisan->id) }}"
                           class="flex items-center gap-3 p-3 bg-base-200 rounded-lg hover:bg-base-300 transition-colors group"
                           id="artisan-link">
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-base-300 flex-shrink-0">
                                @if($collection->artisan->photo_url)
                                    <img src="{{ asset('storage/' . $collection->artisan->photo_url) }}"
                                         alt="{{ $collection->artisan->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-xs text-base-content/40">Pengrajin</span>
                                <p class="text-sm font-medium group-hover:text-primary transition-colors">{{ $collection->artisan->name }}</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/30 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif

                    {{-- Year & Location --}}
                    @if($collection->year || $collection->location)
                        <div class="grid grid-cols-2 gap-3">
                            @if($collection->year)
                                <div class="p-3 bg-base-200 rounded-lg">
                                    <span class="text-xs text-base-content/40">Tahun</span>
                                    <p class="text-sm font-medium">{{ $collection->year }}</p>
                                </div>
                            @endif
                            @if($collection->location)
                                <div class="p-3 bg-base-200 rounded-lg">
                                    <span class="text-xs text-base-content/40">Lokasi</span>
                                    <p class="text-sm font-medium truncate">{{ $collection->location }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Materials --}}
                    @if($collection->materials)
                        <div class="p-3 bg-base-200 rounded-lg">
                            <span class="text-xs text-base-content/40">Bahan</span>
                            <p class="text-sm font-medium">{{ $collection->materials }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ==========================================
                 RIGHT COLUMN — Title + Tabs Content (3/5)
                 ========================================== --}}
            <div class="lg:col-span-3">
                {{-- Title --}}
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-serif font-bold text-primary leading-tight mb-2" id="collection-title">
                    {{ $collection->name }}
                </h1>

                {{-- Description --}}
                @if($collection->description)
                    <p class="text-base-content/60 leading-relaxed mb-8">
                        {{ $collection->description }}
                    </p>
                @endif

                {{-- Tabs --}}
                <div class="tabs tabs-bordered mb-6" role="tablist" id="detail-tabs">
                    <button class="tab" :class="activeTab === 'sejarah' && 'tab-active font-semibold'"
                            @click="activeTab = 'sejarah'" role="tab">
                        Sejarah & Asal-Usul
                    </button>
                    <button class="tab" :class="activeTab === 'teknik' && 'tab-active font-semibold'"
                            @click="activeTab = 'teknik'" role="tab">
                        Teknik Produksi
                    </button>
                    @if($collection->philosophy)
                        <button class="tab" :class="activeTab === 'filosofi' && 'tab-active font-semibold'"
                                @click="activeTab = 'filosofi'" role="tab">
                            Makna Filosofis
                        </button>
                    @endif
                </div>

                {{-- Tab Content --}}
                <div class="min-h-[200px]">
                    {{-- Sejarah Tab --}}
                    <div x-show="activeTab === 'sejarah'" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        @if($collection->history_origin)
                            <div class="prose-batik">
                                {!! nl2br(e($collection->history_origin)) !!}
                            </div>
                        @else
                            <div class="text-center py-10">
                                <p class="text-base-content/40 italic">Narasi sejarah koleksi ini sedang disiapkan.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Teknik Tab --}}
                    <div x-show="activeTab === 'teknik'" x-cloak x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        @if($collection->technique)
                            <div class="prose-batik">
                                {!! nl2br(e($collection->technique)) !!}
                            </div>
                        @else
                            <div class="text-center py-10">
                                <p class="text-base-content/40 italic">Informasi teknik produksi sedang disiapkan.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Filosofi Tab --}}
                    @if($collection->philosophy)
                        <div x-show="activeTab === 'filosofi'" x-cloak x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                            <div class="prose-batik">
                                {!! nl2br(e($collection->philosophy)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ==========================================
             RELATED COLLECTIONS
             ========================================== --}}
        @if($related->count())
            <div class="mt-16 pt-12 border-t border-base-300/50" id="related-collections">
                <h2 class="section-heading text-2xl mb-8">Koleksi Serupa</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($related as $relatedItem)
                        <a href="{{ route('public.collections.show', $relatedItem->slug) }}"
                           class="card bg-base-100 shadow-sm card-hover-lift group overflow-hidden"
                           id="related-{{ $relatedItem->id }}">
                            <figure class="relative overflow-hidden aspect-[4/3]">
                                @if($relatedItem->photo_url)
                                    <img src="{{ asset('storage/' . $relatedItem->photo_url) }}"
                                         alt="{{ $relatedItem->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         loading="lazy">
                                @else
                                    <div class="img-placeholder w-full h-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                @if($relatedItem->category)
                                    <div class="absolute top-3 left-3">
                                        <span class="badge badge-sm text-white font-medium shadow-sm"
                                              style="background-color: {{ $relatedItem->category->color_hex ?? '#6B3D14' }}">
                                            {{ $relatedItem->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </figure>
                            <div class="card-body p-4 gap-1">
                                <h3 class="card-title text-sm font-serif group-hover:text-primary transition-colors">{{ $relatedItem->name }}</h3>
                                <span class="text-xs text-base-content/40">{{ $relatedItem->artisan->name ?? '' }} · {{ $relatedItem->year }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- ==========================================
         LIGHTBOX MODAL
         ========================================== --}}
    @if($collection->photo_url)
        <div x-show="lightboxOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="lightboxOpen = false"
             @keydown.escape.window="lightboxOpen = false"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 cursor-zoom-out"
             x-cloak
             id="lightbox-modal">
            <div class="relative max-w-full max-h-[90vh] flex flex-col items-center">
                <img src="{{ asset('storage/' . $collection->photo_url) }}"
                     alt="{{ $collection->name }}"
                     class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">
                <button @click="lightboxOpen = false"
                        class="absolute -top-3 -right-3 btn btn-circle btn-sm bg-white text-black hover:bg-gray-100 shadow-lg"
                        aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <p class="text-center text-white/60 text-sm mt-3">{{ $collection->name }}</p>
            </div>
        </div>
    @endif
</section>

@endsection
