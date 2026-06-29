<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorytellingChapter extends Model
{
    protected $fillable = [
        'chapter_key',
        'title',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    /**
     * Find a chapter by its unique key.
     */
    public static function findByKey(string $key)
    {
        return self::where('chapter_key', $key)->first();
    }
}
