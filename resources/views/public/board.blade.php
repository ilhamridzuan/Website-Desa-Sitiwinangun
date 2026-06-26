@extends('layouts.public')

@section('title', 'Struktur Organisasi — Museum Digital Gerabah Sitiwinangun')
@section('meta_description', 'Struktur organisasi dan pengurus KIM, BUMDes, serta tim tata kelola Museum Digital Gerabah Desa Sitiwinangun.')

@section('content')

{{-- Header --}}
<section class="bg-base-200 bg-batik-pattern py-16 px-4">
    <div class="max-w-5xl mx-auto text-center">
        <span class="text-sm font-semibold uppercase tracking-wider text-primary">Manajemen Museum</span>
        <h1 class="section-heading text-center text-3xl md:text-4xl animate-fade-in-up">Struktur Organisasi</h1>
        <p class="text-base-content/60 max-w-2xl mx-auto mt-4 animate-fade-in-up leading-relaxed" style="animation-delay:0.15s">
            Para pengurus KIM, BUMDes, dan tim pengelola Museum Digital Gerabah Sitiwinangun yang berkomitmen melestarikan serta mempromosikan warisan lokal.
        </p>
    </div>
</section>

{{-- Grid Pengurus --}}
<section class="py-12 px-4">
    <div class="max-w-6xl mx-auto">
        @if($members->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 stagger-children" id="board-grid">
                @foreach($members as $member)
                    <div class="card bg-base-100 shadow-sm border border-base-200/50 card-hover-lift overflow-hidden text-center"
                         id="board-member-{{ $member->id }}">
                        {{-- Photo --}}
                        <figure class="relative aspect-square w-48 h-48 mx-auto mt-8 rounded-full overflow-hidden bg-base-200 border border-base-300">
                            @if($member->photo_url)
                                <img src="{{ asset('storage/' . $member->photo_url) }}"
                                     alt="{{ $member->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="img-placeholder w-full h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                        </figure>

                        {{-- Body --}}
                        <div class="card-body p-6 gap-3 items-center">
                            <div>
                                <h3 class="card-title text-lg font-serif font-bold justify-center" id="member-name-{{ $member->id }}">
                                    {{ $member->name }}
                                </h3>
                                <span class="text-xs uppercase tracking-wider font-semibold text-accent block mt-1.5" id="member-position-{{ $member->id }}">
                                    {{ $member->position }}
                                </span>
                            </div>

                            <div class="divider my-1 w-full opacity-50"></div>

                            {{-- Contacts --}}
                            <div class="space-y-1.5 w-full text-sm text-base-content/70 flex flex-col items-center">
                                @if($member->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone) }}" 
                                       target="_blank" 
                                       class="flex items-center gap-1.5 hover:text-primary transition-colors text-xs"
                                       id="member-phone-{{ $member->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-accent flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        {{ $member->phone }}
                                    </a>
                                @endif

                                @if($member->email)
                                    <a href="mailto:{{ $member->email }}" 
                                       class="flex items-center gap-1.5 hover:text-primary transition-colors text-xs"
                                       id="member-email-{{ $member->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-accent flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        {{ $member->email }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 bg-base-100 shadow-sm border border-base-200/50 rounded-box max-w-2xl mx-auto" id="empty-board">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-base-200 flex items-center justify-center text-base-content/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857"/>
                    </svg>
                </div>
                <h3 class="text-xl font-serif font-semibold text-base-content/70 mb-2">Informasi Pengurus Belum Tersedia</h3>
                <p class="text-base-content/50 max-w-md mx-auto">
                    Daftar kepengurusan dan manajemen museum sedang diperbarui oleh pihak administrasi desa.
                </p>
            </div>
        @endif
    </div>
</section>

@endsection
