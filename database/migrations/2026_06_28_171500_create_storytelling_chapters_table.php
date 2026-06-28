<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('storytelling_chapters', function (Blueprint $table) {
            $table->id();
            $table->string('chapter_key', 50)->unique(); // e.g. 'bab_2', 'bab_3', 'bab_4', 'bab_5'
            $table->string('title', 255);
            $table->json('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('storytelling_chapters');
    }
};
