<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VirtualTour extends Model
{
    use HasFactory;

    protected $table = 'virtual_tour';

    protected $fillable = [
        'title',
        'description',
        'embed_type',
        'embed_code',
        'sanitized_code',
        'is_active',
        'version_history',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'version_history' => 'array',
    ];

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Add a version to version history (keep max 5 versions).
     */
    public function addVersionHistory(string $code, ?int $userId): void
    {
        $history = $this->version_history ?? [];
        
        $newVersion = [
            'version' => count($history) + 1,
            'code_hash' => md5($code),
            'embed_code' => $code,
            'updated_by' => $userId,
            'updated_at' => now()->toDateTimeString(),
        ];

        array_unshift($history, $newVersion);
        
        // Keep only top 5
        $this->version_history = array_slice($history, 0, 5);
    }
}
