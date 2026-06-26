@extends('layouts.public')

@section('title', 'Kisah Para Pengrajin — Museum Digital Gerabah Sitiwinangun')
@section('meta_description', 'Mengenal para maestro gerabah Sitiwinangun. Kisah, karya, dan tradisi pengrajin yang menjaga warisan budaya lintas generasi.')

@section('content')

{{-- Header --}}
<section class="bg-base-200 bg-batik-pattern py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <span class="text-sm font-semibold uppercase tracking-wider text-primary">Para Penjaga Tradisi</span>
        <h1 class="section-heading text-3xl md:text-4xl animate-fade-in-up">Kisah Para Pengrajin</h1>
        <p class="text-base-content/60 max-w-2xl mt-4 animate-fade-in-up leading-relaxed" style="animation-delay:0.15s">
            Mengenal para maestro gerabah Desa Sitiwinangun. Melalui tangan terampil dan dedikasi lintas generasi, mereka membentuk tanah liat menjadi warisan budaya yang tak ternilai harganya.
        </p>
    </div>
</section>

{{-- Grid Pengrajin --}}
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        @if($artisans->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stagger-children" id="artisans-grid">
                @foreach($artisans as $artisan)
                    <a href="{{ route('public.artisans.show', $artisan->id) }}"
                       class="card bg-base-100 shadow-sm card-hover-lift group animate-fade-in-up flex flex-col h-full overflow-hidden"
                       id="artisan-card-{{ $artisan->id }}">
                        {{-- Image --}}
                        <figure class="relative overflow-hidden aspect-[4/3] bg-base-200">
                            @if($artisan->photo_url)
                                <img src="{{ asset('storage/' . $artisan->photo_url) }}"
                                     alt="{{ $artisan->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                            @else
                                <div class="img-placeholder w-full h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                            <div class="absolute bottom-3 left-3 flex flex-wrap gap-1">
                                <span class="badge badge-sm badge-accent text-accent-content font-semibold shadow-sm">
                                    {{ $artisan->years_active }} Tahun Berkarya
                                </span>
                            </div>
                        </figure>

                        {{-- Body --}}
                        <div class="card-body p-6 flex flex-col justify-between flex-1 gap-4">
                            <div>
                                <h3 class="card-title text-xl font-serif group-hover:text-primary transition-colors line-clamp-1">
                                    {{ $artisan->name }}
                                </h3>
                                <div class="text-xs text-base-content/60 font-medium mt-1.5 uppercase tracking-wider flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                                    Spesialis: {{ $artisan->specialty }}
                                </div>

                                @if($artisan->quote)
                                    <div class="pull-quote text-sm text-base-content/70 mt-4 italic line-clamp-3">
                                        {{ $artisan->quote }}
                                    </div>
                                @endif
                            </div>

                            <div class="card-actions justify-end border-t border-base-200/50 pt-4 mt-auto">
                                <span class="text-xs font-semibold text-primary group-hover:translate-x-1 transition-transform flex items-center gap-1">
                                    Baca Kisah Lengkap
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 bg-base-200/30 rounded-box border border-dashed border-base-300" id="empty-state">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-base-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/25" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="text-xl font-serif font-semibold text-base-content/70 mb-2">Belum Ada Profil Pengrajin</h3>
                <p class="text-base-content/50 max-w-md mx-auto">
                    Saat ini data para pengrajin dan kisah mereka sedang dalam proses penyusunan dan kurasi digital.
                </p>
            </div>
        @endif
    </div>
</section>

@endsection
