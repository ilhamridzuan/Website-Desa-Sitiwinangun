@extends('layouts.public')

@section('title', 'Storytelling PDF — Museum Digital Gerabah Sitiwinangun')
@section('meta_description', 'Unduh dokumen digital storytelling, katalog kriya, brosur wisata, dan riset kebudayaan gerabah Desa Sitiwinangun.')

@section('content')

{{-- Header --}}
<section class="bg-base-200 bg-batik-pattern py-16 px-4">
    <div class="max-w-5xl mx-auto text-center">
        <span class="text-sm font-semibold uppercase tracking-wider text-primary">Publikasi Digital</span>
        <h1 class="section-heading text-center text-3xl md:text-4xl animate-fade-in-up">Storytelling PDF</h1>
        <p class="text-base-content/60 max-w-2xl mx-auto mt-4 animate-fade-in-up leading-relaxed" style="animation-delay:0.15s">
            Unduh brosur, katalog kriya, catatan sejarah, dan panduan edukasi gerabah Sitiwinangun dalam format dokumen PDF interaktif.
        </p>
    </div>
</section>

{{-- Daftar Dokumen --}}
<section class="py-12 px-4">
    <div class="max-w-5xl mx-auto">
        @if($docs->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="storytelling-grid">
                @foreach($docs as $doc)
                    <div class="card bg-base-100 shadow-sm border border-base-200/50 card-hover-lift flex flex-col sm:flex-row p-6 gap-6 items-start"
                         id="doc-card-{{ $doc->id }}">
                        {{-- PDF Icon Circle --}}
                        <div class="w-14 h-14 rounded-xl bg-error/10 text-error flex items-center justify-center flex-shrink-0 mx-auto sm:mx-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 flex flex-col justify-between h-full gap-4 text-center sm:text-left">
                            <div>
                                <h3 class="font-serif font-bold text-lg text-primary leading-snug" id="doc-title-{{ $doc->id }}">
                                    {{ $doc->title }}
                                </h3>
                                @if($doc->description)
                                    <p class="text-xs text-base-content/60 mt-2 leading-relaxed" id="doc-desc-{{ $doc->id }}">
                                        {{ $doc->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="card-actions justify-center sm:justify-start pt-2 border-t border-base-200/30">
                                <a href="{{ asset('storage/' . $doc->pdf_url) }}"
                                   target="_blank"
                                   download
                                   class="btn btn-sm btn-primary gap-1.5"
                                   id="doc-download-{{ $doc->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Unduh Dokumen
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 bg-base-100 shadow-sm border border-base-200/50 rounded-box max-w-2xl mx-auto" id="empty-storytelling">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-base-200 flex items-center justify-center text-base-content/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-serif font-semibold text-base-content/70 mb-2">Buku Panduan Belum Tersedia</h3>
                <p class="text-base-content/50 max-w-md mx-auto">
                    Katalog digital dan publikasi storytelling dalam format PDF sedang dipersiapkan oleh tim redaksi.
                </p>
            </div>
        @endif
    </div>
</section>

@endsection
