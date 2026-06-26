@extends('layouts.admin')

@section('title', 'Proses Produksi Gerabah')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Proses Produksi</span></li>
@endsection

@section('content')
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Proses Produksi Gerabah</h1>
            <p class="text-xs text-base-content/60 font-sans">Kelola narasi dan foto 5 tahapan utama pembuatan gerabah khas Sitiwinangun</p>
        </div>
    </div>

    {{-- Alert --}}
    <div class="alert alert-info shadow-sm mb-6 text-white font-medium flex gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Pemberitahuan: Kelima tahapan produksi ini merupakan tahapan baku dan tidak dapat ditambah atau dihapus. Anda hanya dapat melakukan pembaruan konten.</span>
    </div>

    {{-- Stages list --}}
    <div class="flex flex-col gap-4">
        @foreach($stages as $stage)
            <div class="card card-side bg-base-100 border border-base-300 shadow-sm hover:border-primary/30 transition-colors overflow-hidden">
                <figure class="w-48 shrink-0 bg-base-200 overflow-hidden relative hidden md:block">
                    <img src="{{ $stage->photo_url ? asset('storage/' . $stage->photo_url) : asset('images/placeholder-stage.jpg') }}" alt="{{ $stage->title }}" class="h-full w-full object-cover" />
                    <div class="absolute top-2 left-2 badge badge-primary font-bold text-white shadow-sm">Tahap {{ $stage->stage_number }}</div>
                </figure>
                <div class="card-body p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
                    <div class="space-y-2 max-w-xl">
                        <div class="flex items-center gap-2 md:hidden">
                            <span class="badge badge-primary font-bold text-white">Tahap {{ $stage->stage_number }}</span>
                        </div>
                        <h2 class="card-title font-serif text-lg font-bold text-base-content">{{ $stage->title }}</h2>
                        <p class="text-xs text-base-content/70 leading-relaxed font-sans line-clamp-2">
                            {{ $stage->description }}
                        </p>
                    </div>
                    <div class="shrink-0 w-full md:w-auto">
                        <a href="{{ route('admin.production.edit', $stage) }}" class="btn btn-neutral btn-sm shadow-sm gap-2 w-full md:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Tahap
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
