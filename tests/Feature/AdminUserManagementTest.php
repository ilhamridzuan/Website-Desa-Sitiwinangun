<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function makeSuperAdmin(string $email = 'super@sitiwinangun.id'): User
    {
        return User::factory()->create([
            'name' => 'Super Admin Utama',
            'email' => $email,
            'password' => Hash::make('Password@123'),
            'role' => 'superadmin',
            'is_active' => true,
        ]);
    }

    private function makeAdmin(string $email = 'staff@sitiwinangun.id'): User
    {
        return User::factory()->create([
            'name' => 'Admin Konten',
            'email' => $email,
            'password' => Hash::make('Password@123'),
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_regular_admin_is_forbidden_from_user_management_routes(): void
    {
        $admin = $this->makeAdmin();
        $other = $this->makeAdmin('other@sitiwinangun.id');

        $this->actingAs($admin)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($admin)->get(route('admin.users.create'))->assertForbidden();
        $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Baru',
            'email' => 'baru@sitiwinangun.id',
            'role' => 'admin',
            'password' => 'Rahasia@123',
            'password_confirmation' => 'Rahasia@123',
        ])->assertForbidden();
        $this->actingAs($admin)->get(route('admin.users.edit', $other))->assertForbidden();
        $this->actingAs($admin)->put(route('admin.users.update', $other), [
            'name' => 'Diubah',
            'email' => $other->email,
            'role' => 'admin',
        ])->assertForbidden();
        $this->actingAs($admin)->patch(route('admin.users.toggle-active', $other))->assertForbidden();
        $this->actingAs($admin)->delete(route('admin.users.destroy', $other))->assertForbidden();
    }

    public function test_superadmin_can_list_and_create_new_admin_account_and_login_with_it(): void
    {
        $super = $this->makeSuperAdmin();

        $indexResponse = $this->actingAs($super)->get(route('admin.users.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('Super Admin Utama');
        $indexResponse->assertDontSee('—');

        $plainPassword = 'AkunBaru@2026';

        $createResponse = $this->actingAs($super)->post(route('admin.users.store'), [
            'name' => 'Admin Baru Desa',
            'email' => 'admin.baru@sitiwinangun.id',
            'role' => 'admin',
            'password' => $plainPassword,
            'password_confirmation' => $plainPassword,
            'is_active' => '1',
        ]);

        $createResponse->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Admin Baru Desa',
            'email' => 'admin.baru@sitiwinangun.id',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $created = User::where('email', 'admin.baru@sitiwinangun.id')->firstOrFail();
        $this->assertTrue(Hash::check($plainPassword, $created->password));

        // Verify activity log does NOT contain plaintext password or password hash
        $log = ActivityLog::where('action', 'create_user')->where('target_id', $created->id)->first();
        $this->assertNotNull($log);
        $this->assertStringNotContainsString($plainPassword, (string) $log->new_value);
        $this->assertStringNotContainsString($created->password, (string) $log->new_value);

        // Logout and login with new account
        $this->post(route('admin.logout'));
        $loginResponse = $this->post(route('admin.login'), [
            'email' => 'admin.baru@sitiwinangun.id',
            'password' => $plainPassword,
        ]);
        $loginResponse->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($created);
    }

    public function test_superadmin_can_reset_another_users_password_and_unlock_locked_account(): void
    {
        $super = $this->makeSuperAdmin();
        $lockedAdmin = User::factory()->create([
            'name' => 'Admin Terkunci',
            'email' => 'terkunci@sitiwinangun.id',
            'password' => Hash::make('Lama@12345'),
            'role' => 'admin',
            'is_active' => true,
            'failed_attempts' => 5,
            'locked_until' => now()->addMinutes(15),
        ]);

        $newPassword = 'ResetBaru@2026';

        $response = $this->actingAs($super)->put(route('admin.users.update', $lockedAdmin), [
            'name' => 'Admin Terkunci',
            'email' => 'terkunci@sitiwinangun.id',
            'role' => 'admin',
            'is_active' => '1',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $lockedAdmin->refresh();

        $this->assertTrue(Hash::check($newPassword, $lockedAdmin->password));
        $this->assertSame(0, $lockedAdmin->failed_attempts);
        $this->assertNull($lockedAdmin->locked_until);

        // Verify activity log does NOT leak password or hash
        $log = ActivityLog::where('action', 'update_user')->where('target_id', $lockedAdmin->id)->latest('id')->first();
        $this->assertNotNull($log);
        $this->assertStringNotContainsString($newPassword, (string) $log->new_value);
        $this->assertStringNotContainsString($lockedAdmin->password, (string) $log->new_value);
        $this->assertStringNotContainsString('$2y$', (string) $log->old_value);
        $this->assertStringNotContainsString('$2y$', (string) $log->new_value);

        // Verify unlocked account can login with new password
        $this->post(route('admin.logout'));
        $this->post(route('admin.login'), [
            'email' => 'terkunci@sitiwinangun.id',
            'password' => $newPassword,
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_superadmin_cannot_deactivate_demote_or_delete_self(): void
    {
        $super = $this->makeSuperAdmin();
        $this->makeSuperAdmin('super2@sitiwinangun.id');

        // Cannot demote or deactivate self via update
        $this->actingAs($super)->put(route('admin.users.update', $super), [
            'name' => $super->name,
            'email' => $super->email,
            'role' => 'admin',
            'is_active' => '0',
        ])->assertSessionHasErrors('role');

        $super->refresh();
        $this->assertSame('superadmin', $super->role);
        $this->assertTrue($super->is_active);

        // Cannot toggle self inactive
        $this->actingAs($super)->patch(route('admin.users.toggle-active', $super))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('error');

        $super->refresh();
        $this->assertTrue($super->is_active);

        // Cannot delete self
        $this->actingAs($super)->delete(route('admin.users.destroy', $super))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $super->id]);
    }

    public function test_superadmin_cannot_deactivate_demote_or_delete_last_active_superadmin(): void
    {
        $super = $this->makeSuperAdmin();

        // Only 1 active superadmin exists; create an inactive superadmin to ensure active count is checked
        $inactiveSuper = User::factory()->create([
            'name' => 'Inactive Super',
            'email' => 'inactive.super@sitiwinangun.id',
            'password' => Hash::make('Password@123'),
            'role' => 'superadmin',
            'is_active' => false,
        ]);

        // Even if trying via self, last active superadmin guard prevents deactivation
        $this->actingAs($super)->patch(route('admin.users.toggle-active', $super))
            ->assertSessionHas('error');
        $this->assertTrue($super->fresh()->is_active);

        // Inactive superadmin CAN be deleted safely because active superadmin remains
        $this->actingAs($super)->delete(route('admin.users.destroy', $inactiveSuper))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $inactiveSuper->id]);
    }

    public function test_superadmin_can_toggle_active_and_delete_other_admin(): void
    {
        $super = $this->makeSuperAdmin();
        $admin = $this->makeAdmin();

        $this->actingAs($super)->patch(route('admin.users.toggle-active', $admin))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');
        $this->assertFalse($admin->fresh()->is_active);

        $this->actingAs($super)->patch(route('admin.users.toggle-active', $admin))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');
        $this->assertTrue($admin->fresh()->is_active);

        $this->actingAs($super)->delete(route('admin.users.destroy', $admin))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $admin->id]);
    }

    public function test_regular_admin_can_update_own_profile_and_password_in_settings(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->get(route('admin.settings.index'))
            ->assertOk()
            ->assertDontSee('Aksi Penyelamatan')
            ->assertDontSee('—');

        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'name' => 'Admin Konten Baru',
            'email' => 'staff.baru@sitiwinangun.id',
            'current_password' => 'Password@123',
            'password' => 'Sandibaru@2026',
            'password_confirmation' => 'Sandibaru@2026',
        ])->assertSessionHas('success');

        $admin->refresh();
        $this->assertSame('Admin Konten Baru', $admin->name);
        $this->assertSame('staff.baru@sitiwinangun.id', $admin->email);
        $this->assertTrue(Hash::check('Sandibaru@2026', $admin->password));
    }
}
