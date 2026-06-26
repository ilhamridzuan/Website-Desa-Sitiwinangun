@extends('layouts.admin')

@section('title', 'Lokasi Rumah Produksi')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Jelajah Desa</span></li>
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Lokasi Rumah Produksi</h1>
            <p class="text-xs text-base-content/60 font-sans">Kelola titik lokasi rumah produksi untuk peta dan panduan Jelajah Desa</p>
        </div>
        <div>
            <a href="{{ route('admin.locations.create') }}" class="btn btn-primary text-white gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Tambah Lokasi
            </a>
        </div>
    </div>

    {{-- Info Banner --}}
    <div class="alert alert-info alert-soft mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm">Data lokasi ini tampil di <strong>Peta Interaktif</strong> dan halaman <strong>Jelajah Sitiwinangun</strong>.</span>
    </div>

    {{-- Search bar --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm mb-6">
        <div class="card-body p-4">
            <form action="{{ route('admin.locations.index') }}" method="GET"
                  x-data="{ q: '{{ request('q') }}' }"
                  x-ref="searchForm"
                  class="flex flex-col sm:flex-row gap-3">
                <div class="form-control flex-1 relative">
                    <input type="text"
                           name="q"
                           x-model="q"
                           x-on:input.debounce.500ms="$refs.searchForm.submit()"
                           placeholder="Cari nama lokasi atau alamat..."
                           class="input input-bordered w-full pr-10" />
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-base-content/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-neutral shadow-sm">Cari</button>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.locations.index') }}" class="btn btn-ghost">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Table / Empty State --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm">
        @if($locations->isEmpty())
            <div class="card-body py-16 text-center flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-base-content/25 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                <h3 class="text-lg font-bold text-base-content font-serif mb-1">Belum Ada Titik Lokasi</h3>
                <p class="text-sm text-base-content/55 max-w-sm">Daftar lokasi rumah produksi untuk peta interaktif masih kosong. Mulai tambahkan titik pertama.</p>
                <div class="mt-5 flex gap-2">
                    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-sm text-white">
                        Tambah Titik Pertama
                    </a>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.locations.index') }}" class="btn btn-ghost btn-sm">Reset Filter</a>
                    @endif
                </div>
            </div>
        @else
            <div class="overflow-x-auto w-full">
                <table class="table table-zebra w-full text-sm">
                    <thead>
                        <tr class="text-base-content/70">
                            <th>Nama Lokasi & Pengrajin</th>
                            <th>Alamat & Kontak</th>
                            <th class="text-center">Kunjungan</th>
                            <th class="text-center">Koordinat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $loc)
                            <tr class="hover:bg-base-200/50 transition-colors">
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="w-10 h-10 rounded-btn {{ !$loc->photo_url ? 'bg-base-300' : '' }}">
                                                @if($loc->photo_url)
                                                    <img src="{{ asset('storage/' . $loc->photo_url) }}" alt="{{ $loc->name }}" class="object-cover" />
                                                @else
                                                    <div class="flex items-center justify-center w-full h-full text-base-content/30">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold text-base-content">{{ $loc->name }}</div>
                                            @if($loc->artisan)
                                                <div class="text-xs text-primary mt-0.5 font-medium flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    {{ $loc->artisan->name }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-xs text-base-content/70 line-clamp-2 max-w-xs" title="{{ $loc->address }}">
                                        {{ $loc->address }}
                                    </div>
                                    @if($loc->phone)
                                        <div class="text-xs text-base-content/50 mt-1 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $loc->phone }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($loc->is_open_visit)
                                        <span class="badge badge-success badge-sm badge-outline font-medium">Buka Kunjungan</span>
                                    @else
                                        <span class="badge badge-ghost badge-sm text-base-content/50">Tutup</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="flex flex-col items-center justify-center gap-0.5 text-xs text-base-content/60 font-mono">
                                        <span>{{ number_format($loc->latitude, 6) }}</span>
                                        <span>{{ number_format($loc->longitude, 6) }}</span>
                                    </div>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $loc->latitude }},{{ $loc->longitude }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="text-[10px] text-info hover:underline mt-1 inline-block">
                                        Lihat Peta
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.locations.edit', $loc) }}" class="btn btn-ghost btn-xs text-primary gap-1 hover:bg-primary/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <button type="button"
                                                x-on:click="$dispatch('open-delete-modal', { url: '{{ route('admin.locations.destroy', $loc) }}', name: '{{ addslashes($loc->name) }}' })"
                                                class="btn btn-ghost btn-xs text-error gap-1 hover:bg-error/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($locations->hasPages())
                <div class="card-body p-4 border-t border-base-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-xs text-base-content/60">
                        Menampilkan {{ $locations->firstItem() }} - {{ $locations->lastItem() }} dari {{ $locations->total() }} lokasi
                    </div>
                    <div class="join">
                        {{ $locations->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
