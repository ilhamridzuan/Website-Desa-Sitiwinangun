@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Dashboard</span></li>
@endsection

@section('content')
    {{-- Welcome banner --}}
    <div class="card bg-gradient-to-r from-primary to-primary/80 text-primary-content shadow-lg mb-6">
        <div class="card-body py-6 px-7">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="card-title font-serif text-2xl font-bold mb-1">
                        Selamat datang, {{ Auth::user()->name }}!
                    </h2>
                    <p class="text-primary-content/80 text-sm leading-relaxed max-w-lg">
                        Panel administrasi Website Desa Sitiwinangun.
                        Kelola koleksi gerabah, profil pengrajin, dan Virtual Tour 360° dari sini.
                    </p>
                </div>
                {{-- Badge role --}}
                <div class="shrink-0">
                    <div class="badge badge-accent badge-lg font-semibold capitalize gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        {{ Auth::user()->role }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Statistics ── --}}
    <div class="stats stats-vertical sm:stats-horizontal shadow-md bg-base-100 border border-base-300 w-full mb-6">

        {{-- Stat 1: Total Koleksi --}}
        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="stat-title text-xs font-semibold uppercase tracking-wider">Total Koleksi</div>
            <div class="stat-value text-primary">{{ $stats['total_collections'] }}</div>
            <div class="stat-desc">Karya gerabah & kriya</div>
        </div>

        {{-- Stat 2: Published --}}
        <div class="stat">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-title text-xs font-semibold uppercase tracking-wider">Published</div>
            <div class="stat-value text-success">{{ $stats['published_collections'] }}</div>
            <div class="stat-desc">Tampil di galeri publik</div>
        </div>

        {{-- Stat 3: Draft --}}
        <div class="stat">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="stat-title text-xs font-semibold uppercase tracking-wider">Draft</div>
            <div class="stat-value text-warning">{{ $stats['draft_collections'] }}</div>
            <div class="stat-desc">Belum dipublikasikan</div>
        </div>

        {{-- Stat 4: Pengrajin --}}
        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="stat-title text-xs font-semibold uppercase tracking-wider">Pengrajin Aktif</div>
            <div class="stat-value text-secondary">{{ $stats['total_artisans'] }}</div>
            <div class="stat-desc">Warga desa terdata</div>
        </div>

    </div>{{-- /stats --}}

    {{-- ── Quick Access Cards ── --}}
    <h3 class="text-xs font-bold uppercase tracking-widest text-base-content/50 mb-3">
        Manajemen Konten
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        {{-- Card: Koleksi Kriya --}}
        <a href="{{ route('admin.collections.index') }}"
           class="card bg-base-100 border border-base-300 hover:border-primary/40 hover:shadow-md
                  transition-all duration-200 cursor-pointer group">
            <div class="card-body py-5 px-5">
                <div class="flex items-start justify-between">
                    <div class="p-2.5 rounded-btn bg-primary/10 text-primary
                                group-hover:bg-primary group-hover:text-primary-content transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="badge badge-ghost text-xs">{{ $stats['total_collections'] }} item</div>
                </div>
                <h4 class="card-title text-sm mt-3 font-semibold text-base-content">Koleksi Kriya</h4>
                <p class="text-xs text-base-content/60">Kelola foto & info gerabah</p>
            </div>
        </a>

        {{-- Card: Arsip Barang / Inventory --}}
        <a href="{{ route('admin.inventory.index') }}"
           class="card bg-base-100 border border-base-300 hover:border-secondary/40 hover:shadow-md
                  transition-all duration-200 cursor-pointer group">
            <div class="card-body py-5 px-5">
                <div class="flex items-start justify-between">
                    <div class="p-2.5 rounded-btn bg-secondary/10 text-secondary
                                group-hover:bg-secondary group-hover:text-secondary-content transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                    </div>
                </div>
                <h4 class="card-title text-sm mt-3 font-semibold text-base-content">Arsip Barang</h4>
                <p class="text-xs text-base-content/60">Kelola inventaris BUMDes</p>
            </div>
        </a>

        {{-- Card: Kisah Pengrajin --}}
        <a href="{{ route('admin.artisans.index') }}"
           class="card bg-base-100 border border-base-300 hover:border-accent/40 hover:shadow-md
                  transition-all duration-200 cursor-pointer group">
            <div class="card-body py-5 px-5">
                <div class="flex items-start justify-between">
                    <div class="p-2.5 rounded-btn bg-accent/10 text-accent
                                group-hover:bg-accent group-hover:text-accent-content transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="badge badge-ghost text-xs">{{ $stats['total_artisans'] }} profil</div>
                </div>
                <h4 class="card-title text-sm mt-3 font-semibold text-base-content">Kisah Pengrajin</h4>
                <p class="text-xs text-base-content/60">Profil & cerita pengrajin</p>
            </div>
        </a>

        {{-- Card: Konten Statis --}}
        <a href="{{ route('admin.village-profile.edit') }}"
           class="card bg-base-100 border border-base-300 hover:border-neutral/40 hover:shadow-md
                  transition-all duration-200 cursor-pointer group">
            <div class="card-body py-5 px-5">
                <div class="flex items-start justify-between">
                    <div class="p-2.5 rounded-btn bg-neutral/10 text-neutral
                                group-hover:bg-neutral group-hover:text-neutral-content transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="badge badge-ghost text-xs">Profil</div>
                </div>
                <h4 class="card-title text-sm mt-3 font-semibold text-base-content">Konten Statis</h4>
                <p class="text-xs text-base-content/60">Tentang, sejarah, kontak</p>
            </div>
        </a>

    </div>{{-- /grid quick access --}}

    {{-- ── Koleksi Terbaru Table ── --}}
    <div class="card bg-base-100 border border-base-300 shadow-sm mb-6">
        <div class="card-body py-5 px-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="card-title text-base font-bold text-base-content font-serif">
                        Koleksi Terbaru
                    </h3>
                    <p class="text-xs text-base-content/60 font-sans">5 karya gerabah yang terakhir ditambahkan</p>
                </div>
                <a href="{{ route('admin.collections.index') }}" class="btn btn-primary btn-sm text-white">
                    Lihat Semua
                </a>
            </div>

            @if($recentCollections->isEmpty())
                <div class="text-center py-8 text-base-content/50 text-sm">
                    Belum ada data koleksi.
                </div>
            @else
                <div class="overflow-x-auto w-full">
                    <table class="table table-zebra w-full text-sm min-w-[800px]">
                        <thead>
                            <tr class="text-base-content/70">
                                <th>Gambar</th>
                                <th>Nama Koleksi</th>
                                <th>Kategori</th>
                                <th>Pengrajin</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentCollections as $collection)
                                <tr class="hover:bg-base-200/50 transition-colors">
                                    <td class="whitespace-nowrap">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-10 h-10 bg-primary/10 flex items-center justify-center">
                                                @if($collection->photo_url)
                                                    <img src="{{ asset('storage/' . $collection->photo_url) }}" alt="{{ $collection->name }}" />
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20h6M9 4h6M10 4v4c-2 1-3.5 3-3.5 5.5S8 19 12 19s5.5-3 5.5-5.5S14 9 12 8V4M16 11c1.5-1 3-1 3-1s-1 2-2.5 3" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="font-semibold text-base-content whitespace-nowrap">
                                        {{ $collection->name }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        <span class="badge badge-outline badge-sm whitespace-nowrap">{{ $collection->category->name ?? '-' }}</span>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ $collection->artisan->name ?? '-' }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if($collection->status === 'published')
                                            <span class="badge badge-success badge-sm text-white whitespace-nowrap">Published</span>
                                        @else
                                            <span class="badge badge-warning badge-sm text-white whitespace-nowrap">Draft</span>
                                        @endif
                                    </td>
                                    <td class="text-center whitespace-nowrap">
                                        <a href="{{ route('admin.collections.edit', $collection->id) }}" class="btn btn-ghost btn-xs text-primary hover:bg-primary/10 whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- ── Activity / Info row ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Last login info --}}
        <div class="card bg-base-100 border border-base-300 lg:col-span-2">
            <div class="card-body py-5 px-6">
                <h3 class="card-title text-sm font-semibold text-base-content/80 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Info Sesi
                </h3>
                <ul class="space-y-2.5 text-sm">
                    <li class="flex items-center justify-between py-1.5 border-b border-base-200">
                        <span class="text-base-content/60">Pengguna</span>
                        <span class="font-semibold text-base-content">{{ Auth::user()->name }}</span>
                    </li>
                    <li class="flex items-center justify-between py-1.5 border-b border-base-200">
                        <span class="text-base-content/60">Role</span>
                        <span class="badge badge-primary badge-sm capitalize text-white">{{ Auth::user()->role }}</span>
                    </li>
                    <li class="flex items-center justify-between py-1.5 border-b border-base-200">
                        <span class="text-base-content/60">Email</span>
                        <span class="font-medium text-xs text-base-content/85">{{ Auth::user()->email }}</span>
                    </li>
                    <li class="flex items-center justify-between py-1.5">
                        <span class="text-base-content/60">Login Terakhir</span>
                        <span class="font-medium text-xs text-base-content/85">
                            {{ Auth::user()->last_login_at
                                ? Auth::user()->last_login_at->format('d M Y, H:i')
                                : 'Pertama kali login' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Quick tips / notes --}}
        <div class="card bg-accent/10 border border-accent/20">
            <div class="card-body py-5 px-6">
                <h3 class="card-title text-sm font-semibold text-accent mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Catatan
                </h3>
                <ul class="space-y-2 text-xs text-base-content/70 leading-relaxed">
                    <li class="flex gap-2">
                        <span class="text-accent mt-0.5">✦</span>
                        Selalu simpan perubahan sebelum berpindah halaman.
                    </li>
                    <li class="flex gap-2">
                        <span class="text-accent mt-0.5">✦</span>
                        Gambar koleksi disarankan rasio 4:3, min. 800px.
                    </li>
                    <li class="flex gap-2">
                        <span class="text-accent mt-0.5">✦</span>
                        Backup data dilakukan otomatis setiap minggu.
                    </li>
                </ul>
            </div>
        </div>

    </div>{{-- /activity row --}}
@endsection
