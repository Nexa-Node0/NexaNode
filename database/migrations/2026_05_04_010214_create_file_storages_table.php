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
        Schema::create('file_storages', function (Blueprint $table) {
            $table->id();

            // polymorphic relation
            $table->morphs('fileable');

            // storage
            $table->string('disk')->default('public');
            $table->string('path');

                                                // file metadata
            $table->string('type')->nullable(); // thumbnail, attachment, etc.
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();

            // optional metadata
            $table->string('title')->nullable();
            $table->string('description')->nullable();

            // control
            $table->string('visibility')->default('public');
            $table->integer('order_column')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_storages');
    }
};
