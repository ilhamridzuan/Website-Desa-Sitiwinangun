@extends('layouts.admin')

@section('title', 'Profil Desa')

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li><span class="text-primary font-medium">Profil Desa</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Profil Desa</h1>
        <p class="text-xs text-base-content/60 font-sans">Kelola data profil umum, lokasi koordinat, dan galeri foto Desa Wisata Sitiwinangun</p>
    </div>

    @include('admin.partials._form-errors')

    <form action="{{ route('admin.village-profile.update') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @method('PUT')

        {{-- Form Main Area (Left Column) --}}
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            {{-- Section 1: Informasi Desa --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Informasi Umum Desa
                    </h3>
                    
                    {{-- Nama Desa --}}
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text font-semibold">Nama Desa / Objek Wisata <span class="text-error">*</span></span>
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $profile->name ?? 'Desa Sitiwinangun') }}" 
                               placeholder="Contoh: Desa Wisata Sitiwinangun" 
                               class="input input-bordered w-full" 
                               required />
                    </div>

                    {{-- Deskripsi Desa --}}
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text font-semibold">Deskripsi Desa <span class="text-error">*</span></span>
                        </label>
                        <textarea name="description" 
                                  placeholder="Ceritakan profil singkat desa, potensi pariwisata gerabah, sejarah singkat, dan keunggulan desa..." 
                                  class="textarea textarea-bordered w-full h-40" 
                                  required>{{ old('description', $profile->description ?? '') }}</textarea>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold">Alamat Lengkap <span class="text-error">*</span></span>
                        </label>
                        <textarea name="address" 
                                  placeholder="Jl. Sunan Gunung Jati, Kec. Jamblang, Kabupaten Cirebon, Jawa Barat..." 
                                  class="textarea textarea-bordered w-full h-20" 
                                  required>{{ old('address', $profile->address ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Section 2: Koordinat Peta --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm" x-data="{ showTutorial: false }">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between border-b border-base-200 pb-2 mb-4">
                        <h3 class="card-title text-base font-bold font-serif text-base-content">
                            Koordinat Peta (GPS)
                        </h3>
                        <button type="button" 
                                @click="showTutorial = !showTutorial" 
                                class="btn btn-ghost btn-xs text-primary font-semibold flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Cara mendapatkan koordinat dari Google Maps &rarr;
                        </button>
                    </div>

                    {{-- Tutorial Panel --}}
                    <div x-show="showTutorial" 
                         x-collapse 
                         x-transition
                         class="alert alert-info bg-info/10 border-info/20 text-info text-xs p-4 mb-4 rounded-btn">
                        <div class="flex flex-col gap-2">
                            <div class="font-bold text-sm">Langkah-langkah menyalin koordinat dari Google Maps:</div>
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Buka <a href="https://maps.google.com" target="_blank" class="link link-primary font-bold">Google Maps</a> di browser Anda.</li>
                                <li>Cari lokasi pusat desa atau Kantor Desa Sitiwinangun.</li>
                                <li>Klik kanan pada titik lokasi tersebut di peta.</li>
                                <li>Klik angka koordinat (misalnya <code class="bg-base-200 px-1 py-0.5 rounded font-mono">-6.7198302, 108.4658392</code>) di bagian atas menu klik kanan. Koordinat akan otomatis tersalin ke clipboard.</li>
                                <li>Tempelkan (Paste) nilai pertama sebagai <strong>Latitude</strong> dan nilai kedua sebagai <strong>Longitude</strong> di kolom bawah ini.</li>
                            </ol>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Latitude --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Latitude</span></label>
                            <input type="number" 
                                   name="latitude" 
                                   step="any"
                                   min="-90"
                                   max="90"
                                   value="{{ old('latitude', $profile->latitude ?? '') }}" 
                                   placeholder="Contoh: -6.7198302" 
                                   class="input input-bordered w-full" />
                        </div>

                        {{-- Longitude --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Longitude</span></label>
                            <input type="number" 
                                   name="longitude" 
                                   step="any"
                                   min="-180"
                                   max="180"
                                   value="{{ old('longitude', $profile->longitude ?? '') }}" 
                                   placeholder="Contoh: 108.4658392" 
                                   class="input input-bordered w-full" />
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Form Sidebar Area (Right Column) --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            {{-- Section 3: Galeri Foto --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm"
                 x-data="{ 
                     newPhotos: [],
                     handleFileSelect(event) {
                         const files = Array.from(event.target.files);
                         this.newPhotos = [];
                         files.forEach(file => {
                             const reader = new FileReader();
                             reader.onload = (e) => {
                                 this.newPhotos.push({
                                     name: file.name,
                                     size: (file.size / (1024 * 1024)).toFixed(2) + ' MB',
                                     preview: e.target.result
                                 });
                             };
                             reader.readAsDataURL(file);
                         });
                     }
                 }">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-2 text-base-content border-b border-base-200 pb-2">
                        Galeri Foto Desa
                    </h3>

                    {{-- Foto Saat Ini --}}
                    <div class="mb-4">
                        <label class="label pt-0"><span class="label-text font-semibold">Foto Saat Ini</span></label>
                        @if($profile && $profile->gallery_photos && count($profile->gallery_photos) > 0)
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($profile->gallery_photos as $photo)
                                    <div class="relative group aspect-video rounded-btn overflow-hidden border border-base-300 bg-base-200" 
                                         x-data="{ markedForDelete: false }">
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-full h-full object-cover transition-opacity duration-200" :class="markedForDelete ? 'opacity-20' : ''" />
                                        
                                        {{-- Overlay Status --}}
                                        <template x-if="markedForDelete">
                                            <div class="absolute inset-0 bg-error/10 flex items-center justify-center pointer-events-none">
                                                <span class="badge badge-error text-white font-semibold text-[10px] py-1 shadow-sm">Dihapus</span>
                                            </div>
                                        </template>

                                        {{-- Delete Checkbox Overlay --}}
                                        <label class="absolute top-1 right-1 cursor-pointer z-10">
                                            <input type="checkbox" 
                                                   name="delete_photos[]" 
                                                   value="{{ $photo }}" 
                                                   x-model="markedForDelete" 
                                                   class="checkbox checkbox-error checkbox-xs bg-base-100/90 shadow-md border-base-300" />
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border border-dashed border-base-300 rounded-btn p-4 text-center text-xs text-base-content/50 bg-base-200/20">
                                Belum ada foto desa di galeri.
                            </div>
                        @endif
                    </div>

                    {{-- Upload Foto Baru --}}
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Tambah Foto Baru (Multiple)</span></label>
                        <input type="file" 
                               name="photos[]" 
                               multiple 
                               accept="image/*"
                               @change="handleFileSelect"
                               class="file-input file-input-bordered file-input-sm w-full file-input-primary" />
                        <span class="label-text-alt mt-1.5 text-base-content/50">Maks. 6 foto total di galeri. Format JPG/PNG/WebP, maks 5MB per file.</span>
                    </div>

                    {{-- Preview New Photos --}}
                    <template x-if="newPhotos.length > 0">
                        <div class="mt-4 border-t border-base-200 pt-3">
                            <span class="text-xs font-semibold text-success block mb-2">Pratinjau Foto Baru:</span>
                            <div class="grid grid-cols-2 gap-3">
                                <template x-for="(photo, index) in newPhotos" :key="index">
                                    <div class="relative aspect-video rounded-btn overflow-hidden border border-success/30 bg-base-200">
                                        <img :src="photo.preview" class="w-full h-full object-cover" />
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Section 4: Metadata & Action --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm text-xs">
                <div class="card-body p-4 text-base-content/70 space-y-2">
                    <div class="flex justify-between py-1">
                        <span>Pembaruan Terakhir:</span>
                        <span class="font-semibold text-base-content">
                            {{ $profile && $profile->updated_at ? $profile->updated_at->format('d M Y, H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Submit Action Card --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-4 flex flex-col gap-2">
                    <button type="submit" class="btn btn-primary text-white w-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
