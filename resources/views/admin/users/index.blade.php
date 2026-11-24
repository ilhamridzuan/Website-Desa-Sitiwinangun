@extends('layouts.admin')

@section('title', 'Kelola Akun Admin')

@section('breadcrumb')
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li><span class="text-primary font-medium">Kelola Akun</span></li>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold font-serif text-base-content">Kelola Akun Admin</h1>
            <p class="text-xs text-base-content/65 font-sans mt-1">
                Tambah akun pengelola baru, ganti password akun, atau atur status aktif pengelola website.
            </p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary text-white min-h-[44px] gap-2 shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Akun
        </a>
    </div>

    {{-- Search Filter --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm mb-6">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-end">
                <div class="form-control flex-1">
                    <label for="search-users" class="label py-1">
                        <span class="label-text text-xs font-semibold text-base-content/80">Cari nama atau email</span>
                    </label>
                    <input type="search"
                           id="search-users"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Ketik nama atau alamat email admin"
                           class="input input-bordered w-full min-h-[44px]" />
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary text-white min-h-[44px] cursor-pointer">
                        Cari
                    </button>
                    @if($search !== '')
                        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost min-h-[44px]">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Accounts Table --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm">
        <div class="card-body p-0">
            @if($users->count())
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="bg-base-200/70 text-base-content/75 text-xs">
                                <th>Akun</th>
                                <th>Peran</th>
                                <th>Status</th>
                                <th>Login Terakhir</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $account)
                                @php
                                    $isSelf = $account->id === Auth::id();
                                    $isProtectedSuperAdmin = $account->role === 'superadmin' && $account->is_active && $activeSuperAdminCount <= 1;
                                    $isLocked = $account->isLocked();
                                @endphp
                                <tr class="hover:bg-base-200/40">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-primary/15 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ collect(explode(' ', $account->name))->filter()->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-semibold text-sm text-base-content flex items-center gap-2">
                                                    <span class="truncate">{{ $account->name }}</span>
                                                    @if($isSelf)
                                                        <span class="badge badge-xs badge-outline badge-primary">Anda</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-base-content/65 truncate">{{ $account->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($account->role === 'superadmin')
                                            <span class="badge badge-sm badge-primary text-primary-content font-medium">Superadmin</span>
                                        @else
                                            <span class="badge badge-sm badge-ghost border border-base-300 font-medium">Admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex flex-wrap gap-1.5">
                                            @if($account->is_active)
                                                <span class="badge badge-sm badge-success badge-soft font-medium">Aktif</span>
                                            @else
                                                <span class="badge badge-sm badge-error badge-soft font-medium">Nonaktif</span>
                                            @endif
                                            @if($isLocked)
                                                <span class="badge badge-sm badge-warning badge-soft font-medium">Terkunci</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-xs text-base-content/70 whitespace-nowrap">
                                        {{ $account->last_login_at ? $account->last_login_at->format('d M Y, H:i') : 'Belum pernah login' }}
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                            <a href="{{ route('admin.users.edit', $account) }}"
                                               class="btn btn-sm btn-outline btn-primary min-h-[38px]">
                                                Edit / Ganti Password
                                            </a>

                                            @if(!$isSelf && !$isProtectedSuperAdmin)
                                                <form action="{{ route('admin.users.toggle-active', $account) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-ghost border border-base-300 min-h-[38px] cursor-pointer">
                                                        {{ $account->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </button>
                                                </form>

                                                <button type="button"
                                                        x-data
                                                        x-on:click="$dispatch('open-delete-modal', { url: @js(route('admin.users.destroy', $account)), name: @js('akun ' . $account->name . ' (' . $account->email . ')') })"
                                                        class="btn btn-sm btn-ghost text-error hover:bg-error/10 min-h-[38px] cursor-pointer">
                                                    Hapus
                                                </button>
                                            @else
                                                <button type="button"
                                                        disabled
                                                        title="{{ $isSelf ? 'Akun sendiri tidak dapat dinonaktifkan atau dihapus' : 'Superadmin aktif terakhir tidak dapat dinonaktifkan atau dihapus' }}"
                                                        class="btn btn-sm btn-ghost btn-disabled min-h-[38px] cursor-not-allowed">
                                                    Dilindungi
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-14 px-6" id="empty-users">
                    <h2 class="font-serif font-bold text-lg text-base-content">
                        Tidak ada akun yang cocok dengan pencarian "{{ $search }}"
                    </h2>
                    <p class="text-sm text-base-content/65 mt-2">
                        Periksa kembali kata kunci atau tampilkan semua akun admin yang terdaftar.
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-primary min-h-[44px]">
                            Tampilkan Semua Akun
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
