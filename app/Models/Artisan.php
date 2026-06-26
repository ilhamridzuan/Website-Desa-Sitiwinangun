<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artisan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo_url',
        'years_active',
        'specialty',
        'story',
        'quote',
        'address',
        'phone',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }

    public function productionLocations(): HasMany
    {
        return $this->hasMany(ProductionLocation::class);
    }
}
