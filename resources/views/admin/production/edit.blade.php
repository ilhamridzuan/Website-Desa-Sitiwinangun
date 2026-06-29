@extends('layouts.admin')

@section('title', 'Edit Tahap Produksi')

@section('breadcrumb')
    <li><a href="{{ route('admin.production.index') }}">Proses Produksi</a></li>
    <li><span class="text-primary font-medium">Edit Tahap {{ $stage->stage_number }}</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Edit Tahap Produksi</h1>
        <p class="text-xs text-base-content/60 font-sans">Perbarui narasi dan dokumentasi visual untuk tahap pembuatan gerabah</p>
    </div>

    @php
        $prevStage = \App\Models\ProductionStage::where('stage_number', $stage->stage_number - 1)->first();
        $nextStage = \App\Models\ProductionStage::where('stage_number', $stage->stage_number + 1)->first();
    @endphp

    <form action="{{ route('admin.production.update', $stage) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          x-data="{ 
              photoPreview: null
          }"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @method('PUT')

        {{-- Main Area (Left Column) --}}
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            {{-- Form Fields --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <div class="flex items-center gap-3 border-b border-base-200 pb-4 mb-4">
                        <span class="badge badge-primary badge-lg font-bold text-white shadow-sm p-3">Tahap {{ $stage->stage_number }}</span>
                        <h3 class="card-title text-base font-bold font-serif text-base-content">
                            Konten Tahapan
                        </h3>
                    </div>
                    
                    {{-- Judul Tahap --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-semibold">Judul Tahap <span class="text-error">*</span></span></label>
                        <input type="text" 
                               name="title" 
                               value="{{ old('title', $stage->title) }}"
                               placeholder="Contoh: Pengambilan Tanah Liat" 
                               class="input input-bordered w-full" 
                               required />
                    </div>

                    {{-- Deskripsi/Narasi --}}
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Narasi / Deskripsi Proses <span class="text-error">*</span></span></label>
                        <textarea name="description" 
                                  placeholder="Jelaskan proses kerja, metode, serta keunikan pada tahapan produksi ini..." 
                                  class="textarea textarea-bordered w-full h-64 leading-relaxed" 
                                  required>{{ old('description', $stage->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Navigasi Tahap --}}
            <div class="flex justify-between items-center bg-base-100 border border-base-300 shadow-sm rounded-box p-4">
                <div>
                    @if($prevStage)
                        <a href="{{ route('admin.production.edit', $prevStage) }}" class="btn btn-ghost btn-sm gap-1 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Tahap {{ $prevStage->stage_number }}: {{ $prevStage->title }}
                        </a>
                    @endif
                </div>
                <div>
                    @if($nextStage)
                        <a href="{{ route('admin.production.edit', $nextStage) }}" class="btn btn-ghost btn-sm gap-1 text-primary">
                            Tahap {{ $nextStage->stage_number }}: {{ $nextStage->title }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

        </div>

        {{-- Sidebar (Right Column) --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            {{-- Foto Tahapan --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Foto Tahapan
                    </h3>
                    
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Ganti Gambar (Opsional)</span></label>
                        <input type="file" 
                               name="photo" 
                               accept="image/*"
                               @change="
                                   const file = $event.target.files[0];
                                   if (file) {
                                       const reader = new FileReader();
                                       reader.onload = (e) => { photoPreview = e.target.result; };
                                       reader.readAsDataURL(file);
                                   }
                               "
                               class="file-input file-input-bordered w-full file-input-primary" />
                        <span class="label-text-alt mt-1.5 text-base-content/50">Maks. 5MB (JPG, JPEG, PNG, WEBP)</span>
                    </div>

                    {{-- Image Preview / Current Image --}}
                    <div class="mt-4 border-2 border-dashed border-base-300 rounded-btn p-2 flex flex-col items-center justify-center min-h-40 bg-base-200/40">
                        <template x-if="photoPreview">
                            <div class="text-center w-full">
                                <span class="text-xs text-success font-semibold block mb-2">Pratinjau Foto Baru:</span>
                                <img :src="photoPreview" class="max-w-full max-h-48 rounded-btn object-cover shadow-sm mx-auto" />
                            </div>
                        </template>
                        <template x-if="!photoPreview">
                            <div class="text-center w-full">
                                <span class="text-xs text-base-content/50 block mb-2">Foto Saat Ini:</span>
                                <img src="{{ $stage->photo_url ? asset('storage/' . $stage->photo_url) : asset('images/placeholder-stage.jpg') }}" 
                                     alt="{{ $stage->title }}" 
                                     class="max-w-full max-h-48 rounded-btn object-cover shadow-sm mx-auto bg-base-300" />
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Metadata --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm text-xs">
                <div class="card-body p-4 text-base-content/70 space-y-2">
                    <div class="flex justify-between py-1">
                        <span>Pembaruan Terakhir:</span>
                        <span class="font-semibold text-base-content">
                            {{ $stage->updated_at ? $stage->updated_at->format('d M Y, H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Submit / Action Card --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-4 flex flex-col gap-2">
                    <button type="submit" class="btn btn-primary text-white w-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.production.index') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
