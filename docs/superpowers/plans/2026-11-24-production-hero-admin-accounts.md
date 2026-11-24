# Pembaruan Proses Produksi, Hero Beranda, dan Manajemen Akun Admin Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Memperbarui halaman Proses Produksi menjadi 7 tahapan editorial dengan 17 foto galeri + lightbox, mengganti foto hero Beranda menjadi 6 foto landscape + kontrol aksesibilitas dan pembersihan AI slop, serta menambahkan fitur Manajemen Akun Admin (khusus `superadmin`) dan merapikan halaman Pengaturan Akun.

**Architecture:** Proses Produksi dipindahkan ke config Laravel (`config/production_stages.php`) dengan aset statis di `public/images/production/` agar ikut deploy Git ke Hostinger tanpa migrasi DB maupun menyentuh `storage/app/public/`. Hero Beranda membaca 6 foto landscape di `public/heroimg/` lewat `HomeController`. Manajemen akun menggunakan tabel `users` yang sudah ada dengan middleware `SuperAdminAuth` dan `Admin\UserController`.

**Tech Stack:** Laravel 13, PHP 8.4, Blade, Tailwind CSS 4, DaisyUI 5 (`batik-light` / `batik-dark`), Alpine.js 3, Vite 8, PHPUnit 12.

**Spec:** [2026-11-24-production-hero-admin-accounts-design.md](file:///c:/Users/Ridzuan/dev/Website-Desa-Sitiwinangun/docs/superpowers/specs/2026-11-24-production-hero-admin-accounts-design.md)

## Global Constraints
- Tidak ada file migrasi database baru dan tidak mengubah `storage/app/public/` atau `.env`.
- Semua teks UI dan copywriting pada halaman yang disentuh bebas em dash (`—`) dan buzzword AI slop (antislop R-02, R-16).
- Seluruh kontrol interaktif memakai elemen semantik native (`<button>`, `<a href>`), dapat dioperasikan via keyboard (`Tab`, `Enter`, `Escape`), memiliki label aksesibel, dan mendukung `batik-light` & `batik-dark` dengan kontras WCAG AA (R-03, R-25, R-32, R-39).
- Semua media `<img>` memiliki dimensi/aspect-ratio tetap; foto hero pertama `fetchpriority="high"` tanpa `loading="lazy"` (R-40).
- Password maupun hash tidak pernah ditulis ke `activity_logs`.
- Seluruh aset gambar memakai nama file ASCII tanpa spasi agar aman di URL Hostinger Linux.

## Review Focus
- **Akses langsung URL admin akun oleh role `admin` biasa**: request GET/POST/PUT/PATCH/DELETE ke `/admin/users*` oleh user ber-role `admin` harus ditolak `403`, bukan hanya disembunyikan di sidebar. (Dipin di Task 3)
- **Superadmin terakhir atau diri sendiri dinonaktifkan/diturunkan role/dihapus**: `UserController@update`, `toggleActive`, dan `destroy` harus menolak pengubahan role/penonaktifan/penghapusan diri sendiri maupun superadmin aktif terakhir agar sistem tidak pernah kehilangan akses superadmin. (Dipin di Task 3)
- **Kebocoran password di `activity_logs`**: saat `create_user` atau `update_user` dengan ganti password dijalankan, kolom `old_value` dan `new_value` di `activity_logs` tidak boleh memuat string password ataupun hash bcrypt. (Dipin di Task 3)
- **Reset password pada akun terkunci (`locked_until` di masa depan)**: saat `superadmin` mengganti password akun yang terkunci, `failed_attempts` harus kembali `0` dan `locked_until` menjadi `null` sehingga akun langsung bisa login. (Dipin di Task 3)
- **Aset gambar 17 foto produksi & 6 foto hero hilang atau gagal termuat**: setiap path di `config/production_stages.php` dan `$heroSlides` di `HomeController` harus terverifikasi ada di `public/` tanpa spasi dan tanpa foto lama PNG tersisa di `public/heroimg/`. (Dipin di Task 1 & Task 2)

---

### Task 1: Halaman Proses Produksi (7 Tahap, 17 Foto, Galeri + Lightbox, Anti-Slop)

**Files:**
- Create: `public/images/production/tahap-1-menguleni-1.jpg` .. `tahap-7-pembakaran-1.jpg` (17 file disalin dari `c:\Users\Ridzuan\Pictures\Foto EDIT\Proses`)
- Create: `config/production_stages.php`
- Modify: `app/Http/Controllers/Public/ProductionController.php:1-18`
- Modify: `resources/views/public/production.blade.php:1-98`
- Test: `tests/Feature/ProductionPageTest.php`

**Interfaces:**
- Produces: `config('production_stages')` — array of 7 associative arrays `['number' => int, 'slug' => string, 'title' => string, 'summary' => string, 'description' => string, 'photos' => list<array{src: string, alt: string, caption: string, orientation: 'landscape'|'portrait'}>]`.
- Produces: `GET /proses-produksi` (`public.production`) rendering all 7 stages, jump navigation anchors `#tahap-1`..`#tahap-7`, interactive Alpine thumbnail switcher + lightbox modal.

- [ ] **Step 1: Write the failing test in `tests/Feature/ProductionPageTest.php`**

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductionPageTest extends TestCase
{
    public function test_production_page_renders_seven_stages_and_all_seventeen_photos(): void
    {
        $stages = config('production_stages');
        $this->assertIsArray($stages);
        $this->assertCount(7, $stages);

        $totalPhotos = 0;
        foreach ($stages as $stage) {
            $this->assertNotEmpty($stage['photos']);
            foreach ($stage['photos'] as $photo) {
                $totalPhotos++;
                $this->assertFileExists(public_path($photo['src']));
                $this->assertStringNotContainsString(' ', $photo['src']);
            }
        }
        $this->assertSame(17, $totalPhotos);

        $response = $this->get(route('public.production'));
        $response->assertOk();
        $response->assertDontSee('—');
        $response->assertDontSee('5 tahapan');

        foreach ($stages as $stage) {
            $response->assertSee($stage['title']);
            $response->assertSee('id="' . $stage['slug'] . '"', false);
        }
    }

    public function test_production_page_shows_empty_state_when_config_is_empty(): void
    {
        config()->set('production_stages', []);

        $response = $this->get(route('public.production'));
        $response->assertOk();
        $response->assertSee('id="empty-stages"', false);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/ProductionPageTest.php`
Expected: FAIL because `config/production_stages.php` returns `null` and view still renders DB stages.

- [ ] **Step 3: Copy 17 photos from `c:\Users\Ridzuan\Pictures\Foto EDIT\Proses` to `public/images/production/`**

Mapping exact filenames (skip `proses.psd`):
- `1_1.jpg` -> `tahap-1-menguleni-2.jpg`
- `1_2.jpg` -> `tahap-1-menguleni-3.jpg`
- `1.jpg` -> `tahap-1-menguleni-1.jpg`
- `1_3.jpg` -> `tahap-1-menginjak-1.jpg`
- `1_4.jpg` -> `tahap-1-menginjak-2.jpg`
- `2.jpg` -> `tahap-2-putar-1.jpg`
- `2_1.jpg` -> `tahap-2-putar-2.jpg`
- `2_2.jpg` -> `tahap-2-putar-3.jpg`
- `2_3.jpg` -> `tahap-2-putar-4.jpg`
- `2_4.jpg` -> `tahap-2-putar-5.jpg`
- `3.jpg` -> `tahap-3-kering-awal-1.jpg`
- `3_1.jpg` -> `tahap-3-kering-awal-2.jpg`
- `4.jpg` -> `tahap-4-halus-1.jpg`
- `4_1.jpg` -> `tahap-4-halus-2.jpg`
- `5.jpg` -> `tahap-5-kering-lanjut-1.jpg`
- `proses penyusunan sebelum pembakaran.jpeg` -> `tahap-6-susun-bakar-1.jpg`
- `proses pembakaran.jpeg` -> `tahap-7-pembakaran-1.jpg`

- [ ] **Step 4: Create `config/production_stages.php` and update `ProductionController@index`**

Populate `config/production_stages.php` with all 7 stages and 17 photo entries using natural, factual Indonesian copywriting (zero em dashes, zero buzzwords). Update `ProductionController@index` to pass `$stages = config('production_stages', []);` to `public.production`.

- [ ] **Step 5: Redesign `resources/views/public/production.blade.php` following antislop rules**

Implement editorial header (no uppercase eyebrow pill, no em dash in `<title>` or body), 7-stage anchor jump bar (`#tahap-1`..`#tahap-7`), full-width 2-column alternating editorial blocks (7-col photo gallery + 5-col narrative), Alpine.js thumbnail switcher with photo counter and caption, keyboard-accessible Lightbox modal (`Escape`, `ArrowLeft`, `ArrowRight`, `role="dialog" aria-modal="true"`, uncropped `object-contain`), and clean empty state `#empty-stages`.

- [ ] **Step 6: Run test to verify it passes**

Run: `php artisan test tests/Feature/ProductionPageTest.php`
Expected: PASS (2 tests passed).

- [ ] **Step 7: Commit**

```bash
git add public/images/production config/production_stages.php app/Http/Controllers/Public/ProductionController.php resources/views/public/production.blade.php tests/Feature/ProductionPageTest.php
git commit -m "feat(production): update production stages to 7 editorial steps with 17 photos and lightbox"
```

---

### Task 2: Halaman Beranda (6 Foto Background Landscape + Anti-Slop & Aksesibilitas)

**Files:**
- Delete: `public/heroimg/1.png` .. `public/heroimg/8.png`
- Create: `public/heroimg/bg-1-marini-getak.jpg` .. `public/heroimg/bg-6-rumsani-mangkuk.jpg` (6 landscape JPG dari `c:\Users\Ridzuan\Pictures\Foto EDIT\BG`)
- Modify: `app/Http/Controllers/Public/HomeController.php:1-32`
- Modify: `resources/views/public/home.blade.php:1-416`
- Modify: `resources/views/layouts/public.blade.php:10-25,190-200,240-250`
- Test: `tests/Feature/HomePageTest.php`

**Interfaces:**
- Produces: `$heroSlides` array (`list<array{src: string, alt: string}>`, 6 items) passed from `HomeController@index` to `public.home`.
- Consumes: `route('public.production')` updated copy referencing 7 stages.

- [ ] **Step 1: Write the failing test in `tests/Feature/HomePageTest.php`**

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_six_landscape_hero_images_and_clean_copy(): void
    {
        $expectedFiles = [
            'heroimg/bg-1-marini-getak.jpg',
            'heroimg/bg-2-kadmiya-ikan.jpg',
            'heroimg/bg-3-jaji-penari.jpg',
            'heroimg/bg-4-marini-guci.jpg',
            'heroimg/bg-5-kadmiya-rak.jpg',
            'heroimg/bg-6-rumsani-mangkuk.jpg',
        ];

        foreach ($expectedFiles as $file) {
            $this->assertFileExists(public_path($file));
        }

        for ($i = 1; $i <= 8; $i++) {
            $this->assertFileDoesNotExist(public_path("heroimg/{$i}.png"));
        }

        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertDontSee('—');
        $response->assertDontSee('5 tahap produksi');
        $response->assertSee('7 tahap produksi');
        $response->assertSee('fetchpriority="high"', false);
        $response->assertSee('id="hero-slideshow-toggle"', false);

        foreach ($expectedFiles as $file) {
            $response->assertSee($file, false);
        }
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/HomePageTest.php`
Expected: FAIL because new JPG files do not exist yet and old PNGs still exist.

- [ ] **Step 3: Replace `public/heroimg/` assets**

Remove `public/heroimg/1.png` through `public/heroimg/8.png`. Copy the 6 landscape JPGs from `c:\Users\Ridzuan\Pictures\Foto EDIT\BG`:
- `BG-Marini.jpg` -> `public/heroimg/bg-1-marini-getak.jpg`
- `BG 2_Kadmiya.jpg` -> `public/heroimg/bg-2-kadmiya-ikan.jpg`
- `BG 2_Jaji.jpg` -> `public/heroimg/bg-3-jaji-penari.jpg`
- `BG2-Marini.jpg` -> `public/heroimg/bg-4-marini-guci.jpg`
- `BG_Kadmiya.jpg` -> `public/heroimg/bg-5-kadmiya-rak.jpg`
- `BG_Rumsani.jpg` -> `public/heroimg/bg-6-rumsani-mangkuk.jpg`

- [ ] **Step 4: Update `HomeController.php`, `home.blade.php`, and `layouts/public.blade.php`**

- Pass `$heroSlides` (6 items with descriptive Indonesian `alt`) from `HomeController@index`.
- In `home.blade.php`:
  - Render `$heroSlides` with `fetchpriority="high"` on slide 1 (not lazy) and `loading="lazy"` on slides 2–6.
  - Strengthen gradient overlay (`from-black/70 via-black/40 to-black/30`) for WCAG AA contrast across bright photos.
  - Remove decorative eyebrow pill above `<h1>` and endless `animate-bounce-down` scroll arrow.
  - Add accessible Pause/Play toggle button (`id="hero-slideshow-toggle"`, `aria-pressed`) + slide counter (`1 / 6`) and respect `prefers-reduced-motion: reduce` in slideshow JS.
  - Replace `"5 tahap produksi..."` with `"7 tahap produksi dari pengolahan tanah liat hingga pembakaran terbuka."`
  - Replace sparkle icon on `"Dibuat dengan Tangan"` (and in `layouts/public.blade.php` mobile nav for Proses Produksi) with a relevant pottery/craft icon.
  - Remove all em dashes (`—`) in `home.blade.php` and `layouts/public.blade.php`.

- [ ] **Step 5: Run test to verify it passes**

Run: `php artisan test tests/Feature/HomePageTest.php`
Expected: PASS.

- [ ] **Step 6: Commit**

```bash
git add public/heroimg app/Http/Controllers/Public/HomeController.php resources/views/public/home.blade.php resources/views/layouts/public.blade.php tests/Feature/HomePageTest.php
git commit -m "feat(home): replace hero images with 6 landscape photos and remove AI slop"
```

---

### Task 3: Fitur Admin — Manajemen Akun (`SuperAdminAuth` + `UserController` + Views)

**Files:**
- Create: `app/Http/Middleware/SuperAdminAuth.php`
- Create: `app/Http/Controllers/Admin/UserController.php`
- Create: `resources/views/admin/users/index.blade.php`
- Create: `resources/views/admin/users/create.blade.php`
- Create: `resources/views/admin/users/edit.blade.php`
- Modify: `routes/web.php:120-128`
- Modify: `resources/views/layouts/admin.blade.php:11,64-116,225-238`
- Modify: `resources/views/admin/partials/_delete-modal.blade.php:1-28`
- Modify: `resources/views/admin/settings/index.blade.php:1-146`
- Modify: `app/Http/Controllers/Admin/SettingController.php:1-56`
- Test: `tests/Feature/AdminUserManagementTest.php`

**Interfaces:**
- Produces: `App\Http\Middleware\SuperAdminAuth::handle(Request $request, Closure $next): Response` — returns `403` when `Auth::user()->role !== 'superadmin'`.
- Produces routes: `admin.users.index`, `admin.users.create`, `admin.users.store`, `admin.users.edit`, `admin.users.update`, `admin.users.toggle-active`, `admin.users.destroy`.
- Consumes: `App\Services\ActivityLogService::log(string $action, ?string $targetType, ?int $targetId, mixed $oldValue, mixed $newValue): void`.

- [ ] **Step 1: Write the failing test in `tests/Feature/AdminUserManagementTest.php`**

Cover all behaviors and Review Focus edge cases:
- `test_regular_admin_is_forbidden_from_user_management_routes()` (`GET /admin/users`, `POST /admin/users`, `PUT`, `PATCH`, `DELETE` -> `403`).
- `test_superadmin_can_list_and_create_new_admin_account_and_login_with_it()`.
- `test_superadmin_can_reset_another_users_password_and_unlock_locked_account()` (verifies new password logs in, `failed_attempts === 0`, `locked_until === null`, and `activity_logs` contains neither plaintext password nor hash).
- `test_superadmin_cannot_deactivate_demote_or_delete_self()`.
- `test_superadmin_cannot_deactivate_demote_or_delete_last_active_superadmin()`.
- `test_superadmin_can_toggle_active_and_delete_other_admin()`.
- `test_regular_admin_can_still_update_own_profile_and_password_in_settings()`.

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/AdminUserManagementTest.php`
Expected: FAIL (routes/middleware/controller do not exist yet).

- [ ] **Step 3: Implement `SuperAdminAuth` middleware, `Admin\UserController`, and register routes in `routes/web.php`**

- `SuperAdminAuth`: verify `Auth::check() && Auth::user()->is_active && Auth::user()->role === 'superadmin'`, else `abort(403, 'Hanya superadmin yang dapat mengelola akun admin.')`.
- `UserController` (constructor injects `ActivityLogService`):
  - `index(Request $request)`: optional search by name/email, order superadmin first then name asc, return `admin.users.index`.
  - `create()` & `store(Request $request)`: validate `name` (max:100), `email` (email, unique), `role` (`in:admin,superadmin`), `password` (confirmed, min:8), `is_active` (boolean default true); create user; log sanitized attributes (never password).
  - `edit(User $user)` & `update(Request $request, User $user)`: validate profile + optional `password` (`nullable`, `confirmed`, `min:8`); enforce self-protection and last-active-superadmin protection; if password filled, update password and reset `failed_attempts = 0` & `locked_until = null`; log sanitized old/new values (`password_changed: true` flag only, never password/hash).
  - `toggleActive(User $user)`: enforce self & last-active-superadmin guardrails; toggle `is_active`; if reactivated, reset lock; log.
  - `destroy(User $user)`: enforce self & last-active-superadmin guardrails; delete user; log.
- In `SettingController@update`: validate `name` max:100 (matching DB column `varchar(100)`), keep password check + `min:8`, record sanitized activity log.

- [ ] **Step 4: Build Admin Users views & clean up Admin Layout, Delete Modal, and Settings view**

- Create `resources/views/admin/users/index.blade.php`, `create.blade.php`, `edit.blade.php` matching DaisyUI earthy admin theme, zero em dashes, proper `<label for="...">` + `<input id="...">`, accessible show/hide password toggle (`type="button"`, `aria-label`, `aria-pressed`), clear empty state when search yields 0 results, and action buttons using native `<button>`/`<a href>`.
- Update `resources/views/layouts/admin.blade.php`:
  - Replace `—` with `|` in `<title>`.
  - Fix dead links in user dropdown (`Pengaturan Akun` -> `route('admin.settings.index')`, plus `Kelola Akun` -> `route('admin.users.index')` for `superadmin`).
  - Add sidebar menu item `Kelola Akun` under `Sistem` wrapped in `@if(Auth::user()->role === 'superadmin')`.
- Update `resources/views/admin/partials/_delete-modal.blade.php`: add `x-on:keydown.escape.window="isOpen = false"`, `role="dialog"`, `aria-modal="true"`, `type="button"` on Batal.
- Update `resources/views/admin/settings/index.blade.php`: remove duplicate `@include('admin.partials._form-errors')`, replace `"Aksi Penyelamatan"` with `"Simpan Pengaturan"`, wire `for`/`id` labels, add accessible password visibility toggles, remove any em dashes.

- [ ] **Step 5: Run tests to verify they pass**

Run: `php artisan test tests/Feature/AdminUserManagementTest.php`
Expected: PASS (all tests green).

- [ ] **Step 6: Commit**

```bash
git add app/Http/Middleware/SuperAdminAuth.php app/Http/Controllers/Admin/UserController.php app/Http/Controllers/Admin/SettingController.php routes/web.php resources/views/admin/users resources/views/admin/settings/index.blade.php resources/views/layouts/admin.blade.php resources/views/admin/partials/_delete-modal.blade.php tests/Feature/AdminUserManagementTest.php
git commit -m "feat(admin): add superadmin account management and polish settings UI"
```

---

### Task 4: Frontend Production Build, Full Test Suite, Browser Click-Through & Delivery Gate

**Files:**
- Modify: `resources/css/app.css` (only if base cursor/focus/reduced-motion polish needed)
- Rebuild: `public/build/*` (via `npm run build`)

- [ ] **Step 1: Audit CSS & run production Vite build**

Ensure interactive cursor/focus styles meet R-32/R-39 and `prefers-reduced-motion` is respected.
Run: `npm run build`
Expected: Exit code 0, fresh `public/build/manifest.json` & CSS/JS assets generated.

- [ ] **Step 2: Run full PHPUnit test suite**

Run: `php artisan test`
Expected: All existing + new tests PASS with 0 failures.

- [ ] **Step 3: Live local server & browser click-through verification (R-35)**

Start `php artisan serve` and click through via browser subagent on desktop & mobile, light & dark theme:
- `/` (hero 6 slides, pause/play toggle, CTAs, 7 tahap copy, contrast check)
- `/proses-produksi` (jump anchors `#tahap-1`..`#tahap-7`, thumbnail switching, lightbox open/next/prev/Escape, portrait & landscape framing, mobile responsiveness)
- `/admin/login` -> login as superadmin -> `/admin/settings` (clean labels, no duplicate error box, password toggle) -> `/admin/users` (create account, edit/reset password, toggle active, delete modal + Escape, verify regular admin receives 403).
Record concrete element-by-element click-through evidence and run the full **Antislop Delivery Gate** (Blocks 1–4) before handing over.

- [ ] **Step 4: Commit updated build assets (if changed)**

```bash
git add -f public/build resources/css/app.css
git commit -m "chore: rebuild production assets for Hostinger deployment"
```
