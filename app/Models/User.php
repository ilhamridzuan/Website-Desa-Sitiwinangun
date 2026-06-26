<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'is_active', 'last_login_at', 'failed_attempts', 'locked_until'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if the account is locked.
     */
    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Increment failed login attempts and lock if threshold is reached.
     */
    public function incrementFailedAttempts(): void
    {
        $this->increment('failed_attempts');

        if ($this->failed_attempts >= 5) {
            $this->update([
                'locked_until' => now()->addMinutes(15),
            ]);
        }
    }

    /**
     * Reset failed login attempts and unlock the account.
     */
    public function resetFailedAttempts(): void
    {
        $this->update([
            'failed_attempts' => 0,
            'locked_until' => null,
        ]);
    }
}
