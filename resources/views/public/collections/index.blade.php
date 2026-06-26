@extends('layouts.public')

@section('title', 'Galeri Koleksi Kriya — Museum Digital Gerabah Sitiwinangun')
@section('meta_description', 'Jelajahi katalog koleksi gerabah dan kriya Desa Sitiwinangun. Filter berdasarkan kategori, cari berdasarkan nama produk atau pengrajin.')

@section('content')

{{-- Header --}}
<section class="bg-base-200 bg-batik-pattern py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="section-heading text-3xl md:text-4xl animate-fade-in-up">
            {{ $type === 'pola' ? 'Galeri Pola Motif Gerabah' : 'Galeri Koleksi Kriya' }}
        </h1>
        <p class="text-base-content/60 max-w-2xl mt-4 animate-fade-in-up leading-relaxed" style="animation-delay:0.15s">
            @if($type === 'pola')
                Katalog ragam hias dan pola ukiran tradisional khas Sitiwinangun — warisan estetika lokal yang diaplikasikan pada permukaan kerajinan gerabah.
            @else
                Ragam karya gerabah dari para pengrangin Sitiwinangun — setiap bentuk menyimpan cerita tentang tanah, tangan, dan tradisi warisan budaya Cirebon.
            @endif
        </p>
    </div>
</section>

{{-- Search & Filter + Grid --}}
<section class="py-12 px-4" id="gallery-section"
         x-data="{
            tab: '{{ $type }}',
            search: '{{ request('q', '') }}',
            activeCategory: '{{ request('kategori', '') }}',
            submitSearch() {
                const params = new URLSearchParams();
                if (this.tab) params.set('tab', this.tab);
                if (this.search) params.set('q', this.search);
                if (this.activeCategory) params.set('kategori', this.activeCategory);
                window.location.href = '{{ route('public.collections.index') }}' + (params.toString() ? '?' + params.toString() : '');
            },
            filterCategory(slug) {
                this.activeCategory = (this.activeCategory === slug) ? '' : slug;
                this.submitSearch();
            }
         }">
    <div class="max-w-7xl mx-auto">

        {{-- Tabs Section --}}
        <div class="tabs tabs-boxed mb-8 max-w-md mx-auto md:mx-0 flex justify-center md:justify-start">
            <a href="{{ route('public.collections.index', array_merge(request()->except('page'), ['tab' => 'koleksi'])) }}" 
               class="tab flex-1 {{ $type === 'koleksi' ? 'tab-active font-semibold' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Koleksi Gerabah
            </a>
            <a href="{{ route('public.collections.index', array_merge(request()->except('page'), ['tab' => 'pola'])) }}" 
               class="tab flex-1 {{ $type === 'pola' ? 'tab-active font-semibold' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Pola Motif Gerabah
            </a>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            {{-- Search Input --}}
            <div class="relative flex-1 max-w-md">
                <form @submit.prevent="submitSearch()">
                    <input type="text"
                           x-model="search"
                           placeholder="Cari koleksi, pengrajin, atau teknik..."
                           class="input input-bordered w-full pl-10 pr-4 text-sm"
                           id="search-input">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </form>
            </div>

            {{-- Category Filter Chips --}}
            <div class="flex gap-2 items-center overflow-x-auto pb-2 scrollbar-none">
                <span class="text-sm text-base-content/50 mr-1 shrink-0">Filter:</span>
                <button @click="filterCategory('')"
                        class="badge badge-lg cursor-pointer transition-all shrink-0"
                        :class="activeCategory === '' ? 'badge-primary text-primary-content' : 'badge-outline hover:badge-primary/20'"
                        id="filter-all">
                    Semua
                </button>
                @foreach($categories as $cat)
                    <button @click="filterCategory('{{ $cat->slug }}')"
                            class="badge badge-lg cursor-pointer transition-all shrink-0"
                            :class="activeCategory === '{{ $cat->slug }}' ? 'badge-primary text-primary-content' : 'badge-outline hover:badge-primary/20'"
                            id="filter-{{ $cat->slug }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Results info --}}
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-base-content/50">
                Menampilkan <span class="font-semibold text-base-content">{{ $collections->total() }}</span> koleksi
                @if(request('q'))
                    untuk "<span class="text-primary font-medium">{{ request('q') }}</span>"
                @endif
                @if(request('kategori'))
                    @php $activeCat = $categories->firstWhere('slug', request('kategori')); @endphp
                    @if($activeCat)
                        dalam kategori <span class="font-medium text-primary">{{ $activeCat->name }}</span>
                    @endif
                @endif
            </p>
            @if(request('q') || request('kategori'))
                <a href="{{ route('public.collections.index') }}" class="btn btn-ghost btn-xs gap-1 text-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
            @endif
        </div>

        {{-- Collection Grid --}}
        @if($collections->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 stagger-children">
                @foreach($collections as $collection)
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
                            <h3 class="card-title text-base font-serif group-hover:text-primary transition-colors line-clamp-1">
                                {{ $collection->name }}
                            </h3>
                            @if($collection->description)
                                <p class="text-sm text-base-content/50 line-clamp-2 leading-relaxed">
                                    {{ Str::limit($collection->description, 100) }}
                                </p>
                            @endif
                            @if($collection->type === 'koleksi')
                                <div class="flex items-center justify-between text-xs text-base-content/40 mt-1">
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        {{ $collection->artisan->name ?? '-' }}
                                    </span>
                                    <span>{{ $collection->year }}</span>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($collections->hasPages())
                <div class="flex justify-center mt-12">
                    <div class="join" id="pagination">
                        {{-- Previous --}}
                        @if($collections->onFirstPage())
                            <button class="join-item btn btn-disabled btn-sm">«</button>
                        @else
                            <a href="{{ $collections->previousPageUrl() }}" class="join-item btn btn-sm">«</a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach($collections->getUrlRange(max(1, $collections->currentPage() - 2), min($collections->lastPage(), $collections->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}"
                               class="join-item btn btn-sm {{ $page == $collections->currentPage() ? 'btn-primary btn-active' : '' }}">
                                {{ $page }}
                            </a>
                        @endforeach

                        {{-- Next --}}
                        @if($collections->hasMorePages())
                            <a href="{{ $collections->nextPageUrl() }}" class="join-item btn btn-sm">»</a>
                        @else
                            <button class="join-item btn btn-disabled btn-sm">»</button>
                        @endif
                    </div>
                </div>
            @endif

        @else
            {{-- Empty State --}}
            <div class="text-center py-20" id="empty-state">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-base-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/25" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-xl font-serif font-semibold text-base-content/70 mb-2">Koleksi Tidak Ditemukan</h3>
                <p class="text-base-content/50 max-w-md mx-auto mb-6">
                    @if(request('q'))
                        Tidak ada koleksi yang cocok dengan pencarian "<strong>{{ request('q') }}</strong>". Coba kata kunci lain atau reset filter.
                    @else
                        Belum ada koleksi yang tersedia saat ini. Koleksi sedang dalam proses digitalisasi.
                    @endif
                </p>
                @if(request('q') || request('kategori'))
                    <div class="flex flex-wrap gap-2 justify-center">
                        <a href="{{ route('public.collections.index') }}" class="btn btn-primary btn-sm">Lihat Semua Koleksi</a>
                        @foreach($categories->take(3) as $suggestedCat)
                            <a href="{{ route('public.collections.index', ['kategori' => $suggestedCat->slug]) }}"
                               class="btn btn-outline btn-primary btn-sm">
                                {{ $suggestedCat->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>

@endsection
