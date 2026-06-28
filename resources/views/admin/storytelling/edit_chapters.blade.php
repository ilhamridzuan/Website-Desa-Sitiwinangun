@extends('layouts.admin')

@section('title', 'Kelola Konten Kisah Kriya')

@section('breadcrumb')
    <li><span class="text-primary font-medium">Kisah Kriya</span></li>
@endsection

@section('content')
    <div x-data="{ tab: 'bab2' }">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl font-bold font-serif text-base-content">Kelola Narasi Kisah Kriya</h1>
                <p class="text-xs text-base-content/60 font-sans">Ubah teks deskripsi dan narasi Bab 2 sampai Bab 5 yang tampil di halaman publik</p>
            </div>
            <div>
                <button type="submit" form="story-form" class="btn btn-primary text-white gap-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2v-3M9 11V9a2 2 0 012-2h6m-1-4l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>

        {{-- Session Success Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-soft mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Form Errors Banner --}}
        @if($errors->any())
            <div class="alert alert-error alert-soft mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm">Terdapat kesalahan input form. Silakan periksa kembali tab formulir di bawah.</span>
            </div>
        @endif

        {{-- Chapter Tab Selectors --}}
        <div class="tabs tabs-boxed mb-6 p-1.5 bg-base-200 gap-1">
            <button type="button" @click="tab = 'bab2'" :class="tab === 'bab2' ? 'tab-active bg-primary text-primary-content font-bold shadow-sm' : 'text-base-content/70 hover:bg-base-300/40'" class="tab rounded-lg py-2 transition-all flex-1 md:flex-none">
                Bab II: Fungsi & Teknik
            </button>
            <button type="button" @click="tab = 'bab3'" :class="tab === 'bab3' ? 'tab-active bg-primary text-primary-content font-bold shadow-sm' : 'text-base-content/70 hover:bg-base-300/40'" class="tab rounded-lg py-2 transition-all flex-1 md:flex-none">
                Bab III: Ragam Motif
            </button>
            <button type="button" @click="tab = 'bab4'" :class="tab === 'bab4' ? 'tab-active bg-primary text-primary-content font-bold shadow-sm' : 'text-base-content/70 hover:bg-base-300/40'" class="tab rounded-lg py-2 transition-all flex-1 md:flex-none">
                Bab IV: Makhluk Mitologi
            </button>
            <button type="button" @click="tab = 'bab5'" :class="tab === 'bab5' ? 'tab-active bg-primary text-primary-content font-bold shadow-sm' : 'text-base-content/70 hover:bg-base-300/40'" class="tab rounded-lg py-2 transition-all flex-1 md:flex-none">
                Bab V: Kearifan Lokal
            </button>
        </div>

        {{-- Main Form --}}
        <form id="story-form" action="{{ route('admin.storytelling.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- ──────────────────────────────────────────────────────────
                 TAB: BAB II (FUNGSI & TEKNIK)
                 ────────────────────────────────────────────────────────── --}}
            <div x-show="tab === 'bab2'" class="space-y-6 animate-fade-in">
                <div class="card bg-base-100 border border-base-300 shadow-sm">
                    <div class="card-body p-6">
                        <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2 flex justify-between items-center">
                            <span>Bab II: Deskripsi Utama & Klasifikasi Fungsi</span>
                            <span class="text-xs font-normal text-base-content/50">Lengkapi narasi jenis-jenis gerabah</span>
                        </h3>

                        <div class="flex flex-col gap-5">
                            {{-- Deskripsi Utama Bab II --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Deskripsi Utama Bab II <span class="text-error">*</span></span>
                                </label>
                                <textarea name="bab2_main_desc" class="textarea textarea-bordered h-24 w-full" required>{{ old('bab2_main_desc', $bab2->content['main_desc'] ?? '') }}</textarea>
                                @error('bab2_main_desc')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            {{-- Gerabah Fungsional --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Gerabah Fungsional (Benda Pakai Harian) <span class="text-error">*</span></span>
                                </label>
                                <textarea name="bab2_fungsional_text" class="textarea textarea-bordered h-24 w-full" required>{{ old('bab2_fungsional_text', $bab2->content['fungsional_text'] ?? '') }}</textarea>
                                @error('bab2_fungsional_text')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            {{-- Gerabah Religi --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Gerabah Religi (Spiritual & Keagamaan) <span class="text-error">*</span></span>
                                </label>
                                <textarea name="bab2_religi_text" class="textarea textarea-bordered h-24 w-full" required>{{ old('bab2_religi_text', $bab2->content['religi_text'] ?? '') }}</textarea>
                                @error('bab2_religi_text')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            {{-- Gerabah Simbolik --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Gerabah Simbolik (Mitologis & Kosmologis) <span class="text-error">*</span></span>
                                </label>
                                <textarea name="bab2_simbolik_text" class="textarea textarea-bordered h-24 w-full" required>{{ old('bab2_simbolik_text', $bab2->content['simbolik_text'] ?? '') }}</textarea>
                                @error('bab2_simbolik_text')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            {{-- Gerabah Estetis --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Gerabah Estetis (Hias & Inovasi Kreatif) <span class="text-error">*</span></span>
                                </label>
                                <textarea name="bab2_estetis_text" class="textarea textarea-bordered h-24 w-full" required>{{ old('bab2_estetis_text', $bab2->content['estetis_text'] ?? '') }}</textarea>
                                @error('bab2_estetis_text')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ──────────────────────────────────────────────────────────
                 TAB: BAB III (RAGAM MOTIF)
                 ────────────────────────────────────────────────────────── --}}
            <div x-show="tab === 'bab3'" class="space-y-6 animate-fade-in">
                <div class="card bg-base-100 border border-base-300 shadow-sm">
                    <div class="card-body p-6">
                        <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                            Bab III: Deskripsi Utama & Filosofi Ragam Motif
                        </h3>

                        <div class="flex flex-col gap-5">
                            {{-- Deskripsi Utama Bab III --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Deskripsi Utama Bab III <span class="text-error">*</span></span>
                                </label>
                                <textarea name="bab3_main_desc" class="textarea textarea-bordered h-20 w-full" required>{{ old('bab3_main_desc', $bab3->content['main_desc'] ?? '') }}</textarea>
                                @error('bab3_main_desc')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <div class="divider text-xs text-base-content/40 my-2">Daftar Ornamen & Motif</div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Motif 1 --}}
                                <div class="bg-base-200/40 p-4 rounded-xl border border-base-300/40 flex flex-col gap-3">
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Nama Motif 1 <span class="text-error">*</span></span></label>
                                        <input type="text" name="bab3_motif_1_title" value="{{ old('bab3_motif_1_title', $bab3->content['motif_1_title'] ?? '') }}" class="input input-bordered input-sm" required />
                                    </div>
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Filosofi/Deskripsi 1 <span class="text-error">*</span></span></label>
                                        <textarea name="bab3_motif_1_desc" class="textarea textarea-bordered h-20 text-xs" required>{{ old('bab3_motif_1_desc', $bab3->content['motif_1_desc'] ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- Motif 2 --}}
                                <div class="bg-base-200/40 p-4 rounded-xl border border-base-300/40 flex flex-col gap-3">
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Nama Motif 2 <span class="text-error">*</span></span></label>
                                        <input type="text" name="bab3_motif_2_title" value="{{ old('bab3_motif_2_title', $bab3->content['motif_2_title'] ?? '') }}" class="input input-bordered input-sm" required />
                                    </div>
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Filosofi/Deskripsi 2 <span class="text-error">*</span></span></label>
                                        <textarea name="bab3_motif_2_desc" class="textarea textarea-bordered h-20 text-xs" required>{{ old('bab3_motif_2_desc', $bab3->content['motif_2_desc'] ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- Motif 3 --}}
                                <div class="bg-base-200/40 p-4 rounded-xl border border-base-300/40 flex flex-col gap-3">
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Nama Motif 3 <span class="text-error">*</span></span></label>
                                        <input type="text" name="bab3_motif_3_title" value="{{ old('bab3_motif_3_title', $bab3->content['motif_3_title'] ?? '') }}" class="input input-bordered input-sm" required />
                                    </div>
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Filosofi/Deskripsi 3 <span class="text-error">*</span></span></label>
                                        <textarea name="bab3_motif_3_desc" class="textarea textarea-bordered h-20 text-xs" required>{{ old('bab3_motif_3_desc', $bab3->content['motif_3_desc'] ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- Motif 4 --}}
                                <div class="bg-base-200/40 p-4 rounded-xl border border-base-300/40 flex flex-col gap-3">
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Nama Motif 4 <span class="text-error">*</span></span></label>
                                        <input type="text" name="bab3_motif_4_title" value="{{ old('bab3_motif_4_title', $bab3->content['motif_4_title'] ?? '') }}" class="input input-bordered input-sm" required />
                                    </div>
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Filosofi/Deskripsi 4 <span class="text-error">*</span></span></label>
                                        <textarea name="bab3_motif_4_desc" class="textarea textarea-bordered h-20 text-xs" required>{{ old('bab3_motif_4_desc', $bab3->content['motif_4_desc'] ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- Motif 5 --}}
                                <div class="bg-base-200/40 p-4 rounded-xl border border-base-300/40 flex flex-col gap-3">
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Nama Motif 5 <span class="text-error">*</span></span></label>
                                        <input type="text" name="bab3_motif_5_title" value="{{ old('bab3_motif_5_title', $bab3->content['motif_5_title'] ?? '') }}" class="input input-bordered input-sm" required />
                                    </div>
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Filosofi/Deskripsi 5 <span class="text-error">*</span></span></label>
                                        <textarea name="bab3_motif_5_desc" class="textarea textarea-bordered h-20 text-xs" required>{{ old('bab3_motif_5_desc', $bab3->content['motif_5_desc'] ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- Motif 6 --}}
                                <div class="bg-base-200/40 p-4 rounded-xl border border-base-300/40 flex flex-col gap-3">
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Nama Motif 6 <span class="text-error">*</span></span></label>
                                        <input type="text" name="bab3_motif_6_title" value="{{ old('bab3_motif_6_title', $bab3->content['motif_6_title'] ?? '') }}" class="input input-bordered input-sm" required />
                                    </div>
                                    <div class="form-control">
                                        <label class="label"><span class="label-text font-semibold">Filosofi/Deskripsi 6 <span class="text-error">*</span></span></label>
                                        <textarea name="bab3_motif_6_desc" class="textarea textarea-bordered h-20 text-xs" required>{{ old('bab3_motif_6_desc', $bab3->content['motif_6_desc'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ──────────────────────────────────────────────────────────
                 TAB: BAB IV (MAKHLUK MITOLOGI)
                 ────────────────────────────────────────────────────────── --}}
            <div x-show="tab === 'bab4'" class="space-y-6 animate-fade-in">
                <div class="card bg-base-100 border border-base-300 shadow-sm">
                    <div class="card-body p-6">
                        <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                            Bab IV: Makhluk Mitologis Cirebonan
                        </h3>

                        <div class="flex flex-col gap-5">
                            {{-- Deskripsi Utama Bab IV --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Deskripsi Utama Bab IV <span class="text-error">*</span></span>
                                </label>
                                <textarea name="bab4_main_desc" class="textarea textarea-bordered h-20 w-full" required>{{ old('bab4_main_desc', $bab4->content['main_desc'] ?? '') }}</textarea>
                                @error('bab4_main_desc')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <div class="divider text-xs text-base-content/40 my-2">Data Deskripsi Makhluk Mitologi</div>

                            {{-- Paksi Naga Liman --}}
                            <div class="bg-base-200/30 p-5 rounded-xl border border-base-300/40 space-y-4">
                                <h4 class="font-serif font-bold text-primary border-b border-base-300 pb-1.5 text-sm">1. Paksi Naga Liman</h4>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Teks Penjelasan Lengkap (Kiri) <span class="text-error">*</span></span></label>
                                    <textarea name="bab4_paksi_text" class="textarea textarea-bordered h-24 w-full" required>{{ old('bab4_paksi_text', $bab4->content['paksi_text'] ?? '') }}</textarea>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Teks Ringkasan Kartu Kanan <span class="text-error">*</span></span></label>
                                    <textarea name="bab4_paksi_card_desc" class="textarea textarea-bordered h-16 w-full text-xs" required>{{ old('bab4_paksi_card_desc', $bab4->content['paksi_card_desc'] ?? '') }}</textarea>
                                </div>
                            </div>

                            {{-- Macan Ali --}}
                            <div class="bg-base-200/30 p-5 rounded-xl border border-base-300/40 space-y-4">
                                <h4 class="font-serif font-bold text-accent border-b border-base-300 pb-1.5 text-sm">2. Macan Ali</h4>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Teks Penjelasan Lengkap (Kiri) <span class="text-error">*</span></span></label>
                                    <textarea name="bab4_macan_text" class="textarea textarea-bordered h-24 w-full" required>{{ old('bab4_macan_text', $bab4->content['macan_text'] ?? '') }}</textarea>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Teks Ringkasan Kartu Kanan <span class="text-error">*</span></span></label>
                                    <textarea name="bab4_macan_card_desc" class="textarea textarea-bordered h-16 w-full text-xs" required>{{ old('bab4_macan_card_desc', $bab4->content['macan_card_desc'] ?? '') }}</textarea>
                                </div>
                            </div>

                            {{-- Singabarong & Burok --}}
                            <div class="bg-base-200/30 p-5 rounded-xl border border-base-300/40 space-y-4">
                                <h4 class="font-serif font-bold text-primary border-b border-base-300 pb-1.5 text-sm">3. Singabarong &amp; Burok</h4>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Teks Penjelasan Lengkap (Kiri) <span class="text-error">*</span></span></label>
                                    <textarea name="bab4_singabarong_text" class="textarea textarea-bordered h-24 w-full" required>{{ old('bab4_singabarong_text', $bab4->content['singabarong_text'] ?? '') }}</textarea>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Teks Ringkasan Kartu Kanan <span class="text-error">*</span></span></label>
                                    <textarea name="bab4_singabarong_card_desc" class="textarea textarea-bordered h-16 w-full text-xs" required>{{ old('bab4_singabarong_card_desc', $bab4->content['singabarong_card_desc'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ──────────────────────────────────────────────────────────
                 TAB: BAB V (KEARIFAN LOKAL)
                 ────────────────────────────────────────────────────────── --}}
            <div x-show="tab === 'bab5'" class="space-y-6 animate-fade-in">
                <div class="card bg-base-100 border border-base-300 shadow-sm">
                    <div class="card-body p-6">
                        <h3 class="card-title text-base font-bold font-serif mb-4 text-base-content border-b border-base-200 pb-2">
                            Bab V: Kearifan Lokal &amp; Etika Komunal
                        </h3>

                        <div class="flex flex-col gap-5">
                            {{-- Deskripsi Utama Bab V --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold text-base-content">Deskripsi Utama Bab V <span class="text-error">*</span></span>
                                </label>
                                <textarea name="bab5_main_desc" class="textarea textarea-bordered h-20 w-full" required>{{ old('bab5_main_desc', $bab5->content['main_desc'] ?? '') }}</textarea>
                                @error('bab5_main_desc')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </div>

                            <div class="divider text-xs text-base-content/40 my-2">Dua Tutur Kearifan Lokal</div>

                            {{-- Tutur 1 --}}
                            <div class="bg-base-200/30 p-5 rounded-xl border border-base-300/40 space-y-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text font-semibold">Judul Tutur 1 <span class="text-error">*</span></span></label>
                                    <input type="text" name="bab5_tutur_1_title" value="{{ old('bab5_tutur_1_title', $bab5->content['tutur_1_title'] ?? '') }}" class="input input-bordered input-sm font-serif font-bold text-primary" required />
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Arti & Penjelasan Harfiah <span class="text-error">*</span></span></label>
                                    <textarea name="bab5_tutur_1_desc" class="textarea textarea-bordered h-20 w-full" required>{{ old('bab5_tutur_1_desc', $bab5->content['tutur_1_desc'] ?? '') }}</textarea>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Pesan Moral (Teks Cetak Miring) <span class="text-error">*</span></span></label>
                                    <textarea name="bab5_tutur_1_subtext" class="textarea textarea-bordered h-20 w-full text-xs" required>{{ old('bab5_tutur_1_subtext', $bab5->content['tutur_1_subtext'] ?? '') }}</textarea>
                                </div>
                            </div>

                            {{-- Tutur 2 --}}
                            <div class="bg-base-200/30 p-5 rounded-xl border border-base-300/40 space-y-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text font-semibold">Judul Tutur 2 <span class="text-error">*</span></span></label>
                                    <input type="text" name="bab5_tutur_2_title" value="{{ old('bab5_tutur_2_title', $bab5->content['tutur_2_title'] ?? '') }}" class="input input-bordered input-sm font-serif font-bold text-primary" required />
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Arti & Penjelasan Harfiah <span class="text-error">*</span></span></label>
                                    <textarea name="bab5_tutur_2_desc" class="textarea textarea-bordered h-20 w-full" required>{{ old('bab5_tutur_2_desc', $bab5->content['tutur_2_desc'] ?? '') }}</textarea>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text font-semibold">Pesan Moral (Teks Cetak Miring) <span class="text-error">*</span></span></label>
                                    <textarea name="bab5_tutur_2_subtext" class="textarea textarea-bordered h-20 w-full text-xs" required>{{ old('bab5_tutur_2_subtext', $bab5->content['tutur_2_subtext'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
