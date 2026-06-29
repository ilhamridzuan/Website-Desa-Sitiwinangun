@extends('layouts.admin')

@section('title', 'Kisah Pengrajin')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Kisah Pengrajin</span></li>
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Kisah Pengrajin</h1>
            <p class="text-xs text-base-content/60 font-sans">Kelola profil dan kisah maestro pengrajin gerabah Desa Sitiwinangun</p>
        </div>
        <div>
            <a href="{{ route('admin.artisans.create') }}" class="btn btn-primary text-white gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengrajin
            </a>
        </div>
    </div>

    {{-- Filter bar --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm mb-6">
        <div class="card-body p-4">
            <form action="{{ route('admin.artisans.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="form-control w-full md:col-span-3">
                    <div class="relative w-full">
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Cari nama pengrajin atau keahlian khas..." 
                               class="input input-bordered w-full pr-10" />
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-base-content/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="flex gap-2 w-full">
                    <button type="submit" class="btn btn-neutral flex-1 shadow-sm">Filter</button>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.artisans.index') }}" class="btn btn-ghost">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Data Table / Empty State --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm">
        @if($artisans->isEmpty())
            <div class="card-body py-12 text-center flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h3 class="text-lg font-bold text-base-content font-serif">Belum Ada Pengrajin</h3>
                <p class="text-sm text-base-content/60 max-w-sm mt-1">Data profil pengrajin kosong atau filter tidak menemukan hasil yang sesuai.</p>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('admin.artisans.create') }}" class="btn btn-primary btn-sm text-white">Tambah Pengrajin</a>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.artisans.index') }}" class="btn btn-ghost btn-sm">Reset Filter</a>
                    @endif
                </div>
            </div>
        @else
            <div class="overflow-x-auto w-full">
                <table class="table table-zebra w-full text-sm min-w-[900px]">
                    <thead>
                        <tr class="text-base-content/70">
                            <th>Foto</th>
                            <th>Nama Pengrajin</th>
                            <th>Produk Khas</th>
                            <th>Durasi Berkarya</th>
                            <th class="text-center">Featured</th>
                            <th class="text-center">Urutan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($artisans as $artisan)
                            <tr class="hover:bg-base-200/50 transition-colors">
                                <td class="whitespace-nowrap">
                                    <div class="avatar placeholder">
                                        @if($artisan->photo_url)
                                            <div class="w-10 h-10 rounded-full">
                                                <img src="{{ asset('storage/' . $artisan->photo_url) }}" alt="{{ $artisan->name }}" />
                                            </div>
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary font-bold font-serif text-sm flex items-center justify-center">
                                                <span>{{ collect(explode(' ', $artisan->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="font-bold text-base-content whitespace-nowrap">{{ $artisan->name }}</div>
                                    <div class="text-xs text-base-content/50 max-w-xs truncate" title="{{ $artisan->address }}">{{ $artisan->address }}</div>
                                </td>
                                <td>
                                    {{ $artisan->specialty ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $artisan->years_active ?? '-' }}
                                </td>
                                <td class="text-center whitespace-nowrap">
                                    <input type="checkbox" 
                                           class="toggle toggle-primary toggle-sm shadow-sm" 
                                           {{ $artisan->is_featured ? 'checked' : '' }} 
                                           x-on:change="
                                               fetch('{{ route('admin.artisans.toggle-featured', $artisan) }}', {
                                                   method: 'PATCH',
                                                   headers: {
                                                       'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                       'Content-Type': 'application/json',
                                                       'Accept': 'application/json'
                                                   }
                                               })
                                               .then(res => res.json())
                                               .then(data => {
                                                   if(!data.success) {
                                                       alert('Gagal memperbarui status featured');
                                                   }
                                               })
                                               .catch(err => {
                                                   alert('Terjadi kesalahan jaringan');
                                               })
                                           " />
                                </td>
                                <td class="text-center whitespace-nowrap">
                                    <span class="badge badge-ghost badge-sm whitespace-nowrap">{{ $artisan->sort_order }}</span>
                                </td>
                                <td class="text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.artisans.edit', $artisan) }}" class="btn btn-ghost btn-xs text-primary gap-1 hover:bg-primary/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <button type="button" 
                                                x-on:click="$dispatch('open-delete-modal', { url: '{{ route('admin.artisans.destroy', $artisan) }}', name: '{{ addslashes($artisan->name) }}' })"
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
            <div class="card-body p-4 border-t border-base-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-base-content/60">
                    Menampilkan {{ $artisans->firstItem() }} - {{ $artisans->lastItem() }} dari {{ $artisans->total() }} pengrajin
                </div>
                <div>
                    {{ $artisans->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>
@endsection
