@extends('layouts.admin')

@section('title', 'Tambah Pengurus')

@section('breadcrumb')
    <li><a href="{{ route('admin.board-members.index') }}">Info Pengurus</a></li>
    <li><span class="text-primary font-medium">Tambah Pengurus</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Tambah Pengurus</h1>
        <p class="text-xs text-base-content/60 font-sans">Tambahkan anggota baru ke struktur organisasi pengurus BUMDes, KIM, atau aparatur desa</p>
    </div>

    @include('admin.partials._form-errors')

    <form action="{{ route('admin.board-members.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          x-data="{ photoPreview: null }"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf

        {{-- Form Main Area (Left Column) --}}
        <div class="lg:col-span-8 flex flex-col gap-6">
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Informasi Pengurus
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama Lengkap --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Nama Lengkap <span class="text-error">*</span></span></label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Contoh: Sutiwan, S.Sn." 
                                   class="input input-bordered w-full" 
                                   required />
                        </div>

                        {{-- Jabatan --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Jabatan / Posisi <span class="text-error">*</span></span></label>
                            <input type="text" 
                                   name="position" 
                                   value="{{ old('position') }}" 
                                   placeholder="Contoh: Ketua BUMDes, Anggota KIM" 
                                   class="input input-bordered w-full" 
                                   required />
                        </div>

                        {{-- Nomor Telepon --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Nomor Telepon (Opsional)</span></label>
                            <input type="text" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="Contoh: 081234567890" 
                                   class="input input-bordered w-full" />
                        </div>

                        {{-- Email --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-semibold">Alamat Email (Opsional)</span></label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Contoh: pengurus@sitiwinangun.desa.id" 
                                   class="input input-bordered w-full" />
                        </div>
                    </div>

                    {{-- Urutan Tampil --}}
                    <div class="form-control w-full md:w-1/2 mt-4">
                        <label class="label"><span class="label-text font-semibold">Urutan Tampil (Urutan Tampil Di Publik)</span></label>
                        <input type="number" 
                               name="sort_order" 
                               value="{{ old('sort_order', 0) }}" 
                               min="0"
                               class="input input-bordered w-full" 
                               required />
                        <span class="label-text-alt mt-1 text-base-content/40">Angka lebih kecil tampil paling atas di halaman utama.</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Sidebar Area (Right Column) --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            {{-- Section: Foto --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Foto Profil
                    </h3>

                    <div class="form-control w-full">
                        <label class="label"><span class="label-text font-semibold">Pilih Foto</span></label>
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

                    {{-- Foto Preview --}}
                    <div class="mt-4 border-2 border-dashed border-base-300 rounded-btn p-2 flex flex-col items-center justify-center min-h-48 bg-base-200/40">
                        <template x-if="photoPreview">
                            <div class="text-center w-full">
                                <span class="text-xs text-success font-semibold block mb-2">Pratinjau Foto:</span>
                                <img :src="photoPreview" class="max-w-full max-h-56 rounded-btn object-cover shadow-sm mx-auto" />
                            </div>
                        </template>
                        <template x-if="!photoPreview">
                            <div class="text-center text-base-content/40 text-xs py-10 flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Belum ada foto yang dipilih.</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Submit / Action Card --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-4 flex flex-col gap-2">
                    <button type="submit" class="btn btn-primary text-white w-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Simpan Pengurus
                    </button>
                    <a href="{{ route('admin.board-members.index') }}" class="btn btn-ghost w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
@endsection
