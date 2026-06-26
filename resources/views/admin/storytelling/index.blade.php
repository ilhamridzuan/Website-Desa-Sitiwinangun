@extends('layouts.admin')

@section('title', 'Storytelling PDF')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Storytelling PDF</span></li>
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Storytelling PDF</h1>
            <p class="text-xs text-base-content/60 font-sans">Kelola dokumen PDF katalog storytelling yang tampil di halaman publik</p>
        </div>
        <div>
            <a href="{{ route('admin.storytelling.create') }}" class="btn btn-primary text-white gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Upload Dokumen Baru
            </a>
        </div>
    </div>

    {{-- Info Banner --}}
    <div class="alert alert-info alert-soft mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm">Dokumen ini tampil di halaman publik <strong>Storytelling</strong> sebagai unduhan untuk pengunjung.</span>
    </div>

    {{-- Search bar --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm mb-6">
        <div class="card-body p-4">
            <form action="{{ route('admin.storytelling.index') }}" method="GET"
                  x-data="{ q: '{{ request('q') }}' }"
                  x-ref="searchForm"
                  class="flex flex-col sm:flex-row gap-3">
                <div class="form-control flex-1 relative">
                    <input type="text"
                           name="q"
                           x-model="q"
                           x-on:input.debounce.500ms="$refs.searchForm.submit()"
                           placeholder="Cari judul dokumen..."
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
                        <a href="{{ route('admin.storytelling.index') }}" class="btn btn-ghost">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Table / Empty State --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm">
        @if($docs->isEmpty())
            <div class="card-body py-16 text-center flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-base-content/25 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-bold text-base-content font-serif mb-1">Belum Ada Dokumen</h3>
                <p class="text-sm text-base-content/55 max-w-sm">Belum ada dokumen PDF storytelling yang diunggah. Mulai tambahkan dokumen pertama untuk ditampilkan di halaman publik.</p>
                <div class="mt-5 flex gap-2">
                    <a href="{{ route('admin.storytelling.create') }}" class="btn btn-primary btn-sm text-white">
                        Upload Dokumen Pertama
                    </a>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.storytelling.index') }}" class="btn btn-ghost btn-sm">Reset Filter</a>
                    @endif
                </div>
            </div>
        @else
            <div class="overflow-x-auto w-full">
                <table class="table table-zebra w-full text-sm">
                    <thead>
                        <tr class="text-base-content/70">
                            <th class="w-10 text-center">No</th>
                            <th>Judul Dokumen</th>
                            <th class="max-w-xs">Deskripsi</th>
                            <th class="text-center">File PDF</th>
                            <th class="text-center w-20">Urutan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($docs as $index => $doc)
                            <tr class="hover:bg-base-200/50 transition-colors">
                                <td class="text-center font-sans text-base-content/60">
                                    {{ $docs->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="font-bold text-base-content">{{ $doc->title }}</div>
                                    <div class="text-xs text-base-content/50 mt-0.5">
                                        Diunggah {{ $doc->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="max-w-xs">
                                    <span class="text-xs text-base-content/70 line-clamp-2" title="{{ $doc->description }}">
                                        {{ $doc->description ? Str::limit($doc->description, 80) : '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($doc->pdf_url)
                                        <a href="{{ asset('storage/' . $doc->pdf_url) }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-ghost btn-xs text-info gap-1 hover:bg-info/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            Lihat PDF
                                        </a>
                                    @else
                                        <span class="badge badge-ghost badge-sm">Tidak Ada</span>
                                    @endif
                                </td>
                                <td class="text-center font-sans font-semibold">
                                    {{ $doc->sort_order ?? 0 }}
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.storytelling.edit', $doc) }}" class="btn btn-ghost btn-xs text-primary gap-1 hover:bg-primary/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <button type="button"
                                                x-on:click="$dispatch('open-delete-modal', { url: '{{ route('admin.storytelling.destroy', $doc) }}', name: '{{ addslashes($doc->title) }}' })"
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
            @if($docs->hasPages())
                <div class="card-body p-4 border-t border-base-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-xs text-base-content/60">
                        Menampilkan {{ $docs->firstItem() }} - {{ $docs->lastItem() }} dari {{ $docs->total() }} dokumen
                    </div>
                    <div class="join">
                        {{ $docs->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
