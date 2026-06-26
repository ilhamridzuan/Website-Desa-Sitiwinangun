<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('photo_url', 500);
            $table->text('description'); // ≤500 chars
            $table->longText('history_origin');
            $table->longText('philosophy')->nullable();
            $table->longText('technique');
            $table->text('materials')->nullable();
            $table->foreignId('artisan_id')->nullable()->constrained('artisans')->nullOnDelete();
            $table->string('location', 255)->nullable();
            $table->smallInteger('year')->nullable()->unsigned();
            $table->enum('type', ['koleksi', 'pola'])->default('koleksi');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
