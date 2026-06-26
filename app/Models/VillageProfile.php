<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    use HasFactory;

    protected $table = 'village_profile';

    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'gallery_photos',
    ];

    protected $casts = [
        'gallery_photos' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
