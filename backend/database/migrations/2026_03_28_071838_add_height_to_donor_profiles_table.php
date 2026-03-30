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
        if (!Schema::hasColumn('donor_profiles', 'height')) {
            Schema::table('donor_profiles', function (Blueprint $table) {
                $table->integer('height')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('donor_profiles', 'height')) {
            Schema::table('donor_profiles', function (Blueprint $table) {
                $table->dropColumn('height');
            });
        }
    }
};
