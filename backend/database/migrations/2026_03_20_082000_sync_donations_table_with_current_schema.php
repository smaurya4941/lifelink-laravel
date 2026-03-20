<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('donations')) {
            return;
        }

        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'is_successful')) {
                $table->boolean('is_successful')->default(true)->after('status');
            }
        });

        // Backfill success flag from existing status values when available.
        if (Schema::hasColumn('donations', 'status') && Schema::hasColumn('donations', 'is_successful')) {
            DB::table('donations')->where('status', 'completed')->update(['is_successful' => true]);
            DB::table('donations')->where('status', 'failed')->update(['is_successful' => false]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('donations')) {
            return;
        }

        Schema::table('donations', function (Blueprint $table) {
            if (Schema::hasColumn('donations', 'is_successful')) {
                $table->dropColumn('is_successful');
            }
        });
    }
};
