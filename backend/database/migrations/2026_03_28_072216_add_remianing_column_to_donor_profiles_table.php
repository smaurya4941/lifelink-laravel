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
        Schema::table('donor_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('donor_profiles', 'medical_conditions')) {
                $table->string('medical_conditions')->nullable();
            }

            if (!Schema::hasColumn('donor_profiles', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable();
            }

            if (!Schema::hasColumn('donor_profiles', 'address')) {
                $table->text('address')->nullable();
            }

            if (!Schema::hasColumn('donor_profiles', 'city')) {
                $table->string('city')->nullable();
            }

            if (!Schema::hasColumn('donor_profiles', 'state')) {
                $table->string('state')->nullable();
            }

            if (!Schema::hasColumn('donor_profiles', 'pincode')) {
                $table->string('pincode', 10)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donor_profiles', function (Blueprint $table) {
            $columns = [
                'medical_conditions',
                'emergency_contact',
                'address',
                'city',
                'state',
                'pincode',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('donor_profiles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
