@extends('layouts.public')

@section('title', $artisan->name . ' — Pengrajin Sitiwinangun')
@section('meta_description', 'Mengenal ' . $artisan->name . ', maestro gerabah Sitiwinangun yang telah berkarya selama ' . $artisan->years_active . ' tahun. Simak kisah dan karyanya.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumbs --}}
    <div class="text-sm breadcrumbs mb-8" id="breadcrumbs">
        <ul>
            <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a></li>
            <li><a href="{{ route('public.artisans.index') }}" class="hover:text-primary transition-colors">Pengrajin</a></li>
            <li class="text-primary font-medium">{{ $artisan->name }}</li>
        </ul>
    </div>

    {{-- Main Layout Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Sidebar: Profile Info & Contact --}}
        <div class="lg:col-span-4 flex flex-col gap-6" id="artisan-sidebar">
            {{-- Image & Stats Card --}}
            <div class="card bg-base-100 shadow-sm border border-base-200/50 overflow-hidden">
                <figure class="relative overflow-hidden aspect-[1/1] bg-base-200">
                    @if($artisan->photo_url)
                        <img src="{{ asset('storage/' . $artisan->photo_url) }}"
                             alt="{{ $artisan->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="img-placeholder w-full h-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    @endif
                </figure>
                <div class="card-body p-6 gap-4">
                    <div>
                        <h2 class="font-serif text-2xl font-bold leading-tight" id="artisan-name">{{ $artisan->name }}</h2>
                        <span class="badge badge-accent text-accent-content font-semibold mt-2" id="artisan-years-badge">
                            {{ $artisan->years_active }} Tahun Berkarya
                        </span>
                    </div>

                    <div class="divider my-0"></div>

                    <div class="space-y-1">
                        <span class="text-xs text-base-content/50 uppercase tracking-wider block">Spesialisasi Kriya</span>
                        <span class="text-sm font-medium text-base-content" id="artisan-specialty">{{ $artisan->specialty }}</span>
                    </div>
                </div>
            </div>

            {{-- Contact & Location Card --}}
            <div class="card bg-base-100 shadow-sm border border-base-200/50" id="artisan-contact-card">
                <div class="card-body p-6">
                    <h3 class="font-serif text-lg font-bold text-primary mb-3">Informasi Kontak & Bengkel</h3>
                    <div class="space-y-4">
                        @if($artisan->address)
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div class="text-sm text-base-content/80 leading-relaxed">
                                    <span class="font-semibold block text-base-content">Alamat Rumah Produksi</span>
                                    <span id="artisan-address">{{ $artisan->address }}</span>
                                </div>
                            </div>
                        @endif

                        @if($artisan->phone)
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <div class="text-sm text-base-content/80">
                                    <span class="font-semibold block text-base-content">No. Telepon / WhatsApp</span>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $artisan->phone) }}" target="_blank" class="hover:underline text-primary font-medium" id="artisan-phone">
                                        {{ $artisan->phone }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Section: Story & Collection Grid --}}
        <div class="lg:col-span-8 flex flex-col gap-8" id="artisan-main-content">
            {{-- Quote & Story Narrative --}}
            <div class="bg-base-100 p-6 sm:p-8 rounded-box shadow-sm border border-base-200/50">
                @if($artisan->quote)
                    <blockquote class="pull-quote font-serif text-lg md:text-xl text-primary/80 mb-8 border-l-4 border-accent pl-6 py-2" id="artisan-quote">
                        "{{ $artisan->quote }}"
                    </blockquote>
                @endif

                <h3 class="text-sm font-semibold uppercase tracking-wider text-accent mb-4">Kisah Perjalanan & Dedikasi</h3>
                <div class="prose-batik max-w-none" id="artisan-story">
                    {!! nl2br(e($artisan->story)) !!}
                </div>
            </div>

            {{-- Karya Pengrajin --}}
            <div id="artisan-works">
                <h3 class="section-heading text-2xl font-bold mb-6">Karya & Koleksi Mahakarya</h3>
                @if($artisan->collections->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="collections-grid">
                        @foreach($artisan->collections as $collection)
                            <a href="{{ route('public.collections.show', $collection->slug) }}"
                               class="card bg-base-100 shadow-sm card-hover-lift group overflow-hidden border border-base-200/50"
                               id="collection-card-{{ $collection->id }}">
                                {{-- Image --}}
                                <figure class="relative overflow-hidden aspect-[4/3] bg-base-200">
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
                                            <span class="badge badge-sm text-white font-medium shadow-sm"
                                                  style="background-color: {{ $collection->category->color_hex ?? '#6B3D14' }}">
                                                {{ $collection->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                </figure>

                                {{-- Card body --}}
                                <div class="card-body p-4 gap-2">
                                    <h4 class="card-title text-base font-serif group-hover:text-primary transition-colors line-clamp-1">
                                        {{ $collection->name }}
                                    </h4>
                                    @if($collection->description)
                                        <p class="text-xs text-base-content/50 line-clamp-2 leading-relaxed">
                                            {{ Str::limit($collection->description, 80) }}
                                        </p>
                                    @endif
                                    <div class="flex items-center justify-between text-[0.7rem] text-base-content/40 mt-1">
                                        <span>Tahun {{ $collection->year }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="bg-base-200/30 p-8 rounded-box text-center border border-dashed border-base-300" id="empty-collections">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/30 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="text-sm text-base-content/50">Belum ada karya terbit dari pengrajin ini di galeri digital.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
