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
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_hospital')) {
                $table->boolean('is_hospital')->default(false)->after('is_recipient');
            }
        });

        if (Schema::hasColumn('users', 'role') && Schema::hasColumn('users', 'is_hospital')) {
            DB::table('users')->where('role', 'hospital')->update(['is_hospital' => true]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_hospital')) {
                $table->dropColumn('is_hospital');
            }
        });
    }
};
