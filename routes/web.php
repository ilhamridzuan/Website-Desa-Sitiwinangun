<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Middleware\AdminAuth;

// ==========================================
// Public Halaman Routes
// ==========================================
Route::get('/', [App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');
Route::get('/galeri', [App\Http\Controllers\Public\CollectionController::class, 'index'])->name('public.collections.index');
Route::get('/koleksi/{slug}', [App\Http\Controllers\Public\CollectionController::class, 'show'])->name('public.collections.show');
Route::get('/pengrajin', [App\Http\Controllers\Public\ArtisanController::class, 'index'])->name('public.artisans.index');
Route::get('/pengrajin/{id}', [App\Http\Controllers\Public\ArtisanController::class, 'show'])
    ->name('public.artisans.show')
    ->whereNumber('id');
Route::get('/virtual-tour', [App\Http\Controllers\Public\VirtualTourController::class, 'index'])->name('public.virtual_tour');
Route::get('/proses-produksi', [App\Http\Controllers\Public\ProductionController::class, 'index'])->name('public.production');
Route::get('/tentang', [App\Http\Controllers\Public\StaticPageController::class, 'about'])->name('public.about');
Route::get('/sejarah', [App\Http\Controllers\Public\StaticPageController::class, 'history'])->name('public.history');
Route::get('/jelajah', [App\Http\Controllers\Public\StaticPageController::class, 'locations'])->name('public.locations');
Route::get('/pengurus', [App\Http\Controllers\Public\StaticPageController::class, 'board'])->name('public.board');
Route::get('/storytelling', [App\Http\Controllers\Public\StaticPageController::class, 'storytelling'])->name('public.storytelling');

// ==========================================
// Admin Area Routes
// ==========================================
Route::prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');

    // Protected Admin Routes
    Route::middleware(AdminAuth::class)->group(function () {
        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        // Collections CRUD
        Route::resource('collections', App\Http\Controllers\Admin\CollectionController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.collections.index',
                'create' => 'admin.collections.create',
                'store' => 'admin.collections.store',
                'edit' => 'admin.collections.edit',
                'update' => 'admin.collections.update',
                'destroy' => 'admin.collections.destroy',
            ]);

        // Artisans CRUD
        Route::resource('artisans', App\Http\Controllers\Admin\ArtisanController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.artisans.index',
                'create' => 'admin.artisans.create',
                'store' => 'admin.artisans.store',
                'edit' => 'admin.artisans.edit',
                'update' => 'admin.artisans.update',
                'destroy' => 'admin.artisans.destroy',
            ]);
        Route::patch('artisans/{artisan}/toggle-featured', [App\Http\Controllers\Admin\ArtisanController::class, 'toggleFeatured'])
            ->name('admin.artisans.toggle-featured');



        // Static Content

        Route::get('village-profile', [App\Http\Controllers\Admin\StaticContentController::class, 'edit'])
            ->defaults('module', 'village-profile')
            ->name('admin.village-profile.edit');
        Route::put('village-profile', [App\Http\Controllers\Admin\StaticContentController::class, 'update'])
            ->defaults('module', 'village-profile')
            ->name('admin.village-profile.update');

        Route::get('history', [App\Http\Controllers\Admin\StaticContentController::class, 'edit'])
            ->defaults('module', 'history')
            ->name('admin.history.edit');
        Route::put('history', [App\Http\Controllers\Admin\StaticContentController::class, 'update'])
            ->defaults('module', 'history')
            ->name('admin.history.update');

        // Board Members CRUD
        Route::resource('board-members', App\Http\Controllers\Admin\BoardMemberController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.board-members.index',
                'create' => 'admin.board-members.create',
                'store' => 'admin.board-members.store',
                'edit' => 'admin.board-members.edit',
                'update' => 'admin.board-members.update',
                'destroy' => 'admin.board-members.destroy',
            ]);


        // Storytelling CRUD
        Route::resource('storytelling', App\Http\Controllers\Admin\StorytellingDocController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.storytelling.index',
                'create' => 'admin.storytelling.create',
                'store' => 'admin.storytelling.store',
                'edit' => 'admin.storytelling.edit',
                'update' => 'admin.storytelling.update',
                'destroy' => 'admin.storytelling.destroy',
            ]);

        // Locations CRUD
        Route::resource('locations', App\Http\Controllers\Admin\ProductionLocationController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.locations.index',
                'create' => 'admin.locations.create',
                'store' => 'admin.locations.store',
                'edit' => 'admin.locations.edit',
                'update' => 'admin.locations.update',
                'destroy' => 'admin.locations.destroy',
            ]);

        // Inventory CRUD
        Route::resource('inventory', App\Http\Controllers\Admin\InventoryController::class)
            ->except(['show'])
            ->names([
                'index' => 'admin.inventory.index',
                'create' => 'admin.inventory.create',
                'store' => 'admin.inventory.store',
                'edit' => 'admin.inventory.edit',
                'update' => 'admin.inventory.update',
                'destroy' => 'admin.inventory.destroy',
            ]);
    });
});
