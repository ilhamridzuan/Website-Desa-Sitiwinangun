@extends('layouts.admin')

@section('title', 'Tambah Akun Admin')

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li><a href="{{ route('admin.users.index') }}">Kelola Akun</a></li>
    <li><span class="text-primary font-medium">Tambah Akun</span></li>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Tambah Akun Admin</h1>
            <p class="text-xs text-base-content/65 font-sans mt-1">
                Buat akun baru untuk pengelola konten atau superadmin Desa Sitiwinangun.
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost min-h-[44px] self-start">
            Kembali ke Daftar Akun
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf

        <div class="lg:col-span-8 flex flex-col gap-6">
            {{-- Account Identity --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h2 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Informasi Akun
                    </h2>

                    <div class="flex flex-col gap-4">
                        <div class="form-control w-full">
                            <label for="user-name" class="label">
                                <span class="label-text font-semibold text-base-content">Nama Lengkap <span class="text-error">*</span></span>
                            </label>
                            <input type="text"
                                   id="user-name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   maxlength="100"
                                   placeholder="Masukkan nama pengelola"
                                   class="input input-bordered w-full min-h-[44px]"
                                   required />
                        </div>

                        <div class="form-control w-full">
                            <label for="user-email" class="label">
                                <span class="label-text font-semibold text-base-content">Alamat Email <span class="text-error">*</span></span>
                            </label>
                            <input type="email"
                                   id="user-email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="email@sitiwinangun.id"
                                   class="input input-bordered w-full min-h-[44px]"
                                   required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label for="user-role" class="label">
                                    <span class="label-text font-semibold text-base-content">Peran Akun <span class="text-error">*</span></span>
                                </label>
                                <select id="user-role" name="role" class="select select-bordered w-full min-h-[44px]" required>
                                    <option value="admin" {{ old('role', 'admin') === 'admin' ? 'selected' : '' }}>
                                        Admin (Kelola konten saja)
                                    </option>
                                    <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>
                                        Superadmin (Konten dan kelola akun)
                                    </option>
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <span class="label">
                                    <span class="label-text font-semibold text-base-content">Status Akun</span>
                                </span>
                                <label for="user-active" class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-base-300 min-h-[44px] cursor-pointer">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox"
                                           id="user-active"
                                           name="is_active"
                                           value="1"
                                           class="checkbox checkbox-primary checkbox-sm"
                                           {{ old('is_active', '1') == '1' ? 'checked' : '' }} />
                                    <span class="text-sm text-base-content">Akun langsung aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Password Section --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm" x-data="{ showPass: false, showConfirm: false }">
                <div class="card-body p-6">
                    <h2 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Kata Sandi Awal
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label for="user-password" class="label">
                                <span class="label-text font-semibold text-base-content">Password <span class="text-error">*</span></span>
                            </label>
                            <div class="join w-full">
                                <input x-bind:type="showPass ? 'text' : 'password'"
                                       id="user-password"
                                       name="password"
                                       placeholder="Minimal 8 karakter"
                                       autocomplete="new-password"
                                       class="input input-bordered join-item w-full min-h-[44px]"
                                       required />
                                <button type="button"
                                        x-on:click="showPass = !showPass"
                                        x-bind:aria-pressed="showPass ? 'true' : 'false'"
                                        aria-label="Tampilkan atau sembunyikan password"
                                        class="btn btn-outline border-base-300 join-item min-h-[44px] cursor-pointer">
                                    <span class="text-xs" x-text="showPass ? 'Sembunyi' : 'Lihat'">Lihat</span>
                                </button>
                            </div>
                        </div>

                        <div class="form-control w-full">
                            <label for="user-password-confirmation" class="label">
                                <span class="label-text font-semibold text-base-content">Konfirmasi Password <span class="text-error">*</span></span>
                            </label>
                            <div class="join w-full">
                                <input x-bind:type="showConfirm ? 'text' : 'password'"
                                       id="user-password-confirmation"
                                       name="password_confirmation"
                                       placeholder="Ulangi password"
                                       autocomplete="new-password"
                                       class="input input-bordered join-item w-full min-h-[44px]"
                                       required />
                                <button type="button"
                                        x-on:click="showConfirm = !showConfirm"
                                        x-bind:aria-pressed="showConfirm ? 'true' : 'false'"
                                        aria-label="Tampilkan atau sembunyikan konfirmasi password"
                                        class="btn btn-outline border-base-300 join-item min-h-[44px] cursor-pointer">
                                    <span class="text-xs" x-text="showConfirm ? 'Sembunyi' : 'Lihat'">Lihat</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Save Panel --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h2 class="card-title text-base font-bold font-serif mb-3 text-base-content border-b border-base-200 pb-2">
                        Simpan Akun Baru
                    </h2>
                    <p class="text-xs text-base-content/70 leading-relaxed mb-4">
                        Periksa kembali alamat email dan peran yang dipilih. Pemilik akun dapat mengganti password sendiri di menu Pengaturan setelah login.
                    </p>
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="btn btn-primary w-full text-white min-h-[44px] cursor-pointer">
                            Buat Akun Admin
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost w-full min-h-[44px]">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
