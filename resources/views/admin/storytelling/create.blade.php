@extends('layouts.admin')

@section('title', 'Upload Dokumen Storytelling')

@section('breadcrumb')
    <li><a href="{{ route('admin.storytelling.index') }}">Storytelling PDF</a></li>
    <li><span class="text-primary font-medium">Upload Dokumen Baru</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Upload Dokumen Storytelling</h1>
        <p class="text-xs text-base-content/60 font-sans">Tambahkan dokumen PDF baru yang akan tampil sebagai unduhan di halaman publik Storytelling</p>
    </div>

    @include('admin.partials._form-errors')

    <form action="{{ route('admin.storytelling.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf

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
                                   value="{{ old('title') }}"
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
                                      class="textarea textarea-bordered h-24 w-full">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Upload PDF --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm"
                 x-data="{ fileName: null, fileSize: null, hasError: false }">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        File PDF <span class="text-error">*</span>
                    </h3>

                    <div class="form-control w-full">
                        {{-- Drop Zone --}}
                        <label for="pdf-upload"
                               class="flex flex-col items-center justify-center border-2 border-dashed rounded-btn p-8 cursor-pointer transition-colors"
                               :class="fileName ? 'border-success bg-success/5' : 'border-base-300 hover:border-primary/50 hover:bg-base-200/40'">
                            <template x-if="!fileName">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/30 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm font-semibold text-base-content">Klik untuk pilih file PDF</p>
                                    <p class="text-xs text-base-content/50 mt-1">atau drag & drop ke sini</p>
                                </div>
                            </template>
                            <template x-if="fileName">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-success mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-bold text-success" x-text="fileName"></p>
                                    <p class="text-xs text-base-content/50 mt-1" x-text="fileSize"></p>
                                    <p class="text-xs text-base-content/40 mt-1">Klik untuk ganti file</p>
                                </div>
                            </template>
                        </label>

                        <input type="file"
                               id="pdf-upload"
                               name="pdf"
                               accept=".pdf"
                               class="hidden"
                               required
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
                                <span class="text-sm">Ukuran file melebihi batas maksimum 10MB. Pilih file yang lebih kecil.</span>
                            </div>
                        </template>

                        {{-- Info format --}}
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
                               value="{{ old('sort_order', 0) }}"
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload Dokumen
                    </button>
                    <a href="{{ route('admin.storytelling.index') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
