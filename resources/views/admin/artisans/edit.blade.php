@extends('layouts.admin')

@section('title', 'Edit Pengrajin')

@section('breadcrumb')
    <li><a href="{{ route('admin.artisans.index') }}">Kisah Pengrajin</a></li>
    <li><span class="text-primary font-medium">Edit Pengrajin</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Edit Pengrajin</h1>
        <p class="text-xs text-base-content/60 font-sans">Perbarui data profil pengrajin: <strong class="text-base-content font-serif">{{ $artisan->name }}</strong></p>
    </div>

    <form action="{{ route('admin.artisans.update', $artisan) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          x-data="{ 
              photoPreview: null
          }"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @method('PUT')

        {{-- Form Main Area (Left Column) --}}
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            {{-- Section 1: Identitas & Profil --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Profil Pengrajin
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama Pengrajin --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Nama Lengkap <span class="text-error">*</span></span></label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $artisan->name) }}"
                                   placeholder="Contoh: Bpk. Sutiwan" 
                                   class="input input-bordered w-full" 
                                   required />
                        </div>

                        {{-- Durasi Berkarya --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Durasi Berkarya</span></label>
                            <input type="text" 
                                   name="years_active" 
                                   value="{{ old('years_active', $artisan->years_active) }}"
                                   placeholder="Contoh: 20 tahun / Sejak 1998" 
                                   class="input input-bordered w-full" />
                        </div>

                        {{-- Produk Khas --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label"><span class="label-text font-semibold">Keahlian Khas / Produk Khas</span></label>
                            <input type="text" 
                                   name="specialty" 
                                   value="{{ old('specialty', $artisan->specialty) }}"
                                   placeholder="Contoh: Pembuatan kendi wadasan / gerabah bakar tungku" 
                                   class="input input-bordered w-full" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Kisah & Kutipan --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Kisah & Filosofi Hidup
                    </h3>
                    
                    {{-- Kisah / Narasi --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-semibold">Kisah / Narasi Profil</span></label>
                        <textarea name="story" 
                                  placeholder="Ceritakan latar belakang kehidupan, perjuangan, serta dedikasi pengrajin dalam melestarikan kriya gerabah..." 
                                  class="textarea textarea-bordered w-full h-48">{{ old('story', $artisan->story) }}</textarea>
                    </div>

                    {{-- Kutipan --}}
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Kutipan Pribadi (Quote)</span></label>
                        <input type="text" 
                               name="quote" 
                               value="{{ old('quote', $artisan->quote) }}"
                               placeholder="Contoh: 'Gerabah adalah nafas hidup saya.'" 
                               class="input input-bordered w-full" />
                    </div>
                </div>
            </div>

        </div>

        {{-- Form Sidebar Area (Right Column) --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            {{-- Section 3: Foto Profil --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Foto Profil
                    </h3>
                    
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Ganti Foto (Opsional)</span></label>
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
                                @if($artisan->photo_url)
                                    <img src="{{ asset('storage/' . $artisan->photo_url) }}" 
                                         alt="{{ $artisan->name }}" 
                                         class="max-w-full max-h-48 rounded-btn object-cover shadow-sm mx-auto bg-base-300" />
                                @else
                                    <div class="w-20 h-20 rounded-full bg-primary/10 text-primary font-bold font-serif text-2xl flex items-center justify-center shadow-inner">
                                        <span>{{ collect(explode(' ', $artisan->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}</span>
                                    </div>
                                    <span class="text-xs text-base-content/40 mt-2 block">Belum ada foto profil (menggunakan inisial)</span>
                                @endif
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Section 4: Alamat & Kontak --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Kontak & Alamat
                    </h3>
                    
                    {{-- Alamat --}}
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Alamat Rumah Produksi <span class="text-error">*</span></span></label>
                        <input type="text" 
                               name="address" 
                               value="{{ old('address', $artisan->address) }}" 
                               placeholder="Blok Pejaten RT 01 RW 02" 
                               class="input input-bordered w-full" 
                               required />
                    </div>

                    {{-- Telepon --}}
                    <div class="form-control w-full mt-3">
                        <label class="label"><span class="label-text font-semibold">Nomor Telepon / WhatsApp</span></label>
                        <input type="text" 
                               name="phone" 
                               value="{{ old('phone', $artisan->phone) }}" 
                               placeholder="Contoh: 081234567890" 
                               class="input input-bordered w-full" />
                    </div>
                </div>
            </div>

            {{-- Section 5: Pengaturan Tampilan --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Sistem & Urutan
                    </h3>
                    
                    {{-- Featured --}}
                    <div class="form-control mb-3">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" name="is_featured" value="1" class="checkbox checkbox-primary" {{ old('is_featured', $artisan->is_featured) ? 'checked' : '' }} />
                            <span class="label-text font-semibold">Unggulan (Featured)</span>
                        </label>
                        <span class="text-xs text-base-content/50 pl-8">Tampilkan di halaman utama profil pengrajin unggulan desa</span>
                    </div>

                    {{-- Urutan --}}
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Urutan Tampil</span></label>
                        <input type="number" 
                               name="sort_order" 
                               value="{{ old('sort_order', $artisan->sort_order) }}" 
                               min="0"
                               class="input input-bordered w-full" />
                    </div>
                </div>
            </div>

            {{-- Section 6: Metadata --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm text-xs">
                <div class="card-body p-4 text-base-content/70 space-y-2">
                    <div class="flex justify-between py-1 border-b border-base-200">
                        <span>Dibuat Pada:</span>
                        <span class="font-semibold text-base-content">{{ $artisan->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Pembaruan Terakhir:</span>
                        <span class="font-semibold text-base-content">{{ $artisan->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Submit / Action Card --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-4 flex flex-col gap-2">
                    <button type="submit" class="btn btn-primary text-white w-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.2" />
                        </svg>
                        Perbarui Pengrajin
                    </button>
                    <a href="{{ route('admin.artisans.index') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
