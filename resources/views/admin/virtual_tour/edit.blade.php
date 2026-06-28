@extends('layouts.admin')

@section('title', 'Setup Virtual Tour 360°')

@section('breadcrumb')
    <li><a href="{{ route('admin.virtual-tour.index') }}">Virtual Tour 360°</a></li>
    <li><span class="text-primary font-medium">Setup Embed</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Setup Virtual Tour 360°</h1>
        <p class="text-xs text-base-content/60 font-sans">Konfigurasi atau perbarui kode penyisipan (embed) Virtual Tour 360 derajat</p>
    </div>

    <form action="{{ route('admin.virtual-tour.update') }}" 
          method="POST" 
          x-data="{ 
              embedCode: '{{ addslashes(old('embed_code', $tour->embed_code ?? '')) }}',
              isPreviewLoading: false,
              previewContent: '{{ addslashes(old('embed_code') ? '' : ($tour->sanitized_code ?? '')) }}',
              previewError: '',
              getPreview() {
                  if (!this.embedCode.trim()) {
                      this.previewError = 'Kode embed tidak boleh kosong untuk memuat pratinjau.';
                      return;
                  }
                  
                  this.isPreviewLoading = true;
                  this.previewContent = '';
                  this.previewError = '';
                  
                  fetch('{{ route('admin.virtual-tour.preview') }}', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': '{{ csrf_token() }}',
                          'Accept': 'application/json'
                      },
                      body: JSON.stringify({
                          embed_code: this.embedCode
                      })
                  })
                  .then(res => {
                      if (!res.ok) {
                          return res.json().then(err => { throw new Error(err.message || 'Sanitizer menolak kode embed.'); });
                      }
                      return res.json();
                  })
                  .then(data => {
                      if (data.success) {
                          this.previewContent = data.sanitized_code;
                      } else {
                          this.previewError = data.message || 'Gagal memuat pratinjau.';
                      }
                  })
                  .catch(err => {
                      this.previewError = err.message || 'Terjadi kesalahan jaringan atau validasi.';
                  })
                  .finally(() => {
                      this.isPreviewLoading = false;
                  });
              }
          }"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @method('PUT')

        {{-- Main Area (Left Column) --}}
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            {{-- Form Fields --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Konfigurasi Embed
                    </h3>
                    
                    {{-- Judul --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-semibold">Judul Virtual Tour <span class="text-error">*</span></span></label>
                        <input type="text" 
                               name="title" 
                               value="{{ old('title', $tour->title ?? '') }}"
                               placeholder="Contoh: Tur Virtual Museum Gerabah Sitiwinangun" 
                               class="input input-bordered w-full" 
                               required />
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-semibold">Deskripsi Singkat</span></label>
                        <textarea name="description" 
                                  placeholder="Tulis info singkat mengenai area atau cakupan tur 360 ini..." 
                                  class="textarea textarea-bordered w-full h-20">{{ old('description', $tour->description ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        {{-- Tipe Embed --}}
                        <div class="form-control w-full md:col-span-1">
                            <label class="label"><span class="label-text font-semibold">Tipe Penyelipan <span class="text-error">*</span></span></label>
                            <select name="embed_type" class="select select-bordered w-full" required>
                                <option value="pannellum" {{ old('embed_type', $tour->embed_type ?? '') === 'pannellum' ? 'selected' : '' }}>Pannellum</option>
                                <option value="marzipano" {{ old('embed_type', $tour->embed_type ?? '') === 'marzipano' ? 'selected' : '' }}>Marzipano</option>
                                <option value="iframe" {{ old('embed_type', $tour->embed_type ?? '') === 'iframe' ? 'selected' : '' }}>Iframe</option>
                                <option value="custom_html" {{ old('embed_type', $tour->embed_type ?? '') === 'custom_html' ? 'selected' : '' }}>Custom HTML</option>
                            </select>
                        </div>
                    </div>

                    {{-- Embed Code Monospace Textarea --}}
                    <div class="form-control w-full">
                        <label class="label flex justify-between items-center">
                            <span class="label-text font-semibold">Kode Embed (Iframe / HTML Script) <span class="text-error">*</span></span>
                            <span class="text-[10px] text-base-content/40 font-mono">XSS Sanitizer Active</span>
                        </label>
                        <textarea name="embed_code" 
                                  x-model="embedCode"
                                  placeholder="Sematkan kode iframe di sini. Contoh: <iframe src='...'></iframe>" 
                                  class="textarea textarea-bordered w-full h-48 font-mono text-sm leading-relaxed" 
                                  required></textarea>
                    </div>
                </div>
            </div>

            {{-- Preview Box --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between mb-4 border-b border-base-200 pb-2">
                        <h3 class="card-title text-base font-bold font-serif text-base-content">
                            Pratinjau Kode Embed
                        </h3>
                        <button type="button" 
                                x-on:click="getPreview()"
                                class="btn btn-neutral btn-sm shadow-sm gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Generate Preview
                        </button>
                    </div>

                    {{-- Iframe / Render Preview --}}
                    <div class="aspect-video w-full rounded-btn border border-base-300 overflow-hidden bg-black flex items-center justify-center relative">
                        {{-- Loading spinner --}}
                        <div x-show="isPreviewLoading" class="absolute inset-0 bg-black/60 flex items-center justify-center z-10" style="display: none;">
                            <span class="loading loading-spinner loading-lg text-primary"></span>
                        </div>

                        {{-- Rendered Sanitized Iframe --}}
                        <div x-html="previewContent" class="w-full h-full" x-show="previewContent && !previewError"></div>

                        {{-- Sanitizer Error message --}}
                        <div x-show="previewError" class="p-6 text-center text-error max-w-sm" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="text-xs font-semibold" x-text="previewError"></span>
                        </div>

                        {{-- Initial State / Empty preview --}}
                        <div x-show="!previewContent && !previewError && !isPreviewLoading" class="text-center text-xs text-white/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-2 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>Klik tombol "Generate Preview" untuk memuat pratinjau</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Sidebar (Right Column) --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            {{-- Status & Info --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Status & Visibilitas
                    </h3>
                    
                    {{-- Active status checkbox --}}
                    <div class="form-control">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   class="checkbox checkbox-success shadow-sm" 
                                   {{ old('is_active', $tour->is_active ?? true) ? 'checked' : '' }} />
                            <span class="label-text font-semibold">Aktifkan Tour</span>
                        </label>
                        <span class="text-xs text-base-content/50 pl-8">Tampilkan Virtual Tour di halaman publik utama website</span>
                    </div>
                </div>
            </div>

            {{-- Submit / Action Card --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-4 flex flex-col gap-2">
                    <button type="submit" class="btn btn-primary text-white w-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Simpan & Aktifkan
                    </button>
                    <a href="{{ route('admin.virtual-tour.index') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
