<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feed_histories', function (Blueprint $table) {
            $table->foreignId('feed_inventory_id')
                ->nullable()
                ->after('is_manual')
                ->constrained('feed_inventories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('feed_histories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('feed_inventory_id');
        });
    }
};
