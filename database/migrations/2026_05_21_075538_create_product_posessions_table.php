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
        Schema::create('product_posessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('original_owner')->constrained('users')->restrictOnDelete();
            $table->foreignId('current_owner')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');
            $table->date('release_date');
            $table->date('transferred_date')->nullable();
            $table->date('returned_date')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_posessions');
    }
};
