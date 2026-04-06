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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('avatar')->nullable();
            $table->string('firstname',100);
            $table->string('lastname',100);
            $table->string('extension',10)->nullable();
            $table->enum('gender',['male','female'])->default('male');
            $table->string('phone',11);
            $table->dateTime('last_seen')->nullable();
            $table->boolean('is_supervisor')->default(false);
            $table->decimal('salary', 10, 2)->default(0.00);
            $table->enum('type',['fulltime','parttime','intern'])->default('parttime');
            $table->dateTime('hire_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
