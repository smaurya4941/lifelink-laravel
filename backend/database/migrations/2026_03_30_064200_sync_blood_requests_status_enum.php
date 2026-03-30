<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('blood_requests') || !Schema::hasColumn('blood_requests', 'status')) {
            return;
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("
            ALTER TABLE blood_requests
            MODIFY status ENUM('pending','matched','confirmed','in_progress','completed','cancelled')
            NOT NULL DEFAULT 'pending'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('blood_requests') || !Schema::hasColumn('blood_requests', 'status')) {
            return;
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Roll back to the previously observed legacy enum set.
        DB::statement("
            ALTER TABLE blood_requests
            MODIFY status ENUM('pending','matched','completed','cancelled')
            NOT NULL DEFAULT 'pending'
        ");
    }
};

