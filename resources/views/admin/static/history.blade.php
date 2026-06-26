@extends('layouts.admin')

@section('title', 'Sejarah Sitiwinangun')

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li><span class="text-primary font-medium">Sejarah</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Kelola Narasi Sejarah</h1>
        <p class="text-xs text-base-content/60 font-sans">Perbarui narasi sejarah berdirinya Desa Sitiwinangun dan asal-usul kerajinan gerabah tradisional</p>
    </div>

    @include('admin.partials._form-errors')

    <form action="{{ route('admin.history.update') }}" 
          method="POST"
          x-data="{
              desaContent: '{{ old('desa_content', $desa->content ?? '') }}',
              gerabahContent: '{{ old('gerabah_content', $gerabah->content ?? '') }}',
              desaPreview: false,
              gerabahPreview: false
          }"
          class="flex flex-col gap-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Card 1: Sejarah Desa --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between border-b border-base-200 pb-2 mb-4">
                        <h3 class="card-title text-base font-bold font-serif text-base-content">
                            Sejarah Desa Sitiwinangun
                        </h3>
                        <button type="button" 
                                @click="desaPreview = !desaPreview" 
                                class="btn btn-xs"
                                :class="desaPreview ? 'btn-primary text-white' : 'btn-outline btn-neutral'">
                            <span x-text="desaPreview ? 'Tulis Teks' : 'Pratinjau'"></span>
                        </button>
                    </div>

                    <div x-show="!desaPreview" class="flex flex-col gap-4">
                        {{-- Judul Sejarah Desa --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Judul Halaman / Section <span class="text-error">*</span></span></label>
                            <input type="text" 
                                   name="desa_title" 
                                   value="{{ old('desa_title', $desa->title ?? 'Sejarah Desa Sitiwinangun') }}" 
                                   placeholder="Contoh: Sejarah Desa Sitiwinangun" 
                                   class="input input-bordered w-full" 
                                   required />
                        </div>

                        {{-- Konten Sejarah Desa --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Konten Narasi Sejarah Desa <span class="text-error">*</span></span></label>
                            <textarea name="desa_content" 
                                      x-model="desaContent"
                                      placeholder="Tulis narasi sejarah berdirinya desa Sitiwinangun sejak abad ke-15..." 
                                      class="textarea textarea-bordered w-full h-80 font-sans" 
                                      required></textarea>
                            <label class="label">
                                <span class="label-text-alt text-base-content/50">Mendukung paragraf teks biasa. Tekan Enter 2x untuk paragraf baru.</span>
                            </label>
                        </div>
                    </div>

                    {{-- Simple Preview --}}
                    <div x-show="desaPreview" class="prose max-w-none min-h-[420px] bg-base-200/30 border border-base-300 rounded-btn p-4 overflow-y-auto">
                        <h2 class="text-xl font-bold font-serif mb-3 border-b border-base-300 pb-1 text-base-content">
                            {{ old('desa_title', $desa->title ?? 'Sejarah Desa Sitiwinangun') }}
                        </h2>
                        <div class="text-sm text-base-content whitespace-pre-line font-sans leading-relaxed" x-text="desaContent || 'Belum ada konten.'"></div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Sejarah Gerabah --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between border-b border-base-200 pb-2 mb-4">
                        <h3 class="card-title text-base font-bold font-serif text-base-content">
                            Sejarah Gerabah Sitiwinangun
                        </h3>
                        <button type="button" 
                                @click="gerabahPreview = !gerabahPreview" 
                                class="btn btn-xs"
                                :class="gerabahPreview ? 'btn-primary text-white' : 'btn-outline btn-neutral'">
                            <span x-text="gerabahPreview ? 'Tulis Teks' : 'Pratinjau'"></span>
                        </button>
                    </div>

                    <div x-show="!gerabahPreview" class="flex flex-col gap-4">
                        {{-- Judul Sejarah Gerabah --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Judul Halaman / Section <span class="text-error">*</span></span></label>
                            <input type="text" 
                                   name="gerabah_title" 
                                   value="{{ old('gerabah_title', $gerabah->title ?? 'Sejarah Gerabah Sitiwinangun') }}" 
                                   placeholder="Contoh: Sejarah Gerabah Sitiwinangun" 
                                   class="input input-bordered w-full" 
                                   required />
                        </div>

                        {{-- Konten Sejarah Gerabah --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Konten Narasi Sejarah Gerabah <span class="text-error">*</span></span></label>
                            <textarea name="gerabah_content" 
                                      x-model="gerabahContent"
                                      placeholder="Tulis narasi sejarah awal mula kerajinan gerabah di Sitiwinangun..." 
                                      class="textarea textarea-bordered w-full h-80 font-sans" 
                                      required></textarea>
                            <label class="label">
                                <span class="label-text-alt text-base-content/50">Mendukung paragraf teks biasa. Tekan Enter 2x untuk paragraf baru.</span>
                            </label>
                        </div>
                    </div>

                    {{-- Simple Preview --}}
                    <div x-show="gerabahPreview" class="prose max-w-none min-h-[420px] bg-base-200/30 border border-base-300 rounded-btn p-4 overflow-y-auto">
                        <h2 class="text-xl font-bold font-serif mb-3 border-b border-base-300 pb-1 text-base-content">
                            {{ old('gerabah_title', $gerabah->title ?? 'Sejarah Gerabah Sitiwinangun') }}
                        </h2>
                        <div class="text-sm text-base-content whitespace-pre-line font-sans leading-relaxed" x-text="gerabahContent || 'Belum ada konten.'"></div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Action Bar --}}
        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-base-content/50 font-sans">
                    * Perubahan narasi akan langsung memperbarui tampilan di halaman publik sejarah.
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <a href="{{ route('public.history') }}" target="_blank" class="btn btn-ghost btn-sm sm:btn-md gap-1">
                        Lihat Halaman Publik
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                    <button type="submit" class="btn btn-primary text-white w-full sm:w-auto shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Konten Sejarah
                    </button>
                </div>
            </div>
        </div>

    </form>
@endsection
