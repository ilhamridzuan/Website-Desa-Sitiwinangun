@extends('layouts.public')

@section('title', 'Proses Produksi Gerabah | Museum Digital Gerabah Sitiwinangun')
@section('meta_description', 'Dokumentasi 7 tahap pembuatan gerabah tradisional Desa Sitiwinangun, mulai dari pengolahan tanah liat, pembentukan di meja putar, pengeringan, hingga pembakaran terbuka.')

@section('content')

{{-- Header Editorial --}}
<section class="bg-base-200/70 bg-batik-pattern border-b border-base-300/60 py-14 md:py-20 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="max-w-3xl">
            <h1 class="font-serif font-bold text-3xl sm:text-4xl md:text-5xl text-base-content leading-tight">
                Proses Pembuatan Gerabah Sitiwinangun
            </h1>
            <p class="text-base md:text-lg text-base-content/75 mt-5 leading-relaxed">
                Setiap gerabah dari Desa Sitiwinangun dikerjakan tangan melalui 7 tahap berurutan, dari melumat tanah liat mentah di bengkel hingga pembakaran terbuka di ladang bakar.
            </p>
        </div>

        @if(count($stages))
            {{-- Stage Jump Navigation --}}
            <nav aria-label="Navigasi tahapan produksi" class="mt-10 pt-6 border-t border-base-300/70">
                <ol class="flex gap-2 overflow-x-auto pb-2 md:pb-0 md:grid md:grid-cols-7 md:gap-3">
                    @foreach($stages as $stage)
                        <li class="shrink-0 md:shrink">
                            <a href="#{{ $stage['slug'] }}"
                               class="group flex items-start gap-2.5 rounded-lg border border-base-300/80 bg-base-100/90 px-3 py-2.5 min-h-[44px] hover:border-primary hover:bg-base-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-colors">
                                <span class="font-serif font-bold text-sm text-primary leading-snug shrink-0">
                                    {{ str_pad((string) $stage['number'], 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="text-xs font-medium text-base-content/80 group-hover:text-primary leading-snug">
                                    {{ $stage['title'] }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif
    </div>
</section>

{{-- Documentary Stages Section --}}
<section class="py-12 md:py-20 px-4 bg-base-100"
         x-data="{
            lightboxOpen: false,
            lightboxPhotos: [],
            lightboxIndex: 0,
            lightboxStageTitle: '',
            openLightbox(stageTitle, photos, index) {
                this.lightboxStageTitle = stageTitle;
                this.lightboxPhotos = photos;
                this.lightboxIndex = index;
                this.lightboxOpen = true;
                document.body.style.overflow = 'hidden';
            },
            closeLightbox() {
                this.lightboxOpen = false;
                document.body.style.overflow = '';
            },
            nextPhoto() {
                if (this.lightboxPhotos.length < 2) return;
                this.lightboxIndex = (this.lightboxIndex + 1) % this.lightboxPhotos.length;
            },
            prevPhoto() {
                if (this.lightboxPhotos.length < 2) return;
                this.lightboxIndex = (this.lightboxIndex - 1 + this.lightboxPhotos.length) % this.lightboxPhotos.length;
            }
         }"
         x-on:keydown.escape.window="if (lightboxOpen) closeLightbox()"
         x-on:keydown.arrow-right.window="if (lightboxOpen) nextPhoto()"
         x-on:keydown.arrow-left.window="if (lightboxOpen) prevPhoto()">

    <div class="max-w-6xl mx-auto">
        @if(count($stages))
            <div class="divide-y divide-base-300/70" id="production-stages-list">
                @foreach($stages as $index => $stage)
                    @php
                        $photos = $stage['photos'] ?? [];
                        $photosForJs = collect($photos)->map(fn ($p) => [
                            'src' => asset($p['src']),
                            'alt' => $p['alt'],
                            'caption' => $p['caption'],
                            'orientation' => $p['orientation'] ?? 'landscape',
                        ])->values()->all();
                        $isReversed = $index % 2 === 1;
                        $firstPhoto = $photos[0] ?? null;
                        $isSinglePortrait = count($photos) === 1 && ($firstPhoto['orientation'] ?? 'landscape') === 'portrait';
                    @endphp

                    <article id="{{ $stage['slug'] }}"
                             class="scroll-mt-24 py-12 md:py-16 first:pt-2 last:pb-2"
                             x-data="{
                                active: 0,
                                photos: @js($photosForJs)
                             }">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

                            {{-- Photo Showcase Column --}}
                            <div class="lg:col-span-7 {{ $isReversed ? 'lg:order-2' : 'lg:order-1' }}">
                                @if(count($photos))
                                    {{-- Primary Framed Image Button --}}
                                    <div class="rounded-xl overflow-hidden border border-base-300/80 bg-base-200">
                                        <button type="button"
                                                x-on:click="openLightbox(@js($stage['title']), photos, active)"
                                                class="group relative block w-full {{ $isSinglePortrait ? 'aspect-[4/3]' : 'aspect-[16/10]' }} overflow-hidden bg-base-200 text-left cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                                                aria-label="Perbesar foto {{ $stage['title'] }}">
                                            <img x-bind:src="photos[active].src"
                                                 x-bind:alt="photos[active].alt"
                                                 src="{{ asset($firstPhoto['src']) }}"
                                                 alt="{{ $firstPhoto['alt'] }}"
                                                 width="1200"
                                                 height="750"
                                                 @if($index === 0) fetchpriority="high" @else loading="lazy" @endif
                                                 x-bind:class="photos[active].orientation === 'portrait' ? 'object-cover object-top' : 'object-cover object-center'"
                                                 class="w-full h-full object-cover {{ ($firstPhoto['orientation'] ?? 'landscape') === 'portrait' ? 'object-top' : 'object-center' }} transition-transform duration-300 group-hover:scale-[1.02]">

                                            <span class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-md bg-black/70 text-white text-xs font-medium px-2.5 py-1.5 backdrop-blur-xs">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16zm0-11v6m-3-3h6"/>
                                                </svg>
                                                Perbesar foto
                                            </span>
                                        </button>

                                        {{-- Caption + Counter Bar --}}
                                        <div class="flex items-start justify-between gap-4 px-4 py-3 bg-base-200/70 border-t border-base-300/60">
                                            <p class="text-xs sm:text-sm text-base-content/80 leading-relaxed"
                                               x-text="photos[active].caption">{{ $firstPhoto['caption'] }}</p>
                                            @if(count($photos) > 1)
                                                <span class="text-xs font-medium text-base-content/60 shrink-0 tabular-nums"
                                                      x-text="(active + 1) + ' / ' + photos.length">1 / {{ count($photos) }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Thumbnail Strip for Multi-Photo Stages --}}
                                    @if(count($photos) > 1)
                                        <div class="mt-3 grid grid-cols-5 gap-2 sm:gap-2.5" role="group" aria-label="Pilih foto {{ $stage['title'] }}">
                                            @foreach($photos as $photoIndex => $photo)
                                                <button type="button"
                                                        x-on:click="active = {{ $photoIndex }}"
                                                        x-bind:aria-current="active === {{ $photoIndex }} ? 'true' : 'false'"
                                                        x-bind:class="active === {{ $photoIndex }} ? 'ring-2 ring-primary border-primary opacity-100' : 'border-base-300 opacity-70 hover:opacity-100'"
                                                        class="relative aspect-[4/3] min-h-[44px] rounded-lg overflow-hidden border bg-base-200 transition cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                                                    <img src="{{ asset($photo['src']) }}"
                                                         alt="{{ $photo['alt'] }}"
                                                         width="240"
                                                         height="180"
                                                         loading="lazy"
                                                         class="w-full h-full object-cover {{ ($photo['orientation'] ?? 'landscape') === 'portrait' ? 'object-top' : 'object-center' }}">
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>

                            {{-- Stage Narrative Column --}}
                            <div class="lg:col-span-5 {{ $isReversed ? 'lg:order-1' : 'lg:order-2' }} lg:pt-2">
                                <div class="flex items-baseline gap-3">
                                    <span class="font-serif font-bold text-3xl md:text-4xl text-primary/85 leading-none tabular-nums">
                                        {{ str_pad((string) $stage['number'], 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="text-xs font-semibold text-base-content/60">
                                        Tahap {{ $stage['number'] }} dari {{ count($stages) }}
                                    </span>
                                </div>

                                <h2 class="font-serif font-bold text-2xl md:text-3xl text-base-content mt-3 leading-snug">
                                    {{ $stage['title'] }}
                                </h2>

                                <p class="text-sm font-medium text-primary mt-2">
                                    {{ $stage['summary'] }}
                                </p>

                                <p class="text-base text-base-content/80 leading-relaxed mt-4">
                                    {{ $stage['description'] }}
                                </p>

                                @if(count($photos) > 1)
                                    <p class="text-xs text-base-content/60 mt-5">
                                        Tersedia {{ count($photos) }} dokumentasi foto pada tahap ini. Klik thumbnail untuk mengganti gambar atau klik foto utama untuk melihat ukuran penuh.
                                    </p>
                                @endif
                            </div>

                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Next Step Navigation --}}
            <div class="mt-14 pt-10 border-t border-base-300/70 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="font-serif font-bold text-xl text-base-content">Lihat hasil akhir proses ini</h2>
                    <p class="text-sm text-base-content/70 mt-1">
                        Telusuri koleksi gerabah yang telah selesai dibakar atau kenali pengrajin yang mengerjakannya.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('public.collections.index') }}" class="btn btn-primary min-h-[44px]">
                        Buka Galeri Produk
                    </a>
                    <a href="{{ route('public.artisans.index') }}" class="btn btn-outline btn-primary min-h-[44px]">
                        Lihat Profil Pengrajin
                    </a>
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 px-6 bg-base-200/40 rounded-box border border-dashed border-base-300" id="empty-stages">
                <h2 class="text-xl font-serif font-semibold text-base-content mb-2">
                    Dokumentasi proses produksi belum tersedia
                </h2>
                <p class="text-sm text-base-content/70 max-w-md mx-auto">
                    Data tahapan pembuatan gerabah belum dimuat. Anda tetap dapat melihat hasil karya pengrajin di halaman galeri.
                </p>
                <div class="mt-6">
                    <a href="{{ route('public.collections.index') }}" class="btn btn-primary min-h-[44px]">
                        Buka Galeri Produk
                    </a>
                </div>
            </div>
        @endif
    </div>

    {{-- Accessible Lightbox Modal --}}
    <div x-show="lightboxOpen"
         x-cloak
         x-transition.opacity
         role="dialog"
         aria-modal="true"
         x-bind:aria-label="'Pratinjau foto ' + lightboxStageTitle"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 p-4 sm:p-6"
         x-on:click.self="closeLightbox()">

        <div class="relative w-full max-w-5xl bg-base-100 rounded-xl overflow-hidden border border-base-300 shadow-2xl">
            {{-- Top bar --}}
            <div class="flex items-center justify-between gap-4 px-4 py-3 border-b border-base-300 bg-base-200/80">
                <div class="min-w-0">
                    <p class="font-serif font-bold text-base text-base-content truncate" x-text="lightboxStageTitle"></p>
                    <p class="text-xs text-base-content/65 tabular-nums"
                       x-show="lightboxPhotos.length > 1"
                       x-text="'Foto ' + (lightboxIndex + 1) + ' dari ' + lightboxPhotos.length"></p>
                </div>
                <button type="button"
                        x-on:click="closeLightbox()"
                        aria-label="Tutup pratinjau foto"
                        class="btn btn-ghost btn-sm min-h-[44px] min-w-[44px] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Image area --}}
            <div class="relative bg-black/95 flex items-center justify-center min-h-[260px] sm:min-h-[420px] max-h-[72vh]">
                <template x-if="lightboxPhotos.length > 0">
                    <img x-bind:src="lightboxPhotos[lightboxIndex].src"
                         x-bind:alt="lightboxPhotos[lightboxIndex].alt"
                         class="max-h-[72vh] w-auto max-w-full object-contain">
                </template>

                <button type="button"
                        x-show="lightboxPhotos.length > 1"
                        x-on:click="prevPhoto()"
                        aria-label="Foto sebelumnya"
                        class="btn btn-circle bg-black/65 hover:bg-black/85 text-white border border-white/25 absolute left-3 top-1/2 -translate-y-1/2 min-h-[44px] min-w-[44px] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <button type="button"
                        x-show="lightboxPhotos.length > 1"
                        x-on:click="nextPhoto()"
                        aria-label="Foto berikutnya"
                        class="btn btn-circle bg-black/65 hover:bg-black/85 text-white border border-white/25 absolute right-3 top-1/2 -translate-y-1/2 min-h-[44px] min-w-[44px] cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            {{-- Caption bar --}}
            <div class="px-4 py-3 bg-base-100 border-t border-base-300">
                <template x-if="lightboxPhotos.length > 0">
                    <p class="text-sm text-base-content/85 leading-relaxed" x-text="lightboxPhotos[lightboxIndex].caption"></p>
                </template>
            </div>
        </div>
    </div>
</section>

@endsection
