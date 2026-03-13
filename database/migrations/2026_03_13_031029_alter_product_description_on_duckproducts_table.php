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
        Schema::table('duckproducts', function (Blueprint $table) {
            $table->text('product_description')->change();
        });
    }

    public function down(): void
    {
        Schema::table('duckproducts', function (Blueprint $table) {
            $table->string('product_description', 255)->change();
        });
    }
};
