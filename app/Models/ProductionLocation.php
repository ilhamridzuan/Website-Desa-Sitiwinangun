<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'phone',
        'main_products',
        'visit_capacity',
        'edu_activities',
        'is_open_visit',
        'photo_url',
    ];

    protected $casts = [
        'is_open_visit' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function artisan(): BelongsTo
    {
        return $this->belongsTo(Artisan::class);
    }
}
