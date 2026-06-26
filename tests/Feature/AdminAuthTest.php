<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('login_attempt:127.0.0.1');
    }

    /**
     * Test unauthenticated redirection.
     */
    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test successful login.
     */
    public function test_active_admin_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@sitiwinangun.id',
            'password' => Hash::make('Sitiwinangun@2025'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'admin@sitiwinangun.id',
            'password' => 'Sitiwinangun@2025',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);

        $user->refresh();
        $this->assertNotNull($user->last_login_at);
        $this->assertEquals(0, $user->failed_attempts);
    }

    /**
     * Test account locking after 5 failed attempts.
     */
    public function test_account_is_locked_after_five_failed_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@sitiwinangun.id',
            'password' => Hash::make('Sitiwinangun@2025'),
            'role' => 'admin',
            'is_active' => true,
            'failed_attempts' => 0,
        ]);

        // Attempt 5 incorrect logins
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post(route('admin.login'), [
                'email' => 'admin@sitiwinangun.id',
                'password' => 'wrongpassword',
            ]);
        }

        $user->refresh();
        $this->assertTrue($user->isLocked());
        $this->assertNotNull($user->locked_until);

        // Next login attempt should block with lock message even with correct password
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@sitiwinangun.id',
            'password' => 'Sitiwinangun@2025',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test inactive admin cannot login.
     */
    public function test_inactive_admin_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@sitiwinangun.id',
            'password' => Hash::make('Sitiwinangun@2025'),
            'role' => 'admin',
            'is_active' => false,
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'admin@sitiwinangun.id',
            'password' => 'Sitiwinangun@2025',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test logout.
     */
    public function test_admin_can_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@sitiwinangun.id',
            'password' => Hash::make('Sitiwinangun@2025'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
