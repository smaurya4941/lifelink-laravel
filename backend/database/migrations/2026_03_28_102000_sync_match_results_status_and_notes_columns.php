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
            if (!Schema::hasColumn('match_results', 'status')) {
                $table->enum('status', ['pending', 'accepted', 'rejected', 'completed'])->default('pending');
            }

            if (!Schema::hasColumn('match_results', 'responded_at')) {
                $table->timestamp('responded_at')->nullable();
            }

            if (!Schema::hasColumn('match_results', 'notes')) {
                $table->text('notes')->nullable();
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
            if (Schema::hasColumn('match_results', 'notes')) {
                $table->dropColumn('notes');
            }

            if (Schema::hasColumn('match_results', 'responded_at')) {
                $table->dropColumn('responded_at');
            }

            if (Schema::hasColumn('match_results', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
