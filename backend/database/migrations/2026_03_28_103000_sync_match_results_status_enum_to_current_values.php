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
        if (!Schema::hasTable('match_results') || !Schema::hasColumn('match_results', 'status')) {
            return;
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Map legacy values to the current application lifecycle values.
        DB::table('match_results')->where('status', 'notified')->update(['status' => 'pending']);
        DB::table('match_results')->where('status', 'expired')->update(['status' => 'rejected']);

        DB::statement("ALTER TABLE match_results MODIFY status ENUM('pending','accepted','rejected','completed') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('match_results') || !Schema::hasColumn('match_results', 'status')) {
            return;
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Map back to legacy values where possible.
        DB::table('match_results')->where('status', 'pending')->update(['status' => 'notified']);
        DB::table('match_results')->where('status', 'completed')->update(['status' => 'accepted']);

        DB::statement("ALTER TABLE match_results MODIFY status ENUM('notified','accepted','rejected','expired') NOT NULL DEFAULT 'notified'");
    }
};
