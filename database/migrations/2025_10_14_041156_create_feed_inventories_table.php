<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('feed_name');
            $table->string('type'); // Hay, Silage, Grain, Supplement, etc.
            $table->decimal('quantity', 10, 2)->default(0);
            $table->string('unit')->default('kg'); // kg, lbs, bags, etc.
            $table->string('location')->nullable();
            $table->enum('status', ['In Stock', 'Low Stock', 'Out of Stock'])->default('In Stock');
            $table->date('expiry_date')->nullable();
            $table->decimal('cost_per_unit', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_inventories');
    }
};