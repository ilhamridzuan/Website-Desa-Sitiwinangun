<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPage extends Model
{
    use HasFactory;

    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'page_key',
        'title',
        'content',
    ];

    public static function findByKey(string $key): ?self
    {
        return static::where('page_key', $key)->first();
    }
}
