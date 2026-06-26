@extends('layouts.admin')

@section('title', 'Edit Dokumen Storytelling')

@section('breadcrumb')
    <li><a href="{{ route('admin.storytelling.index') }}">Storytelling PDF</a></li>
    <li><span class="text-primary font-medium">Edit Dokumen</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Edit Dokumen Storytelling</h1>
        <p class="text-xs text-base-content/60 font-sans">Perbarui data dokumen: <strong class="text-base-content font-serif">{{ $doc->title }}</strong></p>
    </div>

    @include('admin.partials._form-errors')

    <form action="{{ route('admin.storytelling.update', $doc) }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @method('PUT')

        {{-- Left Column — Main Fields --}}
        <div class="lg:col-span-8 flex flex-col gap-6">

            {{-- Info Dokumen --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Informasi Dokumen
                    </h3>

                    <div class="flex flex-col gap-4">
                        {{-- Judul --}}
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Judul Dokumen <span class="text-error">*</span></span>
                            </label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $doc->title) }}"
                                   placeholder="Contoh: Katalog Gerabah Sitiwinangun 2025"
                                   class="input input-bordered w-full"
                                   required />
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Deskripsi Singkat <span class="text-base-content/50 font-normal">(Opsional)</span></span>
                            </label>
                            <textarea name="description"
                                      placeholder="Deskripsi singkat tentang isi dokumen ini..."
                                      class="textarea textarea-bordered h-24 w-full">{{ old('description', $doc->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Upload PDF (opsional — ganti file lama) --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm"
                 x-data="{ fileName: null, fileSize: null, hasError: false }">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-1 text-base-content border-b border-base-200 pb-2">
                        File PDF
                    </h3>
                    <p class="text-xs text-base-content/50 mb-4">Upload PDF baru hanya jika ingin mengganti file lama. Kosongkan jika tidak ada perubahan.</p>

                    {{-- File Lama --}}
                    @if($doc->pdf_url)
                        <div class="flex items-center gap-3 p-3 bg-base-200/60 rounded-btn mb-4 border border-base-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-error/70 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs text-base-content/50 mb-0.5">File PDF saat ini:</div>
                                <div class="text-sm font-semibold text-base-content truncate">{{ basename($doc->pdf_url) }}</div>
                            </div>
                            <a href="{{ asset('storage/' . $doc->pdf_url) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="btn btn-ghost btn-xs text-info gap-1 hover:bg-info/10 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Lihat PDF saat ini
                            </a>
                        </div>
                    @endif

                    <div class="form-control w-full">
                        {{-- Drop Zone --}}
                        <label for="pdf-upload-edit"
                               class="flex flex-col items-center justify-center border-2 border-dashed rounded-btn p-6 cursor-pointer transition-colors"
                               :class="fileName ? 'border-success bg-success/5' : 'border-base-300 hover:border-primary/50 hover:bg-base-200/40'">
                            <template x-if="!fileName">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/25 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <p class="text-sm font-semibold text-base-content">Klik untuk pilih file PDF baru</p>
                                    <p class="text-xs text-base-content/45 mt-1">Biarkan kosong jika tidak ingin mengganti file</p>
                                </div>
                            </template>
                            <template x-if="fileName">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-success mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-bold text-success" x-text="fileName"></p>
                                    <p class="text-xs text-base-content/50 mt-0.5" x-text="fileSize"></p>
                                    <p class="text-xs text-base-content/40 mt-1">Klik untuk ganti pilihan</p>
                                </div>
                            </template>
                        </label>

                        <input type="file"
                               id="pdf-upload-edit"
                               name="pdf"
                               accept=".pdf"
                               class="hidden"
                               @change="
                                    const file = $event.target.files[0];
                                    if (file) {
                                        if (file.size > 10 * 1024 * 1024) {
                                            hasError = true;
                                            fileName = null;
                                            fileSize = null;
                                        } else {
                                            hasError = false;
                                            fileName = file.name;
                                            fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                                        }
                                    }
                               " />

                        {{-- Error ukuran file --}}
                        <template x-if="hasError">
                            <div class="alert alert-error alert-soft mt-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm">Ukuran file melebihi batas maksimum 10MB.</span>
                            </div>
                        </template>

                        <div class="mt-3 flex flex-wrap gap-2 text-xs text-base-content/50">
                            <span class="badge badge-ghost badge-sm">Format: PDF (.pdf)</span>
                            <span class="badge badge-ghost badge-sm">Maks. ukuran: 10 MB</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right Column — Settings & Actions --}}
        <div class="lg:col-span-4 flex flex-col gap-6">

            {{-- Metadata --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm text-xs">
                <div class="card-body p-4 text-base-content/70 space-y-2">
                    <div class="flex justify-between py-1 border-b border-base-200">
                        <span>Diunggah Pada:</span>
                        <span class="font-semibold text-base-content">{{ $doc->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Pembaruan Terakhir:</span>
                        <span class="font-semibold text-base-content">{{ $doc->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Pengaturan --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Pengaturan
                    </h3>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold text-base-content">Urutan Tampil</span>
                        </label>
                        <input type="number"
                               name="sort_order"
                               value="{{ old('sort_order', $doc->sort_order) }}"
                               min="0"
                               class="input input-bordered w-full" />
                        <span class="label-text-alt mt-1.5 text-base-content/45">Angka lebih kecil tampil paling atas.</span>
                    </div>
                </div>
            </div>

            {{-- Submit Actions --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-4 flex flex-col gap-2">
                    <button type="submit" class="btn btn-primary text-white w-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.2" />
                        </svg>
                        Perbarui Dokumen
                    </button>
                    <a href="{{ route('admin.storytelling.index') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
