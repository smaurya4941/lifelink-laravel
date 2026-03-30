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
        if (!Schema::hasTable('blood_requests')) {
            return;
        }

        Schema::table('blood_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('blood_requests', 'confirmed_donor_id')) {
                $table->foreignId('confirmed_donor_id')
                    ->nullable()
                    ->after('status')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('blood_requests', 'confirmation_date')) {
                $table->timestamp('confirmation_date')->nullable()->after('confirmed_donor_id');
            }

            if (!Schema::hasColumn('blood_requests', 'confirmation_notes')) {
                $table->text('confirmation_notes')->nullable()->after('confirmation_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('blood_requests')) {
            return;
        }

        Schema::table('blood_requests', function (Blueprint $table) {
            if (Schema::hasColumn('blood_requests', 'confirmed_donor_id')) {
                $table->dropConstrainedForeignId('confirmed_donor_id');
            }

            if (Schema::hasColumn('blood_requests', 'confirmation_date')) {
                $table->dropColumn('confirmation_date');
            }

            if (Schema::hasColumn('blood_requests', 'confirmation_notes')) {
                $table->dropColumn('confirmation_notes');
            }
        });
    }
};

