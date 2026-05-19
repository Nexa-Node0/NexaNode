<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PositionEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->unsignedTinyInteger('level')->default(1);
            $table->string('type')->default(PositionEnum::FullTime->value); // enum
            $table->foreignId('department_id')->constrained()->nullOnDelete();
            $table->foreignId('reports_to')->nullable()->constrained('positions')->nullOnDelete();
            $table->unsignedInteger('max_headcount')->nullable();
            $table->boolean('is_active')->default('true');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
