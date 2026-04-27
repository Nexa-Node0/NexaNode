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
            $table->string('slug');
            $table->string('code');
            $table->text('description');
            $table->string('status');
            $table->string('priority');
            $table->dateTime('start_date');
            $table->decimal('budget_amount', 12, 2); // up to billions
            $table->decimal('actual_cost', 12, 2);
            $table->boolean('requires_approval')->default(true);
            $table->string('approved_status');
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
