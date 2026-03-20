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
        if (!Schema::hasTable('recipient_profiles')) {
            return;
        }

        Schema::table('recipient_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('recipient_profiles', 'address')) {
                $table->string('address')->nullable()->after('weight');
            }

            if (!Schema::hasColumn('recipient_profiles', 'city')) {
                $table->string('city')->nullable()->after('address');
            }

            if (!Schema::hasColumn('recipient_profiles', 'state')) {
                $table->string('state')->nullable()->after('city');
            }

            if (!Schema::hasColumn('recipient_profiles', 'pincode')) {
                $table->string('pincode')->nullable()->after('state');
            }

            if (!Schema::hasColumn('recipient_profiles', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('pincode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('recipient_profiles')) {
            return;
        }

        Schema::table('recipient_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('recipient_profiles', 'is_verified')) {
                $table->dropColumn('is_verified');
            }
            if (Schema::hasColumn('recipient_profiles', 'pincode')) {
                $table->dropColumn('pincode');
            }
            if (Schema::hasColumn('recipient_profiles', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('recipient_profiles', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('recipient_profiles', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};
