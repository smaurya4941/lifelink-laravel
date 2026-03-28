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
            //
            $table->string('medical_conditions')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode', 10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donor_profiles', function (Blueprint $table) {
            //
            $table->dropColumn('medical_conditions');
            $table->dropColumn('emergency_contact');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('pincode');
        });
    }
};
