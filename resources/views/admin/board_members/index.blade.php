@extends('layouts.admin')

@section('title', 'Info Pengurus')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Info Pengurus</span></li>
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Info Pengurus</h1>
            <p class="text-xs text-base-content/60 font-sans">Kelola data pengurus BUMDes, KIM, dan aparat desa Sitiwinangun</p>
        </div>
        <div>
            <a href="{{ route('admin.board-members.create') }}" class="btn btn-primary text-white gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengurus
            </a>
        </div>
    </div>

    {{-- Filter/Search bar --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm mb-6">
        <div class="card-body p-4">
            <form x-data="{ q: '{{ request('q') }}' }" 
                  x-ref="form"
                  action="{{ route('admin.board-members.index') }}" 
                  method="GET" 
                  class="flex flex-col sm:flex-row gap-3">
                
                {{-- Search text --}}
                <div class="form-control flex-1">
                    <div class="relative w-full">
                        <input type="text" 
                               name="q" 
                               x-model="q"
                               x-on:input.debounce.500ms="$refs.form.submit()"
                               placeholder="Cari nama pengurus atau jabatan..." 
                               class="input input-bordered w-full pr-10" />
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-base-content/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-neutral px-6 shadow-sm">Cari</button>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.board-members.index') }}" class="btn btn-ghost" title="Reset pencarian">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Data Table / Empty State --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm">
        @if($members->isEmpty())
            <div class="card-body py-12 text-center flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-base-content/30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="text-lg font-bold text-base-content font-serif">Belum Ada Pengurus</h3>
                <p class="text-sm text-base-content/60 max-w-sm mt-1">Data pengurus kosong atau pencarian tidak menemukan hasil.</p>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('admin.board-members.create') }}" class="btn btn-primary btn-sm text-white">Tambah Pengurus</a>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.board-members.index') }}" class="btn btn-ghost btn-sm">Reset Pencarian</a>
                    @endif
                </div>
            </div>
        @else
            <div class="overflow-x-auto w-full">
                <table class="table table-zebra w-full text-sm min-w-[900px]">
                    <thead>
                        <tr class="text-base-content/70">
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th class="text-center">Urutan Tampil</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                            <tr class="hover:bg-base-200/50 transition-colors">
                                <td>
                                    @if($member->photo_url)
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-10 h-10 bg-base-300">
                                                <img src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}" />
                                            </div>
                                        </div>
                                    @else
                                        <div class="avatar placeholder">
                                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary font-bold font-serif text-sm flex items-center justify-center">
                                                <span>{{ collect(explode(' ', $member->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-bold text-base-content whitespace-nowrap">{{ $member->name }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-outline h-auto py-1.5 px-3 text-center whitespace-normal leading-tight max-w-[180px] inline-flex font-medium">{{ $member->position }}</span>
                                </td>
                                <td class="font-sans text-xs whitespace-nowrap">
                                    {{ $member->phone ?? '-' }}
                                </td>
                                <td class="font-sans text-xs whitespace-nowrap">
                                    {{ $member->email ?? '-' }}
                                </td>
                                <td class="text-center font-semibold font-sans whitespace-nowrap">
                                    {{ $member->sort_order }}
                                </td>
                                <td class="text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.board-members.edit', $member) }}" class="btn btn-ghost btn-xs text-primary gap-1 hover:bg-primary/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <button type="button" 
                                                x-on:click="$dispatch('open-delete-modal', { url: '{{ route('admin.board-members.destroy', $member) }}', name: '{{ addslashes($member->name) }}' })"
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
            @if($members->hasPages())
                <div class="card-body p-4 border-t border-base-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-xs text-base-content/60">
                        Menampilkan {{ $members->firstItem() }} - {{ $members->lastItem() }} dari {{ $members->total() }} pengurus
                    </div>
                    <div class="join">
                        {{ $members->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
