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
        Schema::table('contactforms', function (Blueprint $table) {
            if (!Schema::hasColumn('contactforms', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('message');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contactforms', function (Blueprint $table) {
            if (Schema::hasColumn('contactforms', 'replied_at')) {
                $table->dropColumn('replied_at');
            }
        });
    }
};

