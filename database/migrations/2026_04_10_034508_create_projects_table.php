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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code');
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('status', [
                'completed', 'on_progress', 'archived', 'pending', 'cancelled', 'failed', 'draft',
            ])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->dateTime('start_date');
            $table->decimal('budget_amount', 12, 2); // up to billions
            $table->decimal('actual_cost', 12, 2);
            $table->boolean('requires_approval')->default(true);
            $table->enum('approved_status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->dateTime('approved_at')->nullable();
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
