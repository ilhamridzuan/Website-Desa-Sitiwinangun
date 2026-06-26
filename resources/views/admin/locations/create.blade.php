@extends('layouts.admin')

@section('title', 'Tambah Lokasi Produksi')

@section('breadcrumb')
    <li><a href="{{ route('admin.locations.index') }}">Jelajah Desa</a></li>
    <li><span class="text-primary font-medium">Tambah Lokasi</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Tambah Lokasi Rumah Produksi</h1>
        <p class="text-xs text-base-content/60 font-sans">Tambahkan titik lokasi pengrajin atau kelompok pengrajin gerabah Sitiwinangun</p>
    </div>

    @include('admin.partials._form-errors')

    <form action="{{ route('admin.locations.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf

        {{-- Left Column — Main Fields --}}
        <div class="lg:col-span-8 flex flex-col gap-6">

            {{-- Identitas Lokasi --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Identitas Lokasi
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Nama Rumah Produksi / Kelompok <span class="text-error">*</span></span>
                            </label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Contoh: Rumah Gerabah Pak Budi"
                                   class="input input-bordered w-full"
                                   required />
                        </div>

                        {{-- Pengrajin Terkait --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Pengrajin Terkait <span class="text-base-content/50 font-normal">(Opsional)</span></span>
                            </label>
                            <select name="artisan_id" class="select select-bordered w-full">
                                <option value="">&mdash; Tidak Terkait Profil Pengrajin &mdash;</option>
                                @foreach($artisans as $artisan)
                                    <option value="{{ $artisan->id }}" {{ old('artisan_id') == $artisan->id ? 'selected' : '' }}>
                                        {{ $artisan->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="label-text-alt mt-1.5 text-base-content/45">Pilih jika lokasi ini merupakan milik pengrajin yang ada di profil.</span>
                        </div>

                        {{-- Alamat --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Alamat Lengkap <span class="text-error">*</span></span>
                            </label>
                            <textarea name="address"
                                      placeholder="Nama jalan, RT/RW, gang, atau patokan..."
                                      class="textarea textarea-bordered h-24 w-full"
                                      required>{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Koordinat GPS --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Koordinat GPS
                    </h3>

                    <div x-data="{ showTip: false }" class="mb-4">
                        <button type="button" @click="showTip = !showTip" class="btn btn-sm btn-ghost text-info gap-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Cara mendapatkan koordinat?
                        </button>

                        <div x-show="showTip"
                             x-transition
                             class="alert alert-info alert-soft text-sm p-4 rounded-btn mt-2">
                            <ol class="list-decimal pl-4 space-y-1">
                                <li>Buka Google Maps, cari lokasi atau letakkan pin (klik & tahan).</li>
                                <li>Di bagian bawah atau kiri, akan muncul angka seperti <code>-6.7029, 108.4831</code>.</li>
                                <li>Angka pertama adalah <strong>Latitude</strong>, angka kedua adalah <strong>Longitude</strong>.</li>
                            </ol>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Latitude --}}
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Latitude <span class="text-error">*</span></span>
                            </label>
                            <input type="number"
                                   step="any"
                                   name="latitude"
                                   value="{{ old('latitude', '-6.7029') }}"
                                   placeholder="Contoh: -6.7029"
                                   class="input input-bordered w-full font-mono"
                                   required />
                        </div>

                        {{-- Longitude --}}
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Longitude <span class="text-error">*</span></span>
                            </label>
                            <input type="number"
                                   step="any"
                                   name="longitude"
                                   value="{{ old('longitude', '108.4831') }}"
                                   placeholder="Contoh: 108.4831"
                                   class="input input-bordered w-full font-mono"
                                   required />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kontak & Kapasitas --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                        Kontak & Fasilitas Kunjungan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Phone --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Nomor Telepon/WA <span class="text-base-content/50 font-normal">(Opsional)</span></span>
                            </label>
                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="Contoh: 081234567890"
                                   class="input input-bordered w-full" />
                        </div>

                        {{-- Main Products --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Produk Utama <span class="text-base-content/50 font-normal">(Opsional)</span></span>
                            </label>
                            <textarea name="main_products"
                                      placeholder="Misal: Gentong, celengan, peralatan makan..."
                                      class="textarea textarea-bordered h-20 w-full">{{ old('main_products') }}</textarea>
                        </div>

                        {{-- Visit Capacity --}}
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Kapasitas Kunjungan <span class="text-base-content/50 font-normal">(Opsional)</span></span>
                            </label>
                            <input type="text"
                                   name="visit_capacity"
                                   value="{{ old('visit_capacity') }}"
                                   placeholder="Contoh: 10 - 20 orang"
                                   class="input input-bordered w-full" />
                        </div>

                        {{-- Edu Activities --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Aktivitas Edukasi <span class="text-base-content/50 font-normal">(Opsional)</span></span>
                            </label>
                            <textarea name="edu_activities"
                                      placeholder="Misal: Praktik membuat celengan, mewarnai gerabah..."
                                      class="textarea textarea-bordered h-20 w-full">{{ old('edu_activities') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right Column — Sidebar --}}
        <div class="lg:col-span-4 flex flex-col gap-6">

            {{-- Status Kunjungan --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Status Kunjungan
                    </h3>

                    <div class="form-control">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox"
                                   name="is_open_visit"
                                   value="1"
                                   class="toggle toggle-success"
                                   {{ old('is_open_visit', true) ? 'checked' : '' }} />
                            <span class="label-text font-medium text-base-content">Menerima Kunjungan Edukasi</span>
                        </label>
                        <div class="text-xs text-base-content/50 mt-2 pl-14">
                            Aktifkan jika lokasi ini terbuka untuk kunjungan wisatawan atau edukasi.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Foto Lokasi --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm"
                 x-data="{ imagePreview: null }">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Foto Lokasi
                    </h3>

                    <div class="form-control w-full">
                        {{-- Image Preview Area --}}
                        <div class="mb-4 aspect-video rounded-btn bg-base-200 border border-base-300 overflow-hidden relative group flex items-center justify-center">
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="w-full h-full object-cover" />
                            </template>
                            <template x-if="!imagePreview">
                                <div class="text-center text-base-content/30 p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-medium">Belum ada foto</span>
                                </div>
                            </template>
                        </div>

                        {{-- File Input --}}
                        <input type="file"
                               name="photo"
                               accept="image/jpeg,image/png,image/webp"
                               class="file-input file-input-bordered file-input-primary w-full text-sm"
                               @change="
                                   const file = $event.target.files[0];
                                   if (file) {
                                       imagePreview = URL.createObjectURL(file);
                                   } else {
                                       imagePreview = null;
                                   }
                               " />
                        <label class="label">
                            <span class="label-text-alt text-base-content/50">Format: JPG, PNG, WEBP. Maks: 5MB.<br>Rasio disarankan: 16:9</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Submit Actions --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-4 flex flex-col gap-2">
                    <button type="submit" class="btn btn-primary text-white w-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Simpan Lokasi
                    </button>
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
