@extends('layouts.public')

@section('title', 'Proses Produksi Gerabah — Museum Digital Gerabah Sitiwinangun')
@section('meta_description', 'Ikuti perjalanan tanah liat bertransformasi menjadi karya kriya bernilai tinggi melalui 5 tahapan produksi tradisional gerabah Sitiwinangun.')

@section('content')

{{-- Header --}}
<section class="bg-base-200 bg-batik-pattern py-16 px-4">
    <div class="max-w-5xl mx-auto text-center">
        <span class="text-sm font-semibold uppercase tracking-wider text-primary">Proses Tradisional</span>
        <h1 class="section-heading text-center text-3xl md:text-4xl animate-fade-in-up">Dari Tanah Menjadi Karya</h1>
        <p class="text-base-content/60 max-w-2xl mx-auto mt-4 animate-fade-in-up leading-relaxed" style="animation-delay:0.15s">
            Setiap gerabah Sitiwinangun melewati proses panjang yang menuntut kesabaran, keahlian tangan, dan ketelitian insting para maestro. Kenali 5 tahapan sakral pembuatannya.
        </p>
    </div>
</section>

{{-- Timeline section --}}
<section class="py-16 px-4">
    <div class="max-w-5xl mx-auto">
        {{-- Desktop Horizontal Steps Tracker (daisyUI steps) --}}
        @if($stages->count())
            <div class="hidden md:flex justify-center mb-16">
                <ul class="steps steps-horizontal w-full max-w-3xl" id="desktop-steps-tracker">
                    @foreach($stages as $stage)
                        <li class="step step-primary font-medium text-xs md:text-sm">
                            {{ $stage->title }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Alternating Timeline Blocks --}}
            <div class="space-y-16 md:space-y-24 relative before:absolute before:inset-y-0 before:left-4 md:before:left-1/2 before:w-0.5 before:bg-base-300/60 before:-translate-x-1/2" id="production-timeline">
                @foreach($stages as $index => $stage)
                    @php
                        $isEven = $index % 2 === 0;
                    @endphp
                    <div class="relative flex flex-col md:flex-row items-center md:justify-between gap-8 md:gap-0" id="stage-block-{{ $stage->stage_number }}">
                        {{-- Timeline node --}}
                        <div class="absolute left-4 md:left-1/2 w-8 h-8 rounded-full bg-primary text-primary-content border-4 border-base-100 flex items-center justify-center font-bold text-xs shadow-md z-10 -translate-x-1/2">
                            {{ $stage->stage_number }}
                        </div>

                        {{-- Content Card --}}
                        <div class="w-full md:w-[45%] pl-12 md:pl-0 {{ $isEven ? 'md:order-1' : 'md:order-2' }} animate-fade-in-up">
                            <div class="card bg-base-100 shadow-sm border border-base-200/50 hover:shadow-md transition-shadow duration-300">
                                <figure class="relative aspect-[16/10] overflow-hidden bg-base-200">
                                    @if($stage->photo_url)
                                        <img src="{{ asset('storage/' . $stage->photo_url) }}"
                                             alt="{{ $stage->title }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="img-placeholder w-full h-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 left-4 bg-primary text-primary-content text-xs font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider">
                                        Tahap {{ $stage->stage_number }}
                                    </div>
                                </figure>
                                <div class="card-body p-6 gap-3">
                                    <h3 class="card-title font-serif text-lg md:text-xl text-primary font-bold">
                                        {{ $stage->title }}
                                    </h3>
                                    <p class="text-sm text-base-content/75 leading-relaxed">
                                        {{ $stage->description }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Empty side space placeholder on desktop --}}
                        <div class="hidden md:block w-[45%] {{ $isEven ? 'md:order-2' : 'md:order-1' }}"></div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 bg-base-200/30 rounded-box border border-dashed border-base-300" id="empty-stages">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-base-200 flex items-center justify-center text-base-content/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2"/>
                    </svg>
                </div>
                <h3 class="text-xl font-serif font-semibold text-base-content/70 mb-2">Informasi Proses Produksi Belum Tersedia</h3>
                <p class="text-base-content/50 max-w-md mx-auto">
                    Data tahapan pembuatan gerabah sedang disusun oleh pengelola museum.
                </p>
            </div>
        @endif
    </div>
</section>

@endsection
