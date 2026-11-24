@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li><span class="text-primary font-medium">Pengaturan</span></li>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Pengaturan Akun</h1>
            <p class="text-xs text-base-content/65 font-sans mt-1">
                Perbarui nama, alamat email, dan password untuk akun Anda sendiri.
            </p>
        </div>
        @if(Auth::user()->role === 'superadmin')
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-primary min-h-[44px] self-start">
                Kelola Akun Admin Lain
            </a>
        @endif
    </div>

    <form action="{{ route('admin.settings.update') }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @method('PUT')

        {{-- Left Column: Form Fields --}}
        <div class="lg:col-span-8 flex flex-col gap-6">

            {{-- Profil Utama --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h2 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Profil Pengguna
                    </h2>

                    <div class="flex flex-col gap-4">
                        <div class="form-control w-full">
                            <label for="settings-name" class="label">
                                <span class="label-text font-semibold text-base-content">Nama Lengkap <span class="text-error">*</span></span>
                            </label>
                            <input type="text"
                                   id="settings-name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   maxlength="100"
                                   placeholder="Masukkan nama lengkap Anda"
                                   class="input input-bordered w-full min-h-[44px]"
                                   required />
                        </div>

                        <div class="form-control w-full">
                            <label for="settings-email" class="label">
                                <span class="label-text font-semibold text-base-content">Alamat Email <span class="text-error">*</span></span>
                            </label>
                            <input type="email"
                                   id="settings-email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="email@sitiwinangun.id"
                                   class="input input-bordered w-full min-h-[44px]"
                                   required />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ganti Password --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                <div class="card-body p-6">
                    <h2 class="card-title text-base font-bold font-serif mb-2 text-base-content border-b border-base-200 pb-2">
                        Keamanan dan Password
                    </h2>
                    <p class="text-xs text-base-content/65 mb-4">
                        Biarkan kolom di bawah ini kosong jika Anda tidak ingin mengubah password.
                    </p>

                    <div class="flex flex-col gap-4">
                        <div class="form-control w-full">
                            <label for="settings-current-password" class="label">
                                <span class="label-text font-semibold text-base-content">Password Saat Ini</span>
                            </label>
                            <div class="join w-full">
                                <input x-bind:type="showCurrent ? 'text' : 'password'"
                                       id="settings-current-password"
                                       name="current_password"
                                       placeholder="Masukkan password yang digunakan sekarang"
                                       autocomplete="current-password"
                                       class="input input-bordered join-item w-full min-h-[44px]" />
                                <button type="button"
                                        x-on:click="showCurrent = !showCurrent"
                                        x-bind:aria-pressed="showCurrent ? 'true' : 'false'"
                                        aria-label="Tampilkan atau sembunyikan password saat ini"
                                        class="btn btn-outline border-base-300 join-item min-h-[44px] cursor-pointer">
                                    <span class="text-xs" x-text="showCurrent ? 'Sembunyi' : 'Lihat'">Lihat</span>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label for="settings-password" class="label">
                                    <span class="label-text font-semibold text-base-content">Password Baru</span>
                                </label>
                                <div class="join w-full">
                                    <input x-bind:type="showNew ? 'text' : 'password'"
                                           id="settings-password"
                                           name="password"
                                           placeholder="Minimal 8 karakter"
                                           autocomplete="new-password"
                                           class="input input-bordered join-item w-full min-h-[44px]" />
                                    <button type="button"
                                            x-on:click="showNew = !showNew"
                                            x-bind:aria-pressed="showNew ? 'true' : 'false'"
                                            aria-label="Tampilkan atau sembunyikan password baru"
                                            class="btn btn-outline border-base-300 join-item min-h-[44px] cursor-pointer">
                                        <span class="text-xs" x-text="showNew ? 'Sembunyi' : 'Lihat'">Lihat</span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-control w-full">
                                <label for="settings-password-confirmation" class="label">
                                    <span class="label-text font-semibold text-base-content">Konfirmasi Password Baru</span>
                                </label>
                                <div class="join w-full">
                                    <input x-bind:type="showConfirm ? 'text' : 'password'"
                                           id="settings-password-confirmation"
                                           name="password_confirmation"
                                           placeholder="Masukkan kembali password baru"
                                           autocomplete="new-password"
                                           class="input input-bordered join-item w-full min-h-[44px]" />
                                    <button type="button"
                                            x-on:click="showConfirm = !showConfirm"
                                            x-bind:aria-pressed="showConfirm ? 'true' : 'false'"
                                            aria-label="Tampilkan atau sembunyikan konfirmasi password baru"
                                            class="btn btn-outline border-base-300 join-item min-h-[44px] cursor-pointer">
                                        <span class="text-xs" x-text="showConfirm ? 'Sembunyi' : 'Lihat'">Lihat</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Save Panel --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h2 class="card-title text-base font-bold font-serif mb-3 text-base-content border-b border-base-200 pb-2">
                        Simpan Pengaturan
                    </h2>
                    <div class="text-xs text-base-content/70 leading-relaxed mb-4">
                        Periksa kembali nama, email, dan password sebelum menyimpan perubahan.
                    </div>
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="btn btn-primary w-full text-white shadow-sm min-h-[44px] gap-2 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost w-full min-h-[44px]">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
