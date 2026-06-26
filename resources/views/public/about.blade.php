@extends('layouts.public')

@section('title', 'Tentang Desa Sitiwinangun — Museum Digital Gerabah')
@section('meta_description', $profile ? Str::limit($profile->description, 150) : 'Kenali Desa Wisata Sitiwinangun, sentra pengrajin gerabah bersejarah di Cirebon sejak abad ke-15.')

@section('content')

{{-- Header --}}
<section class="bg-base-200 bg-batik-pattern py-16 px-4">
    <div class="max-w-6xl mx-auto text-center">
        <span class="text-sm font-semibold uppercase tracking-wider text-primary">Profil Desa</span>
        <h1 class="section-heading text-center text-3xl md:text-4xl animate-fade-in-up">Tentang Sitiwinangun</h1>
        <p class="text-base-content/60 max-w-2xl mx-auto mt-4 animate-fade-in-up leading-relaxed" style="animation-delay:0.15s">
            Menelusuri sejarah, makna, dan letak geografis desa pengrajin gerabah bersejarah di tanah Cirebon.
        </p>
    </div>
</section>

{{-- Main Content --}}
<section class="py-12 px-4">
    <div class="max-w-6xl mx-auto">
        @if($profile)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Left: Description & Name Origin --}}
                <div class="lg:col-span-8 flex flex-col gap-6" id="profile-main-content">
                    {{-- Name Philosophy --}}
                    <div class="bg-primary/5 border-l-4 border-accent p-6 sm:p-8 rounded-r-box shadow-sm" id="name-philosophy">
                        <h3 class="font-serif text-xl font-bold text-primary mb-3">Filosofi Nama Sitiwinangun</h3>
                        <p class="text-sm md:text-base text-base-content/80 leading-relaxed">
                            Nama <strong>Sitiwinangun</strong> berakar dari dua kata bahasa Jawa Kuno: <strong>Siti</strong> yang berarti <em>tanah</em> atau <em>bumi</em>, dan <strong>Winangun</strong> yang berarti <em>dibangun</em>, <em>dibentuk</em>, atau <em>diciptakan</em>. Secara mendalam, nama ini merefleksikan jati diri desa sebagai tempat di mana tanah dibentuk menjadi karya kriya bernilai tinggi dan membangun kemakmuran warganya sejak berabad-abad silam.
                        </p>
                    </div>

                    {{-- Narrative Description --}}
                    <div class="prose-batik leading-relaxed text-base-content/80" id="profile-description">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-accent mb-3">Identitas & Kehidupan Desa</h3>
                        {!! nl2br(e($profile->description)) !!}
                    </div>

                    {{-- Photo Gallery --}}
                    <div class="mt-6" id="profile-gallery">
                        <h3 class="section-heading text-xl font-bold mb-4">Galeri Kehidupan Desa</h3>
                        @if(!empty($profile->gallery_photos) && count($profile->gallery_photos) > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach($profile->gallery_photos as $index => $photo)
                                    <div class="relative overflow-hidden aspect-square rounded-box shadow-sm bg-base-200 group border border-base-200" id="gallery-photo-{{ $index }}">
                                        <img src="{{ asset('storage/' . $photo) }}"
                                             alt="Foto Desa Sitiwinangun {{ $index + 1 }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {{-- Placeholder Gallery --}}
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4" id="placeholder-gallery">
                                @for($i = 1; $i <= 3; $i++)
                                    <div class="relative overflow-hidden aspect-square rounded-box bg-base-200 flex items-center justify-center border border-dashed border-base-300 text-base-content/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endfor
                            </div>
                            <p class="text-xs text-base-content/40 italic mt-2 text-center">Foto dokumentasi desa akan segera diperbarui oleh admin.</p>
                        @endif
                    </div>
                </div>

                {{-- Right: Map & Address --}}
                <div class="lg:col-span-4 flex flex-col gap-6" id="profile-sidebar">
                    {{-- Address Card --}}
                    <div class="card bg-base-100 shadow-sm border border-base-200/50">
                        <div class="card-body p-6">
                            <h3 class="font-serif text-lg font-bold text-primary mb-3">Pusat Informasi & Sekretariat</h3>
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div class="text-sm text-base-content/85 leading-relaxed">
                                    <span class="font-semibold block text-base-content">Alamat Lengkap</span>
                                    <span id="profile-address">{{ $profile->address ?? 'Desa Sitiwinangun, Cirebon' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Map Embed Card --}}
                    @if($profile->latitude && $profile->longitude)
                        <div class="card bg-base-100 shadow-sm border border-base-200/50 overflow-hidden" id="profile-map-card">
                            <div class="p-4 bg-base-100 border-b border-base-200/50">
                                <h3 class="font-serif text-base font-bold text-primary">Lokasi Geografis</h3>
                            </div>
                            <div class="relative w-full h-[300px] bg-base-200">
                                <iframe 
                                    src="https://maps.google.com/maps?q={{ $profile->latitude }},{{ $profile->longitude }}&z=15&output=embed" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade"
                                    id="google-map-iframe">
                                </iframe>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            {{-- Fallback Empty State --}}
            <div class="text-center py-20 bg-base-100 shadow-sm border border-base-200/50 rounded-box max-w-2xl mx-auto" id="empty-profile">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-base-200 flex items-center justify-center text-base-content/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-base-content/80 mb-3">Profil Desa Belum Tersedia</h3>
                <p class="text-base-content/50 leading-relaxed mb-6">
                    Informasi profil Desa Sitiwinangun sedang dipersiapkan oleh pihak pengelola. Silakan kunjungi kembali beberapa saat lagi.
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Kembali ke Beranda</a>
            </div>
        @endif
    </div>
</section>

@endsection
