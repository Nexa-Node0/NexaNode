<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_headline')->default(false);
            $table->json('tags')->nullable();
            $table->enum('status', ["Published", "Unpublished", "Draft"])->default("Published");
            $table->datetime('published_date')->default(now());
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('post_category_id')->constrained('post_categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
