@extends('layouts.public')

@section('title', 'Sejarah Desa & Gerabah Sitiwinangun — Museum Digital')
@section('meta_description', 'Menelusuri sejarah terbentuknya Desa Sitiwinangun serta asal-usul kriya gerabah legendaris sejak era Kesultanan Cirebon abad ke-15.')

@section('content')

{{-- Header --}}
<section class="bg-base-200 bg-batik-pattern py-16 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <span class="text-sm font-semibold uppercase tracking-wider text-primary">Jejak Masa Lalu</span>
        <h1 class="section-heading text-center text-3xl md:text-4xl animate-fade-in-up">Sejarah Gerabah & Desa</h1>
        <p class="text-base-content/60 max-w-2xl mx-auto mt-4 animate-fade-in-up leading-relaxed" style="animation-delay:0.15s">
            Menyelami kisah berabad-abad tentang pembentukan tanah, perkembangan tradisi, dan pertemuan budaya yang melahirkan karakter gerabah Sitiwinangun yang ikonik.
        </p>
    </div>
</section>

{{-- History Sections --}}
<section class="py-12 px-4">
    <div class="max-w-4xl mx-auto flex flex-col gap-12">
        
        {{-- Section 1: Sejarah Desa --}}
        @if($desa)
            <article class="bg-base-100 p-6 sm:p-10 rounded-box shadow-sm border border-base-200/50" id="history-village">
                <h2 class="section-heading text-2xl font-serif font-bold text-primary mb-6" id="history-village-title">
                    {{ $desa->title }}
                </h2>
                <div class="prose-batik max-w-none text-base-content/80 leading-relaxed" id="history-village-content">
                    {!! nl2br(e($desa->content)) !!}
                </div>
            </article>
        @endif

        {{-- Section 2: Sejarah Gerabah --}}
        @if($gerabah)
            <article class="bg-base-100 p-6 sm:p-10 rounded-box shadow-sm border border-base-200/50" id="history-pottery">
                <h2 class="section-heading text-2xl font-serif font-bold text-primary mb-6" id="history-pottery-title">
                    {{ $gerabah->title }}
                </h2>
                <div class="prose-batik max-w-none text-base-content/80 leading-relaxed" id="history-pottery-content">
                    {!! nl2br(e($gerabah->content)) !!}
                </div>
            </article>
        @endif

        {{-- Multicultural Influence Card --}}
        <div class="card bg-base-100 shadow-sm border border-base-200/50 overflow-hidden" id="culture-influence">
            <div class="p-6 sm:p-8 bg-primary/5 border-l-4 border-accent">
                <h3 class="font-serif text-xl font-bold text-primary mb-4">Akulturasi Budaya Lintas Batas</h3>
                <p class="text-sm text-base-content/80 leading-relaxed mb-6">
                    Karakter gerabah Sitiwinangun tidak lahir dari ruang hampa. Letak geografis Cirebon sebagai kota pelabuhan kuno yang menghubungkan berbagai bangsa tecermin kuat pada ornamen, filosofi, dan fungsi gerabah kami yang dipengaruhi oleh peradaban lintas budaya:
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 font-serif font-bold text-sm">J</div>
                        <div>
                            <h4 class="font-bold text-sm text-base-content">Sunda & Jawa</h4>
                            <p class="text-xs text-base-content/65 mt-1 leading-relaxed">
                                Membentuk dasar teknik pembakaran tradisional, peralatan harian (kuali, kendi, cobek), dan penamaan perkakas lokal.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 font-serif font-bold text-sm">I</div>
                        <div>
                            <h4 class="font-bold text-sm text-base-content">Islam</h4>
                            <p class="text-xs text-base-content/65 mt-1 leading-relaxed">
                                Muncul dalam ornamen kaligrafi Arab yang dipahat halus pada kendi hias, guci, serta peralatan wudhu masjid.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 font-serif font-bold text-sm">T</div>
                        <div>
                            <h4 class="font-bold text-sm text-base-content">Tionghoa (Pesisir)</h4>
                            <p class="text-xs text-base-content/65 mt-1 leading-relaxed">
                                Memengaruhi ragam hias makhluk mitologi seperti naga dan burung hong (phoenix) serta bentuk guci bergaya oriental.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 font-serif font-bold text-sm">E</div>
                        <div>
                            <h4 class="font-bold text-sm text-base-content">Eropa / Kolonial</h4>
                            <p class="text-xs text-base-content/65 mt-1 leading-relaxed">
                                Diadopsi dalam elemen dekoratif pajangan kastil dan pengaruh arsitektur kolonial pada vas-vas bunga berukuran besar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fallback empty state when both history blocks are missing --}}
        @if(!$desa && !$gerabah)
            <div class="text-center py-20 bg-base-100 shadow-sm border border-base-200/50 rounded-box" id="empty-history">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-base-200 flex items-center justify-center text-base-content/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-base-content/80 mb-3">Sejarah Belum Tersusun</h3>
                <p class="text-base-content/50 max-w-md mx-auto mb-6">
                    Konten catatan sejarah desa dan kriya gerabah belum diterbitkan oleh pengurus museum.
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Kembali ke Beranda</a>
            </div>
        @endif
    </div>
</section>

@endsection
