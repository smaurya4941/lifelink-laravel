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
            if (!Schema::hasColumn('users', 'is_donor')) {
                $table->boolean('is_donor')->default(false)->after('role');
            }

            if (!Schema::hasColumn('users', 'is_recipient')) {
                $table->boolean('is_recipient')->default(false)->after('is_donor');
            }

            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('is_recipient');
            }

            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('phone_number');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('date_of_birth');
            }

            if (!Schema::hasColumn('users', 'traditional_state')) {
                $table->string('traditional_state')->nullable()->after('city');
            }

            if (!Schema::hasColumn('users', 'pincode')) {
                $table->string('pincode')->nullable()->after('traditional_state');
            }

            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->default('India')->after('pincode');
            }
        });

        // Keep role enum aligned with current application roles on MySQL.
        if (Schema::hasColumn('users', 'role') && DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('donor','recipient','hospital','admin') DEFAULT 'recipient'");
        }

        // Backfill new boolean flags from existing role values.
        if (Schema::hasColumn('users', 'is_donor') && Schema::hasColumn('users', 'role')) {
            DB::table('users')->where('role', 'donor')->update(['is_donor' => true]);
        }

        if (Schema::hasColumn('users', 'is_recipient') && Schema::hasColumn('users', 'role')) {
            DB::table('users')->where('role', 'recipient')->update(['is_recipient' => true]);
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
            if (Schema::hasColumn('users', 'country')) {
                $table->dropColumn('country');
            }
            if (Schema::hasColumn('users', 'pincode')) {
                $table->dropColumn('pincode');
            }
            if (Schema::hasColumn('users', 'traditional_state')) {
                $table->dropColumn('traditional_state');
            }
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('users', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }
            if (Schema::hasColumn('users', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
            if (Schema::hasColumn('users', 'is_recipient')) {
                $table->dropColumn('is_recipient');
            }
            if (Schema::hasColumn('users', 'is_donor')) {
                $table->dropColumn('is_donor');
            }
        });
    }
};
