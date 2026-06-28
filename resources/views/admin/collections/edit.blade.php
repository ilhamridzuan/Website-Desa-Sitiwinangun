@extends('layouts.admin')

@section('title', 'Edit Koleksi')

@section('breadcrumb')
    <li><a href="{{ route('admin.collections.index') }}">Koleksi Kriya</a></li>
    <li><span class="text-primary font-medium">Edit Koleksi</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Edit Koleksi</h1>
        <p class="text-xs text-base-content/60 font-sans">Perbarui data karya kriya atau gerabah: <strong class="text-base-content font-serif">{{ $collection->name }}</strong></p>
    </div>

    <form action="{{ route('admin.collections.update', $collection) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          x-data="{ 
              type: '{{ old('type', $collection->type) }}',
              name: '{{ old('name', $collection->name) }}', 
              slug: '{{ old('slug', $collection->slug) }}',
              photoPreview: null,
              desc: '{{ old('description', $collection->description) }}',
              slugManual: true
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
        @method('PUT')

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
                                <option value="" disabled>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $collection->category_id) == $category->id ? 'selected' : '' }}>
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
                                   value="{{ old('year', $collection->year) }}" 
                                   class="input input-bordered w-full" 
                                   :required="type === 'koleksi'" />
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-control mt-4">
                        <label class="label"><span class="label-text font-semibold">Status Publikasi <span class="text-error">*</span></span></label>
                        <div class="flex gap-4 items-center">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="draft" class="radio radio-warning" {{ old('status', $collection->status) === 'draft' ? 'checked' : '' }} />
                                <span class="text-sm">Draft (Internal)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="published" class="radio radio-success" {{ old('status', $collection->status) === 'published' ? 'checked' : '' }} />
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
                                  required>{{ old('description', $collection->description) }}</textarea>
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
                                  required>{{ old('history_origin', $collection->history_origin) }}</textarea>
                    </div>

                    {{-- Filosofi --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-semibold">Makna Filosofis (Opsional)</span></label>
                        <textarea name="philosophy" 
                                  placeholder="Jelaskan makna simbolik, ornamen, atau filosofi di balik motif..." 
                                  class="textarea textarea-bordered w-full h-24">{{ old('philosophy', $collection->philosophy) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 gap-4" :class="type === 'koleksi' ? 'md:grid-cols-2' : 'md:grid-cols-1'">
                        {{-- Teknik Produksi --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Teknik Produksi <span class="text-error">*</span></span></label>
                            <textarea name="technique" 
                                      placeholder="Contoh: Teknik pilin (coiling), pembakaran tungku tradisional..." 
                                      class="textarea textarea-bordered w-full h-24" 
                                      required>{{ old('technique', $collection->technique) }}</textarea>
                        </div>

                        {{-- Bahan --}}
                        <div class="form-control w-full" x-show="type === 'koleksi'">
                            <label class="label"><span class="label-text font-semibold">Bahan Pembuatan <span class="text-error">*</span></span></label>
                            <textarea name="materials" 
                                      placeholder="Contoh: Tanah liat merah lokal, pasir halus, glasir..." 
                                      class="textarea textarea-bordered w-full h-24" 
                                      :required="type === 'koleksi'">{{ old('materials', $collection->materials) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Form Sidebar Area (Right Column) --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            {{-- Section 2: Foto --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Foto Koleksi
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
                            <div class="text-center w-full flex flex-col items-center">
                                <span class="text-xs text-base-content/50 block mb-2">Foto Saat Ini:</span>
                                @if($collection->photo_url)
                                    <img src="{{ asset('storage/' . $collection->photo_url) }}" 
                                         alt="{{ $collection->name }}" 
                                         class="max-w-full max-h-48 rounded-btn object-cover shadow-sm mx-auto bg-base-300" />
                                @else
                                    <div class="w-20 h-20 bg-primary/10 rounded-btn flex items-center justify-center shadow-inner">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20h6M9 4h6M10 4v4c-2 1-3.5 3-3.5 5.5S8 19 12 19s5.5-3 5.5-5.5S14 9 12 8V4M16 11c1.5-1 3-1 3-1s-1 2-2.5 3" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-base-content/40 mt-2 block">Belum ada foto koleksi (menggunakan placeholder)</span>
                                @endif
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
                            <option value="" disabled>Pilih Pengrajin</option>
                            @foreach($artisans as $artisan)
                                <option value="{{ $artisan->id }}" {{ old('artisan_id', $collection->artisan_id) == $artisan->id ? 'selected' : '' }}>
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
                               value="{{ old('location', $collection->location) }}" 
                               placeholder="Contoh: Blok Pejaten, Desa Sitiwinangun" 
                               class="input input-bordered w-full" 
                               :required="type === 'koleksi'" />
                    </div>
                </div>
            </div>

            {{-- Section 5: Metadata --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm text-xs">
                <div class="card-body p-4 text-base-content/70 space-y-2">
                    <div class="flex justify-between py-1 border-b border-base-200">
                        <span>Dibuat Oleh:</span>
                        <span class="font-semibold text-base-content">{{ $collection->creator->name ?? 'Sistem' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-base-200">
                        <span>Dibuat Pada:</span>
                        <span class="font-semibold text-base-content">{{ $collection->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Pembaruan Terakhir:</span>
                        <span class="font-semibold text-base-content">{{ $collection->updated_at->format('d M Y, H:i') }}</span>
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
                        Perbarui Koleksi
                    </button>
                    <a href="{{ route('admin.collections.index') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
