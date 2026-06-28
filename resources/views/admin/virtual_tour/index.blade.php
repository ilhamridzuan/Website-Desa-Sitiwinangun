@extends('layouts.admin')

@section('title', 'Virtual Tour 360°')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Virtual Tour 360°</span></li>
@endsection

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Virtual Tour 360°</h1>
        <p class="text-xs text-base-content/60 font-sans">Pratinjau Virtual Tour 360 derajat Desa Sitiwinangun</p>
    </div>

    @if(!$tour)
        {{-- Empty State --}}
        <div class="card bg-base-100 border border-base-300 shadow-sm max-w-4xl">
            <div class="card-body py-12 text-center flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
                <h3 class="text-lg font-bold text-base-content font-serif">Belum Ada Virtual Tour</h3>
                <p class="text-sm text-base-content/60 max-w-sm mt-1">Konfigurasi embed Virtual Tour belum disetup di database.</p>
            </div>
        </div>
    @else
        <div class="max-w-4xl">
            {{-- Active Tour Details --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm mb-6">
                <div class="card-body p-6">
                    <div class="flex items-start justify-between border-b border-base-200 pb-4 mb-4">
                        <div>
                            <h3 class="card-title text-lg font-bold font-serif text-base-content">
                                {{ $tour->title }}
                            </h3>
                            <p class="text-xs text-base-content/60 mt-0.5">
                                {{ $tour->description ?? 'Tidak ada deskripsi tambahan.' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="badge badge-neutral badge-sm uppercase font-semibold">{{ str_replace('_', ' ', $tour->embed_type) }}</span>
                            @if($tour->is_active)
                                <span class="badge badge-success badge-sm text-white font-medium">Aktif</span>
                            @else
                                <span class="badge badge-warning badge-sm text-white font-medium">Nonaktif</span>
                            @endif
                        </div>
                    </div>

                    {{-- Live Preview Iframe --}}
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-bold text-base-content">Pratinjau Live 360°</span></label>
                        <div class="aspect-video w-full rounded-btn border border-base-300 overflow-hidden bg-black flex items-center justify-center">
                            @if($tour->is_active && $tour->sanitized_code)
                                {!! $tour->sanitized_code !!}
                            @else
                                <div class="text-center text-xs text-white/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                    <span>Virtual tour dinonaktifkan atau kode sanitasi kosong</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
