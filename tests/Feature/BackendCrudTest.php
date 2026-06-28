<?php

namespace Tests\Feature;

use App\Models\Artisan;
use App\Models\Category;
use App\Models\Collection;
use App\Models\HistoryPage;
use App\Models\ProductionStage;
use App\Models\User;
use App\Models\VirtualTour;
use App\Models\VillageProfile;
use App\Models\BoardMember;
use App\Models\ProductionLocation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BackendCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Category $category;
    protected Artisan $artisan;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create basic Category
        $this->category = Category::create([
            'name' => 'Kendi & Wadah Air',
            'slug' => 'kendi-wadah-air',
            'color_hex' => '#6B3D14',
            'description' => 'Simbol air kehidupan',
            'sort_order' => 1,
        ]);

        // Create basic Artisan
        $this->artisan = Artisan::create([
            'name' => 'Maestro Sutiwan',
            'address' => 'RT 01 RW 02 Sitiwinangun',
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        // Create default virtual tour row (needed by controller)
        VirtualTour::create([
            'title' => 'Tour Default',
            'description' => 'Tour desc',
            'embed_type' => 'pannellum',
            'embed_code' => '<iframe></iframe>',
            'sanitized_code' => '<iframe></iframe>',
            'is_active' => true,
        ]);

        // Create default village profile row
        VillageProfile::create([
            'name' => 'Desa Sitiwinangun',
            'description' => 'Profil desa.',
            'address' => 'Jalan Utama',
            'latitude' => -6.7123,
            'longitude' => 108.4567,
            'gallery_photos' => [],
        ]);

        // Create default history rows
        HistoryPage::create([
            'page_key' => 'desa_history',
            'title' => 'Sejarah Desa',
            'content' => 'Konten sejarah desa.',
        ]);

        HistoryPage::create([
            'page_key' => 'gerabah_history',
            'title' => 'Sejarah Gerabah',
            'content' => 'Konten sejarah gerabah.',
        ]);
    }

    /**
     * Test admin dashboard stats.
     */
    public function test_admin_dashboard_can_be_rendered(): void
    {
        // Add one collection to verify stats count
        Collection::create([
            'name' => 'Kendi Air Tradisional',
            'slug' => 'kendi-air-tradisional',
            'category_id' => $this->category->id,
            'photo_url' => 'collections/kendi.jpg',
            'description' => 'Kendi tanah liat manual.',
            'history_origin' => 'Digunakan turun temurun.',
            'technique' => 'Hand-pressed',
            'materials' => 'Tanah liat, pasir',
            'artisan_id' => $this->artisan->id,
            'location' => 'Sitiwinangun',
            'year' => 2024,
            'status' => 'published',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('stats');
    }

    /**
     * Test Collection CRUD.
     */
    public function test_admin_can_create_collection(): void
    {
        $file = UploadedFile::fake()->create('kendi.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post(route('admin.collections.store'), [
            'name' => 'Kendi Baru',
            'category_id' => $this->category->id,
            'artisan_id' => $this->artisan->id,
            'photo' => $file,
            'description' => 'Kendi hias unik.',
            'history_origin' => 'Asal mula gerabah.',
            'philosophy' => 'Tanpa pamrih',
            'technique' => 'Pilin',
            'materials' => 'Tanah liat',
            'location' => 'Sitiwinangun RT 03',
            'year' => 2025,
            'type' => 'koleksi',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.collections.index'));
        $this->assertDatabaseHas('collections', [
            'name' => 'Kendi Baru',
            'slug' => 'kendi-baru',
            'status' => 'published',
        ]);
        
        // Assert file was stored
        $collection = Collection::where('name', 'Kendi Baru')->first();
        Storage::disk('public')->assertExists($collection->photo_url);
    }

    /**
     * Test Virtual Tour Index View.
     */
    public function test_admin_can_view_virtual_tour_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.virtual-tour.index'));
        $response->assertStatus(200);
    }

    /**
     * Test Village Profile update.
     */
    public function test_admin_can_update_village_profile(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.village-profile.update'), [
            'name' => 'Sitiwinangun Hebat',
            'description' => 'Profil deskripsi baru.',
            'address' => 'Jalan Cirebon',
            'latitude' => -6.7198,
            'longitude' => 108.4658,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('village_profile', [
            'name' => 'Sitiwinangun Hebat',
            'description' => 'Profil deskripsi baru.',
            'address' => 'Jalan Cirebon',
            'latitude' => -6.7198,
            'longitude' => 108.4658,
        ]);
    }

    public function test_admin_can_update_village_profile_with_photos(): void
    {
        Storage::fake('public');

        $photo1 = UploadedFile::fake()->create('village1.jpg', 100, 'image/jpeg');
        $photo2 = UploadedFile::fake()->create('village2.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->admin)->put(route('admin.village-profile.update'), [
            'name' => 'Sitiwinangun Hebat',
            'description' => 'Profil deskripsi baru.',
            'address' => 'Jalan Cirebon',
            'photos' => [$photo1, $photo2],
        ]);

        $response->assertRedirect();
        
        $profile = VillageProfile::first();
        $this->assertCount(2, $profile->gallery_photos);
        
        Storage::disk('public')->assertExists($profile->gallery_photos[0]);
        Storage::disk('public')->assertExists($profile->gallery_photos[1]);

        // Test delete photo
        $photoToDelete = $profile->gallery_photos[0];
        $photoToKeep = $profile->gallery_photos[1];

        $deleteResponse = $this->actingAs($this->admin)->put(route('admin.village-profile.update'), [
            'name' => 'Sitiwinangun Hebat',
            'description' => 'Profil deskripsi baru.',
            'address' => 'Jalan Cirebon',
            'delete_photos' => [$photoToDelete],
        ]);

        $deleteResponse->assertRedirect();

        $profile->refresh();
        $this->assertCount(1, $profile->gallery_photos);
        $this->assertEquals($photoToKeep, $profile->gallery_photos[0]);
        Storage::disk('public')->assertMissing($photoToDelete);
    }

    public function test_admin_can_update_history(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.history.update'), [
            'desa_title' => 'Sejarah Desa Baru',
            'desa_content' => 'Narasi baru desa abdimas.',
            'gerabah_title' => 'Sejarah Gerabah Baru',
            'gerabah_content' => 'Narasi baru gerabah abdimas.',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('history_pages', [
            'page_key' => 'desa_history',
            'title' => 'Sejarah Desa Baru',
            'content' => 'Narasi baru desa abdimas.',
        ]);

        $this->assertDatabaseHas('history_pages', [
            'page_key' => 'gerabah_history',
            'title' => 'Sejarah Gerabah Baru',
            'content' => 'Narasi baru gerabah abdimas.',
        ]);
    }

    public function test_admin_can_manage_board_members(): void
    {
        // 1. Test Index
        $response = $this->actingAs($this->admin)->get(route('admin.board-members.index'));
        $response->assertStatus(200);

        // 2. Test Store
        $storeResponse = $this->actingAs($this->admin)->post(route('admin.board-members.store'), [
            'name' => 'Pengurus Baru',
            'position' => 'Ketua BUMDes',
            'phone' => '0812345678',
            'email' => 'pengurus@desa.id',
            'sort_order' => 1,
        ]);
        $storeResponse->assertRedirect(route('admin.board-members.index'));
        $this->assertDatabaseHas('board_members', [
            'name' => 'Pengurus Baru',
            'position' => 'Ketua BUMDes',
        ]);

        $member = BoardMember::where('name', 'Pengurus Baru')->first();

        // 3. Test Edit View
        $editResponse = $this->actingAs($this->admin)->get(route('admin.board-members.edit', $member));
        $editResponse->assertStatus(200);

        // 4. Test Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.board-members.update', $member), [
            'name' => 'Pengurus Edit',
            'position' => 'Sekretaris BUMDes',
            'sort_order' => 2,
        ]);
        $updateResponse->assertRedirect(route('admin.board-members.index'));
        $this->assertDatabaseHas('board_members', [
            'id' => $member->id,
            'name' => 'Pengurus Edit',
            'position' => 'Sekretaris BUMDes',
            'sort_order' => 2,
        ]);

        // 5. Test Destroy
        $destroyResponse = $this->actingAs($this->admin)->delete(route('admin.board-members.destroy', $member));
        $destroyResponse->assertRedirect(route('admin.board-members.index'));
        $this->assertDatabaseMissing('board_members', [
            'id' => $member->id,
        ]);
    }



    /**
     * Test Artisan CRUD.
     */
    public function test_admin_can_create_artisan(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.artisans.store'), [
            'name' => 'Pengrajin Baru',
            'years_active' => '15 tahun',
            'specialty' => 'Gentong',
            'story' => 'Cerita hidup.',
            'quote' => 'Kutipan indah.',
            'address' => 'RT 02 RW 01',
            'phone' => '0812345678',
            'is_featured' => true,
            'sort_order' => 5,
        ]);

        $response->assertRedirect(route('admin.artisans.index'));
        $this->assertDatabaseHas('artisans', [
            'name' => 'Pengrajin Baru',
            'years_active' => '15 tahun',
            'is_featured' => true,
            'sort_order' => 5,
        ]);
    }

    public function test_admin_can_update_artisan(): void
    {
        $artisan = Artisan::create([
            'name' => 'Pengrajin Edit',
            'address' => 'RT 03 RW 01',
            'is_featured' => false,
            'sort_order' => 10,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.artisans.update', $artisan), [
            'name' => 'Pengrajin Edit Update',
            'years_active' => '10 tahun',
            'specialty' => 'Cobek',
            'story' => 'Kisah edit.',
            'address' => 'RT 03 RW 01 Baru',
            'phone' => '08987654321',
            'is_featured' => true,
            'sort_order' => 20,
        ]);

        $response->assertRedirect(route('admin.artisans.index'));
        $this->assertDatabaseHas('artisans', [
            'id' => $artisan->id,
            'name' => 'Pengrajin Edit Update',
            'years_active' => '10 tahun',
            'is_featured' => true,
            'sort_order' => 20,
        ]);
    }

    public function test_admin_can_toggle_featured_artisan(): void
    {
        $artisan = Artisan::create([
            'name' => 'Pengrajin Toggle',
            'address' => 'RT 03 RW 01',
            'is_featured' => false,
            'sort_order' => 10,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.artisans.toggle-featured', $artisan));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_featured' => true,
        ]);
        $this->assertTrue($artisan->fresh()->is_featured);
    }

    public function test_admin_can_delete_artisan(): void
    {
        $artisan = Artisan::create([
            'name' => 'Pengrajin Hapus',
            'address' => 'RT 03 RW 01',
            'is_featured' => false,
            'sort_order' => 10,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.artisans.destroy', $artisan));

        $response->assertRedirect(route('admin.artisans.index'));
        $this->assertDatabaseMissing('artisans', [
            'id' => $artisan->id,
        ]);
    }

    /**
     * Test Production Stage CRUD.
     */
    public function test_admin_can_render_production_stages_index(): void
    {
        // Create a stage first
        $stage = ProductionStage::create([
            'stage_number' => 1,
            'title' => 'Tahap Awal',
            'description' => 'Tahapan persiapan.',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.production.index'));

        $response->assertStatus(200);
        $response->assertViewHas('stages');
    }

    public function test_admin_can_update_production_stage(): void
    {
        $stage = ProductionStage::create([
            'stage_number' => 2,
            'title' => 'Tahap Dua',
            'description' => 'Tahapan pembentukan.',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.production.update', $stage), [
            'title' => 'Tahap Dua Update',
            'description' => 'Tahapan pembentukan terupdate.',
        ]);

        $response->assertRedirect(route('admin.production.index'));
        $this->assertDatabaseHas('production_stages', [
            'id' => $stage->id,
            'title' => 'Tahap Dua Update',
            'description' => 'Tahapan pembentukan terupdate.',
        ]);
    }

    /**
     * Test Storytelling Chapters management.
     */
    public function test_admin_can_manage_storytelling(): void
    {
        // 1. Test Index
        $indexResponse = $this->actingAs($this->admin)->get(route('admin.storytelling.index'));
        $indexResponse->assertStatus(200);

        // 2. Test Update Chapters
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.storytelling.update'), [
            'bab2_main_desc' => 'Deskripsi Utama Bab 2 Baru',
            'bab2_fungsional_text' => 'Fungsional Baru',
            'bab2_religi_text' => 'Religi Baru',
            'bab2_simbolik_text' => 'Simbolik Baru',
            'bab2_estetis_text' => 'Estetis Baru',

            'bab3_main_desc' => 'Deskripsi Utama Bab 3 Baru',
            'bab3_motif_1_title' => 'Motif 1 Baru',
            'bab3_motif_1_desc' => 'Desc 1 Baru',
            'bab3_motif_2_title' => 'Motif 2 Baru',
            'bab3_motif_2_desc' => 'Desc 2 Baru',
            'bab3_motif_3_title' => 'Motif 3 Baru',
            'bab3_motif_3_desc' => 'Desc 3 Baru',
            'bab3_motif_4_title' => 'Motif 4 Baru',
            'bab3_motif_4_desc' => 'Desc 4 Baru',
            'bab3_motif_5_title' => 'Motif 5 Baru',
            'bab3_motif_5_desc' => 'Desc 5 Baru',
            'bab3_motif_6_title' => 'Motif 6 Baru',
            'bab3_motif_6_desc' => 'Desc 6 Baru',

            'bab4_main_desc' => 'Deskripsi Utama Bab 4 Baru',
            'bab4_paksi_text' => 'Paksi Baru',
            'bab4_macan_text' => 'Macan Baru',
            'bab4_singabarong_text' => 'Singabarong Baru',
            'bab4_paksi_card_desc' => 'Card Paksi Baru',
            'bab4_macan_card_desc' => 'Card Macan Baru',
            'bab4_singabarong_card_desc' => 'Card Singabarong Baru',

            'bab5_main_desc' => 'Deskripsi Utama Bab 5 Baru',
            'bab5_tutur_1_title' => 'Tutur 1 Baru',
            'bab5_tutur_1_desc' => 'Desc Tutur 1 Baru',
            'bab5_tutur_1_subtext' => 'Subtext Tutur 1 Baru',
            'bab5_tutur_2_title' => 'Tutur 2 Baru',
            'bab5_tutur_2_desc' => 'Desc Tutur 2 Baru',
            'bab5_tutur_2_subtext' => 'Subtext Tutur 2 Baru',
        ]);

        $updateResponse->assertRedirect(route('admin.storytelling.index'));
        $this->assertDatabaseHas('storytelling_chapters', [
            'chapter_key' => 'bab_2',
        ]);
    }

    /**
     * Test Production Location CRUD.
     */
    public function test_admin_can_manage_locations(): void
    {
        Storage::fake('public');

        // Create dependency
        $artisan = Artisan::create([
            'name' => 'Pak Budi',
            'address' => 'RT 01',
            'sort_order' => 1,
        ]);

        // 1. Test Index
        $indexResponse = $this->actingAs($this->admin)->get(route('admin.locations.index'));
        $indexResponse->assertStatus(200);

        // 2. Test Store with photo
        $photo = UploadedFile::fake()->create('location.jpg', 500, 'image/jpeg');

        $storeResponse = $this->actingAs($this->admin)->post(route('admin.locations.store'), [
            'artisan_id' => $artisan->id,
            'name' => 'Rumah Gerabah Pak Budi',
            'address' => 'Jalan Gerabah No. 1',
            'latitude' => -6.7029,
            'longitude' => 108.4831,
            'phone' => '08123456789',
            'is_open_visit' => true,
            'photo' => $photo,
        ]);
        $storeResponse->assertRedirect(route('admin.locations.index'));
        $this->assertDatabaseHas('production_locations', [
            'name' => 'Rumah Gerabah Pak Budi',
            'artisan_id' => $artisan->id,
            'is_open_visit' => true,
        ]);

        $loc = ProductionLocation::where('name', 'Rumah Gerabah Pak Budi')->first();
        Storage::disk('public')->assertExists($loc->photo_url);

        // 3. Test Edit View
        $editResponse = $this->actingAs($this->admin)->get(route('admin.locations.edit', $loc));
        $editResponse->assertStatus(200);

        // 4. Test Update (no new photo)
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.locations.update', $loc), [
            'name' => 'Rumah Gerabah Pak Budi (Renovasi)',
            'address' => 'Jalan Gerabah No. 1A',
            'latitude' => -6.7030,
            'longitude' => 108.4832,
            'is_open_visit' => false,
        ]);
        $updateResponse->assertRedirect(route('admin.locations.index'));
        $this->assertDatabaseHas('production_locations', [
            'id' => $loc->id,
            'name' => 'Rumah Gerabah Pak Budi (Renovasi)',
            'is_open_visit' => false,
        ]);

        // 5. Test Destroy
        $destroyResponse = $this->actingAs($this->admin)->delete(route('admin.locations.destroy', $loc));
        $destroyResponse->assertRedirect(route('admin.locations.index'));
        $this->assertDatabaseMissing('production_locations', [
            'id' => $loc->id,
        ]);
    }
}

