# Design Spec: Pembaruan Proses Produksi, Hero Beranda, dan Manajemen Akun Admin

**Tanggal:** 2026-11-24
**Project:** Website Desa Sitiwinangun (Museum Digital Gerabah)
**Design Read (antislop):** Reading this as an editorial cultural museum website and internal admin CMS for Desa Sitiwinangun visitors and village managers, in the existing warm earthy batik-terracotta editorial style (`batik-light` / `batik-dark`, Playfair Display + Inter), dial **ENERGY 2 / RHYTHM 2 / MOTION 1**.

---

## 1. Tujuan & Batasan Utama

### Tujuan
1. Memperbarui halaman **Proses Produksi** (`/proses-produksi`) dari 5 tahap lama menjadi **7 tahapan nyata** yang sesuai dengan 17 foto dokumenter di `c:\Users\Ridzuan\Pictures\Foto EDIT\Proses`, dilengkapi galeri interaktif multi-foto + lightbox per tahap serta pembersihan UI & copywriting dari pola AI slop.
2. Mengganti foto background slideshow di halaman **Beranda** (`/`) menggunakan **6 foto landscape** dari `c:\Users\Ridzuan\Pictures\Foto EDIT\BG`, menggantikan 8 file PNG lama (~23 MB) sekaligus merapikan kontras, kontrol aksesibilitas slideshow, dan copywriting AI slop di Beranda.
3. Menambahkan fitur **Manajemen Akun Admin** (`/admin/users`, khusus `superadmin`) untuk membuat akun baru, mengubah/mereset password akun lain, mengaktifkan/menonaktifkan, dan menghapus akun, sambil mempertahankan dan merapikan halaman **Pengaturan Akun Pribadi** (`/admin/settings`) untuk semua admin.

### Batasan Deploy Aman ke Hostinger (Non-Negotiable)
- **Tanpa migrasi database baru**: tabel `users` di Hostinger sudah memiliki seluruh kolom yang dibutuhkan (`name`, `email`, `password`, `role`, `is_active`, `last_login_at`, `failed_attempts`, `locked_until`), dan konten Proses Produksi dipindahkan ke config Laravel agar tidak menyentuh tabel `production_stages` maupun `migrations` di Hostinger.
- **Tanpa menyentuh `storage/app/public/` atau `.env`**: seluruh foto baru disimpan di `public/images/production/` dan `public/heroimg/`, yang keduanya di-track Git dan sudah di-rewrite oleh root `.htaccess` Hostinger.
- **Build aset frontend**: jalankan `npm run build` setelah edit CSS/Blade agar `public/build/` siap untuk deployment Git Hostinger.

### Non-Goals
- Tidak mengubah halaman publik lain di luar Proses Produksi, Beranda, dan shared layout/footer yang ikut tampil di kedua halaman tersebut.
- Tidak mengembalikan menu admin CRUD Proses Produksi (data proses produksi bersifat kuratorial statis di config).
- Tidak mengubah data koleksi, pengrajin, profil desa, atau `storage/app/public/` milik Hostinger.

---

## 2. Desain Modul 1: Halaman Proses Produksi (`/proses-produksi`)

### 2.1 Penyimpanan Data & Aset Foto
- **Config file**: `config/production_stages.php` berisi array terurut 7 tahapan. Setiap tahap memiliki:
  - `number` (1..7)
  - `slug` (`tahap-1`..`tahap-7`)
  - `title` (judul tahap)
  - `summary` (ringkasan singkat 1 kalimat untuk navigasi/konteks)
  - `description` (penjelasan faktual proses kerja pengrajin Sitiwinangun)
  - `photos`: array item `['src' => 'images/production/...', 'alt' => '...', 'caption' => '...', 'orientation' => 'landscape'|'portrait']`
- **Lokasi gambar**: `public/images/production/` dengan nama file ASCII yang bersih (tanpa spasi):
  1. **Tahap 1: Pengolahan Tanah Liat** (5 foto)
     - `tahap-1-menguleni-2.jpg` (`1_1.jpg`, landscape, foto utama tahap 1 agar rasio frame konsisten)
     - `tahap-1-menguleni-3.jpg` (`1_2.jpg`, landscape)
     - `tahap-1-menguleni-1.jpg` (`1.jpg`, portrait)
     - `tahap-1-menginjak-1.jpg` (`1_3.jpg`, landscape)
     - `tahap-1-menginjak-2.jpg` (`1_4.jpg`, landscape)
  2. **Tahap 2: Pembentukan di Meja Putar** (5 foto)
     - `tahap-2-putar-1.jpg` (`2.jpg`, landscape)
     - `tahap-2-putar-2.jpg` (`2_1.jpg`, landscape)
     - `tahap-2-putar-3.jpg` (`2_2.jpg`, landscape)
     - `tahap-2-putar-4.jpg` (`2_3.jpg`, landscape)
     - `tahap-2-putar-5.jpg` (`2_4.jpg`, landscape)
  3. **Tahap 3: Pengeringan Awal** (2 foto)
     - `tahap-3-kering-awal-1.jpg` (`3.jpg`, landscape)
     - `tahap-3-kering-awal-2.jpg` (`3_1.jpg`, landscape)
  4. **Tahap 4: Penghalusan Permukaan** (2 foto)
     - `tahap-4-halus-1.jpg` (`4.jpg`, landscape)
     - `tahap-4-halus-2.jpg` (`4_1.jpg`, landscape)
  5. **Tahap 5: Pengeringan Lanjutan** (1 foto)
     - `tahap-5-kering-lanjut-1.jpg` (`5.jpg`, landscape)
  6. **Tahap 6: Penyusunan di Ladang Bakar** (1 foto)
     - `tahap-6-susun-bakar-1.jpg` (`proses penyusunan sebelum pembakaran.jpeg`, portrait)
  7. **Tahap 7: Pembakaran Terbuka** (1 foto)
     - `tahap-7-pembakaran-1.jpg` (`proses pembakaran.jpeg`, portrait)
- **Controller**: `App\Http\Controllers\Public\ProductionController@index` membaca `config('production_stages', [])` dan mengirimkannya ke view `public.production`.

### 2.2 Tata Letak, Interaksi & Anti-Slop UI
- **Header editorial**: hapus label eyebrow uppercase wide-tracked (`PROSES TRADISIONAL`) dan frasa klise (`5 tahapan sakral`, `para maestro`). Gunakan `<h1>` tegas ("Proses Pembuatan Gerabah Sitiwinangun"), paragraf pengantar singkat dan faktual tentang 7 tahap dari pengolahan tanah hingga pembakaran terbuka.
- **Navigasi lompat tahap (Stage Jump Bar)**: daftar tautan `<a href="#tahap-1">` sampai `#tahap-7` yang rapi (scrollable secara terkendali di mobile tanpa overflow halaman, grid/bar horizontal di desktop) dengan nomor `01`–`07` + judul ringkas. Setiap tautan memiliki target nyata (`id="tahap-X"`, `scroll-mt-24`).
- **Blok editorial per tahap (7 blok)**:
  - Mengganti pola timeline lama yang menyisakan 45% ruang kosong di sebelah kartu.
  - Setiap tahap memakai layout 2 kolom asimetris di desktop (7 kolom galeri foto + 5 kolom narasi, bergantian kiri-kanan secara halus untuk ritme `RHYTHM 2`), dan bertumpuk rapi di mobile.
  - **Komponen Galeri Interaktif (Alpine.js)**:
    - Foto utama di dalam container berasio tetap (`aspect-[16/10]` untuk tahap dominan landscape, `aspect-[4/3]` dengan `object-cover` yang tepat untuk foto portrait agar subjek tetap fokus), dibungkus `<button type="button">` untuk membuka lightbox resolusi penuh.
    - Di bawah foto utama: keterangan foto (*caption*) + indikator indeks (`1 / 5`) + deretan tombol thumbnail untuk tahap yang memiliki >1 foto. Mengklik thumbnail mengganti foto utama tanpa layout shift.
    - **Lightbox Modal**: menampilkan foto secara penuh tanpa terpotong (`object-contain max-h-[80vh]`), judul tahap, caption, tombol Sebelumnya/Berikutnya (untuk tahap multi-foto), dan tombol Tutup (`aria-label`). Mendukung keyboard `Escape` untuk tutup, `ArrowLeft` / `ArrowRight` untuk geser foto, serta klik backdrop untuk tutup.
- **Empty State**: tetap menyediakan empty state yang jujur dan jelas jika array konfigurasi kosong (R-27).
- **Copywriting**: tanpa em dash (`—`), tanpa buzzword AI, kalimat aktif yang menyebut pelaku ("pengrajin"), faktual sesuai visual foto.

---

## 3. Desain Modul 2: Halaman Beranda (`/`)

### 3.1 Penggantian Foto Hero
- Hapus 8 file PNG lama di `public/heroimg/1.png`–`8.png`.
- Salin 6 foto landscape dari `c:\Users\Ridzuan\Pictures\Foto EDIT\BG` ke `public/heroimg/` (mengabaikan `BG_Jaji.jpg` yang portrait dan objeknya sama dengan `BG 2_Jaji.jpg`):
  1. `bg-1-marini-getak.jpg` (`BG-Marini.jpg`) — *slide pertama, `fetchpriority="high"`, tanpa `loading="lazy"`*
  2. `bg-2-kadmiya-ikan.jpg` (`BG 2_Kadmiya.jpg`)
  3. `bg-3-jaji-penari.jpg` (`BG 2_Jaji.jpg`)
  4. `bg-4-marini-guci.jpg` (`BG2-Marini.jpg`)
  5. `bg-5-kadmiya-rak.jpg` (`BG_Kadmiya.jpg`)
  6. `bg-6-rumsani-mangkuk.jpg` (`BG_Rumsani.jpg`)
- Kirim daftar array `$heroSlides` (masing-masing `src` + `alt` deskriptif) dari `HomeController@index` ke `resources/views/public/home.blade.php`.

### 3.2 Pembersihan Anti-Slop & Aksesibilitas di Beranda & Public Layout
- **Kontras teks hero (R-25)**: perkuat gradient overlay gelap di atas foto slideshow (`from-black/70 via-black/40 to-black/30`) agar judul putih dan subjudul selalu memenuhi WCAG AA meski di atas foto terang seperti `BG_Rumsani.jpg` dan `BG2-Marini.jpg`.
- **Kontrol Pause/Play Slideshow (R-39)**: tambahkan tombol kontrol pause/play berlabel aksesibel dan indikator slide (`1 / 6`) di sudut kanan bawah hero. Hormati `prefers-reduced-motion: reduce` dengan tidak menjalankan auto-advance bila pengguna mengaktifkan reduced motion.
- **Hapus pola AI slop**:
  - Hapus pill eyebrow kaca `"Museum Digital Gerabah"` di atas `<h1>` (R-09); sampaikan konteks langsung di subjudul yang lugas.
  - Hapus panah scroll yang memantul terus-menerus (`animate-bounce-down`, melanggar R-19 / `MOTION 1`).
  - Ganti ikon sparkle pada kartu `"Dibuat dengan Tangan"` di `home.blade.php` dan menu mobile `public.blade.php` dengan ikon tembikar/tangan yang relevan (R-04).
  - Update teks `"5 tahap produksi..."` menjadi `"7 tahap produksi dari pengolahan tanah liat hingga pembakaran terbuka."`
  - Hapus seluruh em dash (`—`) di `home.blade.php` dan `layouts/public.blade.php` (ganti koma, titik, atau tanda `|` di `<title>`).

---

## 4. Desain Modul 3: Manajemen Akun Admin & Pengaturan

### 4.1 Middleware & Otorisasi
- Middleware baru: `App\Http\Middleware\SuperAdminAuth`
  - Mengecek `Auth::check() && Auth::user()->is_active && Auth::user()->role === 'superadmin'`.
  - Jika bukan `superadmin`, kembalikan respons `403 Forbidden` (abort 403 dengan pesan jelas Bahasa Indonesia) agar admin biasa tidak bisa mengakses URL `/admin/users*` secara langsung maupun lewat form.
- Diterapkan di `routes/web.php` di dalam grup `admin` + `AdminAuth::class`:
  ```php
  Route::middleware(SuperAdminAuth::class)->prefix('users')->name('admin.users.')->group(function () {
      Route::get('/', [UserController::class, 'index'])->name('index');
      Route::get('/create', [UserController::class, 'create'])->name('create');
      Route::post('/', [UserController::class, 'store'])->name('store');
      Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
      Route::put('/{user}', [UserController::class, 'update'])->name('update');
      Route::patch('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggle-active');
      Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
  });
  ```

### 4.2 Logika Bisnis & Guardrails (`App\Http\Controllers\Admin\UserController`)
- **Daftar Akun (`index`)**:
  - Menampilkan semua user diurutkan (`role` superadmin di atas, lalu `name` ascending), dilengkapi filter pencarian nama/email sederhana.
  - Kolom tabel sesuai keputusan admin: Nama & Email, Peran (`Superadmin` / `Admin`), Status (`Aktif`, `Nonaktif`, atau `Terkunci` jika `isLocked()`), Login Terakhir, dan Aksi (Edit / Ganti Password, Aktifkan/Nonaktifkan, Hapus).
- **Tambah Akun (`create` / `store`)**:
  - Field: `name` (required, string, max 100), `email` (required, email, max 255, unique:users,email), `role` (required, in:admin,superadmin), `password` (required, confirmed, min 8), `is_active` (boolean, default true).
  - Password di-hash via cast/Hash, `failed_attempts = 0`.
  - Mencatat `ActivityLogService::log('create_user', 'user', $user->id, null, [...tanpa password...])`.
- **Edit Akun & Ganti/Reset Password (`edit` / `update`)**:
  - Field: `name`, `email` (unique ignore `$user->id`), `role`, `is_active`, serta bagian opsional **Ganti Password** (`password` nullable, confirmed, min 8).
  - **Guardrail**:
    - Tidak boleh menurunkan role atau menonaktifkan diri sendiri (`$user->id === Auth::id()`).
    - Tidak boleh menurunkan role atau menonaktifkan jika `$user` adalah satu-satunya `superadmin` aktif yang tersisa.
  - Jika `password` diisi: update password baru dan sekalian reset `failed_attempts = 0` & `locked_until = null` agar akun yang terkunci langsung bisa dipakai login kembali.
  - Mencatat `ActivityLogService::log('update_user', ...)` tanpa pernah memasukkan field `password` atau hash ke dalam log!
- **Toggle Aktif/Nonaktif (`toggleActive`)**:
  - Ditolak dengan pesan error jelas jika target adalah akun sendiri atau superadmin aktif terakhir.
  - Jika diaktifkan kembali, sekalian buka kunci (`failed_attempts = 0`, `locked_until = null`).
- **Hapus Akun (`destroy`)**:
  - Ditolak jika target adalah akun sendiri atau superadmin terakhir.
  - Menggunakan modal konfirmasi hapus (`_delete-modal.blade.php`) yang sudah ada di layout admin.

### 4.3 Perbaikan Pengaturan Pribadi & Layout Admin
- `resources/views/layouts/admin.blade.php`:
  - Hapus em dash di `<title>` (`|` sebagai pemisah).
  - Tambahkan item menu **"Kelola Akun"** di grup `Sistem` dengan guard `@if(Auth::user()->role === 'superadmin')`.
  - Perbaiki 2 link mati di dropdown user kanan atas: gabungkan menjadi link nyata ke `route('admin.settings.index')` ("Pengaturan Akun") dan, khusus `superadmin`, link ke `route('admin.users.index')` ("Kelola Akun").
- `resources/views/admin/settings/index.blade.php`:
  - Hapus duplikasi `@include('admin.partials._form-errors')` (sudah di-render di `layouts/admin.blade.php`).
  - Ganti heading `"Aksi Penyelamatan"` menjadi `"Simpan Pengaturan"`.
  - Pasangkan `for`/`id` pada seluruh `<label>` dan `<input>` serta tambahkan tombol tampilkan/sembunyikan password yang aksesibel (`type="button"`, `aria-label`, `aria-pressed`).
  - Pastikan semua admin (`admin` & `superadmin`) tetap dapat mengganti profil dan password pribadinya dengan verifikasi `current_password`.

---

## 5. Keputusan yang Diambil Builder (Untuk Dicek User)
1. **Nama file foto**: seluruh file foto dari `Proses` dan `BG` disalin dengan nama file ASCII tanpa spasi (`tahap-1-menguleni-2.jpg`, `bg-1-marini-getak.jpg`, dst.) agar aman di URL Linux Hostinger dan bebas masalah encoding.
2. **Foto utama Tahap 1**: memakai `1_1.jpg` (landscape, tangan menguleni tanah) sebagai gambar pembuka di frame 16:10, sedangkan `1.jpg` (portrait) tetap masuk urutan galeri Tahap 1 sehingga frame halaman terlihat seragam tanpa memotong kepala pengrajin.
3. **Audit keamanan log**: aktivitas create/update/reset password user dicatat di `activity_logs`, tetapi nilai password/hash tidak pernah ditulis ke log.
4. **Hapus 8 PNG lama di `public/heroimg/`**: dihapus dari repo karena sudah digantikan 6 JPG baru (menghemat ~21 MB ukuran repo & mempercepat loading beranda).

---

## 6. Rencana Verifikasi
1. Jalankan suite PHPUnit lengkap (`php artisan test`), termasuk feature test baru untuk Proses Produksi (7 tahap + 17 foto), Beranda (6 foto landscape), `SuperAdminAuth` (403 untuk admin biasa, 200 untuk superadmin), CRUD akun admin + reset password + login dengan akun/password baru + guardrails (self-delete, last superadmin), dan `/admin/settings`.
2. Jalankan `npm run build` dan pastikan exit code 0.
3. Jalankan server lokal (`php artisan serve`) dan lakukan inspeksi langsung + click-through interaktif di browser (desktop & mobile, mode terang & gelap, keyboard Tab/Enter/Escape) serta laporkan **Antislop Delivery Gate** lengkap sebelum serah terima.
