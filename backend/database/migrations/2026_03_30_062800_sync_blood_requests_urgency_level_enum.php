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
        if (!Schema::hasTable('blood_requests') || !Schema::hasColumn('blood_requests', 'urgency_level')) {
            return;
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Phase 1: allow both legacy and new enum values during transition.
        DB::statement("
            ALTER TABLE blood_requests
            MODIFY urgency_level ENUM('normal','low','medium','high','critical') NOT NULL DEFAULT 'medium'
        ");

        // Phase 2: backfill legacy value to the canonical one used by app logic.
        DB::table('blood_requests')
            ->where('urgency_level', 'normal')
            ->update(['urgency_level' => 'low']);

        // Phase 3: enforce the final canonical enum.
        DB::statement("
            ALTER TABLE blood_requests
            MODIFY urgency_level ENUM('low','medium','high','critical') NOT NULL DEFAULT 'medium'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('blood_requests') || !Schema::hasColumn('blood_requests', 'urgency_level')) {
            return;
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Revert to legacy enum values.
        DB::statement("
            ALTER TABLE blood_requests
            MODIFY urgency_level ENUM('normal','medium','critical') NOT NULL DEFAULT 'normal'
        ");

        DB::table('blood_requests')
            ->where('urgency_level', 'low')
            ->update(['urgency_level' => 'normal']);
    }
};

