@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li><span class="text-primary font-medium">Pengaturan</span></li>
@endsection

@section('content')
    <div class="flex flex-col gap-3 mb-6">
        <h1 class="text-2xl font-bold font-serif text-base-content">Pengaturan Akun</h1>
        <p class="text-xs text-base-content/60 font-sans">Perbarui nama, alamat email, dan kata sandi akun administratif Anda</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-soft mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @include('admin.partials._form-errors')

    <form action="{{ route('admin.settings.update') }}" 
          method="POST" 
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @method('PUT')

        {{-- Left Column — Form Fields --}}
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            {{-- Profil Utama --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Profil Pengguna
                    </h3>
                    
                    <div class="flex flex-col gap-4">
                        {{-- Nama Lengkap --}}
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Nama Lengkap <span class="text-error">*</span></span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   placeholder="Masukkan nama lengkap Anda" 
                                   class="input input-bordered w-full" 
                                   required />
                        </div>

                        {{-- Email --}}
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Alamat Email <span class="text-error">*</span></span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   placeholder="Masukkan alamat email Anda" 
                                   class="input input-bordered w-full" 
                                   required />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ganti Password --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Keamanan & Kata Sandi
                    </h3>
                    <p class="text-xs text-base-content/50 mb-2">Biarkan kolom di bawah ini kosong jika Anda tidak ingin mengubah password.</p>

                    <div class="flex flex-col gap-4">
                        {{-- Current Password --}}
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold text-base-content">Password Saat Ini</span>
                            </label>
                            <input type="password" 
                                   name="current_password" 
                                   placeholder="Masukkan password yang digunakan sekarang" 
                                   class="input input-bordered w-full" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- New Password --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Password Baru</span>
                                </label>
                                <input type="password" 
                                       name="password" 
                                       placeholder="Minimal 8 karakter" 
                                       class="input input-bordered w-full" />
                            </div>

                            {{-- Password Confirmation --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Konfirmasi Password Baru</span>
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       placeholder="Masukkan kembali password baru" 
                                       class="input input-bordered w-full" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column — Save Panel --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h3 class="card-title text-base font-bold font-serif mb-3 text-base-content border-b border-base-200 pb-2">
                        Aksi Penyelamatan
                    </h3>
                    <div class="text-xs text-base-content/60 leading-relaxed mb-4">
                        Pastikan data yang Anda masukkan sudah benar sebelum menekan tombol simpan di bawah ini.
                    </div>
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="btn btn-primary w-full text-white shadow-sm gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost w-full">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
