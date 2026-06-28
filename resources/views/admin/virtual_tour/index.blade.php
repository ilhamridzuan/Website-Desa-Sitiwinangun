@extends('layouts.admin')

@section('title', 'Virtual Tour 360°')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Virtual Tour 360°</span></li>
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Virtual Tour 360°</h1>
            <p class="text-xs text-base-content/60 font-sans">Kelola kode embed Virtual Tour 360 derajat Desa Sitiwinangun</p>
        </div>
        @if($tour)
            <div>
                <a href="{{ route('admin.virtual-tour.edit') }}" class="btn btn-primary text-white gap-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Perbarui Embed
                </a>
            </div>
        @endif
    </div>

    @if(!$tour)
        {{-- Empty State / Setup First Tour --}}
        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body py-12 text-center flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
                <h3 class="text-lg font-bold text-base-content font-serif">Belum Ada Virtual Tour</h3>
                <p class="text-sm text-base-content/60 max-w-sm mt-1">Konfigurasi embed Virtual Tour belum disetup di sistem.</p>
                <div class="mt-4">
                    <a href="{{ route('admin.virtual-tour.edit') }}" class="btn btn-primary text-white">Buat Tour Pertama</a>
                </div>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- Left Side: Active Tour Card + Live Preview --}}
            <div class="lg:col-span-8 flex flex-col gap-6">
                
                {{-- Active Tour Details --}}
                <div class="card bg-base-100 border border-base-300 shadow-sm">
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

                        {{-- Metadata --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-base-content/70 mb-4 bg-base-200/50 rounded-btn p-3">
                            <div class="flex flex-col gap-1">
                                <span class="text-base-content/50">Diperbarui Oleh</span>
                                <span class="font-semibold text-base-content">{{ $tour->updater->name ?? 'Sistem' }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-base-content/50">Waktu Pembaruan</span>
                                <span class="font-semibold text-base-content">{{ $tour->updated_at->format('d M Y, H:i') }}</span>
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

            {{-- Right Side: History Rollback Card --}}
            <div class="lg:col-span-4">
                
                <div class="card bg-base-100 border border-base-300 shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="card-title text-base font-bold font-serif mb-3 text-base-content border-b border-base-200 pb-2">
                            Riwayat Versi
                        </h3>
                        <p class="text-xs text-base-content/60 mb-4">Sistem menyimpan hingga 5 perubahan terakhir. Anda dapat memulihkan (rollback) versi kapan saja.</p>

                        @if(empty($tour->version_history))
                            <div class="text-center py-6 text-xs text-base-content/40 bg-base-200/20 rounded-btn border border-dashed border-base-300">
                                Belum ada riwayat versi sebelumnya.
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($tour->version_history as $history)
                                    <div class="border border-base-300 rounded-btn p-3 text-xs bg-base-200/30 flex flex-col gap-2">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-primary">Versi #{{ $history['version'] }}</span>
                                            <span class="font-mono text-base-content/50 text-[10px]" title="MD5 Hash: {{ $history['code_hash'] }}">
                                                {{ substr($history['code_hash'], 0, 7) }}
                                            </span>
                                        </div>
                                        <div class="text-[11px] text-base-content/70">
                                            Oleh: <span class="font-medium text-base-content">{{ \App\Models\User::find($history['updated_by'])->name ?? 'Sistem' }}</span><br/>
                                            Waktu: <span class="font-medium text-base-content">{{ \Carbon\Carbon::parse($history['updated_at'])->format('d M Y, H:i') }}</span>
                                        </div>
                                        <div class="border-t border-base-300 pt-2 flex justify-end">
                                            <form action="{{ route('admin.virtual-tour.rollback', $history['version']) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="button"
                                                        x-on:click="if(confirm('Apakah Anda yakin ingin mengembalikan Virtual Tour ke versi #' + {{ $history['version'] }} + '?')) $el.closest('form').submit()"
                                                        class="btn btn-warning btn-xs text-white gap-1 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                    </svg>
                                                    Rollback
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    @endif
@endsection
