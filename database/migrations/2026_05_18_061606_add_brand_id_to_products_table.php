<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'brand_id')) {
                $table->dropColumn('brand_id');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignUuid('brand_id')
                ->nullable()
                ->constrained('product_brands')
                ->restrictOnDelete();

            $table->unique(['brand_id', 'sku']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropUnique(['brand_id', 'sku']);

            $table->dropForeign(['brand_id']);

            $table->dropColumn('brand_id');
        });
    }
};
