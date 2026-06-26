@extends('layouts.admin')

@section('title', 'Tambah Koleksi')

@section('breadcrumb')
    <li><a href="{{ route('admin.collections.index') }}">Koleksi Kriya</a></li>
    <li><span class="text-primary font-medium">Tambah Koleksi</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Tambah Koleksi</h1>
        <p class="text-xs text-base-content/60 font-sans">Tambahkan karya kriya atau gerabah baru ke dalam sistem informasi digital</p>
    </div>

    <form action="{{ route('admin.collections.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          x-data="{ 
              type: '{{ old('type', 'koleksi') }}',
              name: '{{ old('name', '') }}', 
              slug: '{{ old('slug', '') }}',
              photoPreview: null,
              desc: '{{ old('description', '') }}',
              slugManual: false
          }"
          x-init="
              $watch('name', value => {
                  if (!slugManual) {
                      slug = value.toLowerCase()
                          .replace(/[^a-z0-9]+/g, '-')
                          .replace(/(^-|-$)/g, '');
                  }
              })
          "
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf

        {{-- Form Main Area (Left Column) --}}
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            {{-- Section 1: Identitas --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Identitas Koleksi
                    </h3>
                    
                    {{-- Tipe Galeri --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-semibold">Tipe Galeri <span class="text-error">*</span></span></label>
                        <div class="flex gap-6 items-center">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="type" value="koleksi" x-model="type" class="radio radio-primary" />
                                <span class="text-sm font-medium">Koleksi Gerabah (Karya Fisik)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="type" value="pola" x-model="type" class="radio radio-primary" />
                                <span class="text-sm font-medium">Pola Motif Gerabah (Sketsa/Ukiran)</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama Koleksi --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Nama Motif/Objek <span class="text-error">*</span></span></label>
                            <input type="text" 
                                   name="name" 
                                   x-model="name"
                                   placeholder="Contoh: Gentong Wadasan" 
                                   class="input input-bordered w-full" 
                                   required />
                        </div>

                        {{-- Slug --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">URL Slug <span class="text-error">*</span></span></label>
                            <input type="text" 
                                   name="slug" 
                                   x-model="slug"
                                   x-on:input="slugManual = true"
                                   placeholder="gentong-wadasan" 
                                   class="input input-bordered w-full" 
                                   required />
                        </div>

                        {{-- Kategori --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Kategori Kriya <span class="text-error">*</span></span></label>
                            <select name="category_id" class="select select-bordered w-full" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tahun --}}
                        <div class="form-control w-full" x-show="type === 'koleksi'">
                            <label class="label"><span class="label-text font-semibold">Tahun Pembuatan <span class="text-error">*</span></span></label>
                            <input type="number" 
                                   name="year" 
                                   min="1800" 
                                   max="{{ date('Y') }}" 
                                   value="{{ old('year', date('Y')) }}" 
                                   class="input input-bordered w-full" 
                                   :required="type === 'koleksi'" />
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-control mt-4">
                        <label class="label"><span class="label-text font-semibold">Status Publikasi <span class="text-error">*</span></span></label>
                        <div class="flex gap-4 items-center">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="draft" class="radio radio-warning" {{ old('status', 'draft') === 'draft' ? 'checked' : '' }} />
                                <span class="text-sm">Draft (Internal)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="published" class="radio radio-success" {{ old('status') === 'published' ? 'checked' : '' }} />
                                <span class="text-sm">Published (Publik)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 3: Konten & Cerita --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Konten & Cerita
                    </h3>
                    
                    {{-- Deskripsi Singkat --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-semibold">Deskripsi Singkat <span class="text-error">*</span></span></label>
                        <textarea name="description" 
                                  x-model="desc" 
                                  maxlength="500" 
                                  placeholder="Tulis ringkasan singkat koleksi (maks 500 karakter)..." 
                                  class="textarea textarea-bordered w-full h-24" 
                                  required>{{ old('description') }}</textarea>
                        <div class="text-right text-xs text-base-content/50 mt-1">
                            <span x-text="desc.length"></span>/500 karakter
                        </div>
                    </div>

                    {{-- Sejarah & Asal-usul --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-semibold">Sejarah & Asal-usul <span class="text-error">*</span></span></label>
                        <textarea name="history_origin" 
                                  placeholder="Ceritakan latar belakang sejarah dan asal-usul objek kriya ini..." 
                                  class="textarea textarea-bordered w-full h-32" 
                                  required>{{ old('history_origin') }}</textarea>
                    </div>

                    {{-- Filosofi --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-semibold">Makna Filosofis (Opsional)</span></label>
                        <textarea name="philosophy" 
                                  placeholder="Jelaskan makna simbolik, ornamen, atau filosofi di balik motif..." 
                                  class="textarea textarea-bordered w-full h-24">{{ old('philosophy') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 gap-4" :class="type === 'koleksi' ? 'md:grid-cols-2' : 'md:grid-cols-1'">
                        {{-- Teknik Produksi --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Teknik Produksi <span class="text-error">*</span></span></label>
                            <textarea name="technique" 
                                      placeholder="Contoh: Teknik pilin (coiling), pembakaran tungku tradisional..." 
                                      class="textarea textarea-bordered w-full h-24" 
                                      required>{{ old('technique') }}</textarea>
                        </div>

                        {{-- Bahan --}}
                        <div class="form-control w-full" x-show="type === 'koleksi'">
                            <label class="label"><span class="label-text font-semibold">Bahan Pembuatan <span class="text-error">*</span></span></label>
                            <textarea name="materials" 
                                      placeholder="Contoh: Tanah liat merah lokal, pasir halus, glasir..." 
                                      class="textarea textarea-bordered w-full h-24" 
                                      :required="type === 'koleksi'">{{ old('materials') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Form Sidebar Area (Right Column) --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            {{-- Section 2: Upload Foto --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Foto Koleksi
                    </h3>
                    
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Upload Gambar <span class="text-error">*</span></span></label>
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
                               class="file-input file-input-bordered w-full file-input-primary" 
                               required />
                        <span class="label-text-alt mt-1.5 text-base-content/50">Maks. 5MB (JPG, JPEG, PNG, WEBP)</span>
                    </div>

                    {{-- Image Preview --}}
                    <div class="mt-4 border-2 border-dashed border-base-300 rounded-btn p-2 flex items-center justify-center min-h-40 bg-base-200/40">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="max-w-full max-h-48 rounded-btn object-cover shadow-sm" />
                        </template>
                        <template x-if="!photoPreview">
                            <div class="text-center text-xs text-base-content/40 flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Preview foto akan muncul di sini</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Section 4: Pengrajin & Lokasi --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm" x-show="type === 'koleksi'">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Pengrajin & Lokasi
                    </h3>
                    
                    {{-- Pengrajin --}}
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Pengrajin Pembuat <span class="text-error">*</span></span></label>
                        <select name="artisan_id" class="select select-bordered w-full" :required="type === 'koleksi'">
                            <option value="" disabled selected>Pilih Pengrajin</option>
                            @foreach($artisans as $artisan)
                                <option value="{{ $artisan->id }}" {{ old('artisan_id') == $artisan->id ? 'selected' : '' }}>
                                    {{ $artisan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lokasi --}}
                    <div class="form-control w-full mt-3">
                        <label class="label"><span class="label-text font-semibold">Lokasi Pembuatan <span class="text-error">*</span></span></label>
                        <input type="text" 
                               name="location" 
                               value="{{ old('location', 'Desa Sitiwinangun, Cirebon') }}" 
                               placeholder="Contoh: Blok Pejaten, Desa Sitiwinangun" 
                               class="input input-bordered w-full" 
                               :required="type === 'koleksi'" />
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
                        Simpan Koleksi
                    </button>
                    <a href="{{ route('admin.collections.index') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
