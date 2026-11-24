@extends('layouts.admin')

@section('title', 'Edit Akun Admin')

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li><a href="{{ route('admin.users.index') }}">Kelola Akun</a></li>
    <li><span class="text-primary font-medium">Edit Akun</span></li>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Edit Akun: {{ $user->name }}</h1>
            <p class="text-xs text-base-content/65 font-sans mt-1">
                Perbarui informasi akun atau atur ulang password untuk pengelola ini.
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost min-h-[44px] self-start">
            Kembali ke Daftar Akun
        </a>
    </div>

    @if($user->isLocked())
        <div class="alert alert-warning alert-soft mb-6">
            <span class="text-sm font-medium">
                Akun ini sedang terkunci sementara akibat gagal login berulang. Mengisi password baru di bawah akan langsung membuka kunci akun.
            </span>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @method('PUT')

        <div class="lg:col-span-8 flex flex-col gap-6">
            {{-- Account Identity --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h2 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                        Informasi Akun
                    </h2>

                    <div class="flex flex-col gap-4">
                        <div class="form-control w-full">
                            <label for="edit-user-name" class="label">
                                <span class="label-text font-semibold text-base-content">Nama Lengkap <span class="text-error">*</span></span>
                            </label>
                            <input type="text"
                                   id="edit-user-name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   maxlength="100"
                                   placeholder="Masukkan nama pengelola"
                                   class="input input-bordered w-full min-h-[44px]"
                                   required />
                        </div>

                        <div class="form-control w-full">
                            <label for="edit-user-email" class="label">
                                <span class="label-text font-semibold text-base-content">Alamat Email <span class="text-error">*</span></span>
                            </label>
                            <input type="email"
                                   id="edit-user-email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="email@sitiwinangun.id"
                                   class="input input-bordered w-full min-h-[44px]"
                                   required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label for="edit-user-role" class="label">
                                    <span class="label-text font-semibold text-base-content">Peran Akun <span class="text-error">*</span></span>
                                </label>
                                @if($isSelf || $isLastActiveSuperAdmin)
                                    <input type="hidden" name="role" value="superadmin">
                                    <select id="edit-user-role" class="select select-bordered w-full min-h-[44px]" disabled>
                                        <option value="superadmin" selected>Superadmin (Dilindungi)</option>
                                    </select>
                                    <p class="text-xs text-base-content/60 mt-1">
                                        {{ $isSelf ? 'Peran akun yang sedang dipakai tidak dapat diturunkan.' : 'Superadmin aktif terakhir tidak dapat diturunkan perannya.' }}
                                    </p>
                                @else
                                    <select id="edit-user-role" name="role" class="select select-bordered w-full min-h-[44px]" required>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                            Admin (Kelola konten saja)
                                        </option>
                                        <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>
                                            Superadmin (Konten dan kelola akun)
                                        </option>
                                    </select>
                                @endif
                            </div>

                            <div class="form-control w-full">
                                <span class="label">
                                    <span class="label-text font-semibold text-base-content">Status Akun</span>
                                </span>
                                @if($isSelf || $isLastActiveSuperAdmin)
                                    <input type="hidden" name="is_active" value="1">
                                    <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-base-300 bg-base-200/50 min-h-[44px]">
                                        <span class="text-sm text-base-content/75">Aktif (tidak dapat dinonaktifkan)</span>
                                    </div>
                                @else
                                    <label for="edit-user-active" class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-base-300 min-h-[44px] cursor-pointer">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox"
                                               id="edit-user-active"
                                               name="is_active"
                                               value="1"
                                               class="checkbox checkbox-primary checkbox-sm"
                                               {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'checked' : '' }} />
                                        <span class="text-sm text-base-content">Akun aktif</span>
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reset / Change Password --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm" x-data="{ showPass: false, showConfirm: false }">
                <div class="card-body p-6">
                    <h2 class="card-title text-base font-bold font-serif mb-2 text-base-content border-b border-base-200 pb-2">
                        Ganti atau Reset Password
                    </h2>
                    <p class="text-xs text-base-content/65 mb-4">
                        Kosongkan kedua kolom di bawah bila tidak ingin mengganti password akun ini.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control w-full">
                            <label for="edit-user-password" class="label">
                                <span class="label-text font-semibold text-base-content">Password Baru</span>
                            </label>
                            <div class="join w-full">
                                <input x-bind:type="showPass ? 'text' : 'password'"
                                       id="edit-user-password"
                                       name="password"
                                       placeholder="Minimal 8 karakter"
                                       autocomplete="new-password"
                                       class="input input-bordered join-item w-full min-h-[44px]" />
                                <button type="button"
                                        x-on:click="showPass = !showPass"
                                        x-bind:aria-pressed="showPass ? 'true' : 'false'"
                                        aria-label="Tampilkan atau sembunyikan password baru"
                                        class="btn btn-outline border-base-300 join-item min-h-[44px] cursor-pointer">
                                    <span class="text-xs" x-text="showPass ? 'Sembunyi' : 'Lihat'">Lihat</span>
                                </button>
                            </div>
                        </div>

                        <div class="form-control w-full">
                            <label for="edit-user-password-confirmation" class="label">
                                <span class="label-text font-semibold text-base-content">Konfirmasi Password Baru</span>
                            </label>
                            <div class="join w-full">
                                <input x-bind:type="showConfirm ? 'text' : 'password'"
                                       id="edit-user-password-confirmation"
                                       name="password_confirmation"
                                       placeholder="Ulangi password baru"
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

        {{-- Save Panel --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body p-6">
                    <h2 class="card-title text-base font-bold font-serif mb-3 text-base-content border-b border-base-200 pb-2">
                        Simpan Perubahan
                    </h2>
                    <p class="text-xs text-base-content/70 leading-relaxed mb-4">
                        Perubahan pada email, peran, atau password langsung berlaku setelah disimpan.
                    </p>
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="btn btn-primary w-full text-white min-h-[44px] cursor-pointer">
                            Simpan Perubahan
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
