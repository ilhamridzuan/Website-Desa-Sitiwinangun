@extends('layouts.admin')

@section('title', 'Koleksi Kriya')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Koleksi Kriya</span></li>
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Koleksi Kriya</h1>
            <p class="text-xs text-base-content/60 font-sans">Kelola semua data karya seni kriya dan gerabah Desa Sitiwinangun</p>
        </div>
        <div>
            <a href="{{ route('admin.collections.create') }}" class="btn btn-primary text-white gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Koleksi
            </a>
        </div>
    </div>

    {{-- Filter bar --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm mb-6">
        <div class="card-body p-4">
            <form x-data="{ q: '{{ request('q') }}' }" 
                  x-ref="form"
                  action="{{ route('admin.collections.index') }}" 
                  method="GET" 
                  class="grid grid-cols-1 md:grid-cols-4 gap-3">
                
                {{-- Search text --}}
                <div class="form-control w-full">
                    <div class="relative w-full">
                        <input type="text" 
                               name="q" 
                               x-model="q"
                               x-on:input.debounce.500ms="$refs.form.submit()"
                               placeholder="Cari nama koleksi / pengrajin..." 
                               class="input input-bordered w-full pr-10" />
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-base-content/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="form-control w-full">
                    <select name="category_id" onchange="this.form.submit()" class="select select-bordered w-full">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="form-control w-full">
                    <select name="status" onchange="this.form.submit()" class="select select-bordered w-full">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2 w-full">
                    <button type="submit" class="btn btn-neutral flex-1 shadow-sm">Filter</button>
                    @if(request()->anyFilled(['q', 'category_id', 'status']))
                        <a href="{{ route('admin.collections.index') }}" class="btn btn-ghost" title="Reset filter">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Data Table / Empty State --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm">
        @if($collections->isEmpty())
            <div class="card-body py-12 text-center flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="text-lg font-bold text-base-content font-serif">Belum Ada Koleksi</h3>
                <p class="text-sm text-base-content/60 max-w-sm mt-1">Data koleksi kriya kosong atau filter tidak menemukan hasil yang sesuai.</p>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('admin.collections.create') }}" class="btn btn-primary btn-sm text-white">Tambah Koleksi</a>
                    @if(request()->anyFilled(['q', 'category_id', 'status']))
                        <a href="{{ route('admin.collections.index') }}" class="btn btn-ghost btn-sm">Reset Filter</a>
                    @endif
                </div>
            </div>
        @else
            <div class="overflow-x-auto w-full">
                <table class="table table-zebra w-full text-sm min-w-[900px]">
                    <thead>
                        <tr class="text-base-content/70">
                            <th>Thumbnail</th>
                            <th>Nama Koleksi</th>
                            <th>Kategori</th>
                            <th>Pengrajin</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collections as $collection)
                            <tr class="hover:bg-base-200/50 transition-colors">
                                <td class="whitespace-nowrap">
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-10 h-10 bg-primary/10 flex items-center justify-center">
                                            @if($collection->photo_url)
                                                <img src="{{ asset('storage/' . $collection->photo_url) }}" alt="{{ $collection->name }}" />
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20h6M9 4h6M10 4v4c-2 1-3.5 3-3.5 5.5S8 19 12 19s5.5-3 5.5-5.5S14 9 12 8V4M16 11c1.5-1 3-1 3-1s-1 2-2.5 3" />
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2 whitespace-nowrap">
                                        <div class="font-bold text-base-content whitespace-nowrap">{{ $collection->name }}</div>
                                        @if($collection->type === 'pola')
                                            <span class="badge badge-accent badge-xs font-semibold whitespace-nowrap">Pola</span>
                                        @else
                                            <span class="badge badge-info badge-xs font-semibold text-white whitespace-nowrap">Koleksi</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-base-content/50 truncate max-w-xs" title="{{ $collection->slug }}">{{ $collection->slug }}</div>
                                </td>
                                <td class="whitespace-nowrap">
                                    @if($collection->category)
                                        <span class="badge text-white badge-sm font-semibold whitespace-nowrap" style="background-color: {{ $collection->category->color_hex ?? '#6B7280' }}">
                                            {{ $collection->category->name }}
                                        </span>
                                    @else
                                        <span class="text-base-content/40">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $collection->artisan->name ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $collection->year ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap">
                                    @if($collection->status === 'published')
                                        <span class="badge badge-success badge-sm text-white font-medium whitespace-nowrap">Published</span>
                                    @else
                                        <span class="badge badge-warning badge-sm text-white font-medium whitespace-nowrap">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.collections.edit', $collection) }}" class="btn btn-ghost btn-xs text-primary gap-1 hover:bg-primary/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <button type="button" 
                                                x-on:click="$dispatch('open-delete-modal', { url: '{{ route('admin.collections.destroy', $collection) }}', name: '{{ addslashes($collection->name) }}' })"
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
                    Menampilkan {{ $collections->firstItem() }} - {{ $collections->lastItem() }} dari {{ $collections->total() }} koleksi
                </div>
                <div class="join">
                    {{ $collections->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>
@endsection
