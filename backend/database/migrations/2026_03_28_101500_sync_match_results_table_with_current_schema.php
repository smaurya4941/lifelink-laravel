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
        if (!Schema::hasTable('match_results')) {
            return;
        }

        Schema::table('match_results', function (Blueprint $table) {
            if (!Schema::hasColumn('match_results', 'success_probability')) {
                $table->float('success_probability')->nullable();
            }

            if (!Schema::hasColumn('match_results', 'health_risk')) {
                $table->float('health_risk')->nullable();
            }

            if (!Schema::hasColumn('match_results', 'scores_breakdown')) {
                $table->json('scores_breakdown')->nullable();
            }

            if (!Schema::hasColumn('match_results', 'distance_km')) {
                $table->float('distance_km')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('match_results')) {
            return;
        }

        Schema::table('match_results', function (Blueprint $table) {
            if (Schema::hasColumn('match_results', 'distance_km')) {
                $table->dropColumn('distance_km');
            }

            if (Schema::hasColumn('match_results', 'scores_breakdown')) {
                $table->dropColumn('scores_breakdown');
            }

            if (Schema::hasColumn('match_results', 'health_risk')) {
                $table->dropColumn('health_risk');
            }

            if (Schema::hasColumn('match_results', 'success_probability')) {
                $table->dropColumn('success_probability');
            }
        });
    }
};
