<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_results', function (Blueprint $table) {

            $table->id();

            // Link to blood request
            $table->foreignId('request_id')
                  ->constrained('blood_requests')
                  ->onDelete('cascade');

            // Link to donor (user)
            $table->foreignId('donor_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // AI score (0-100)
            $table->float('match_score');

            // Distance from hospital/request location
            $table->float('distance_km')->nullable();

            // Donor response status
            $table->enum('status', [
                'notified',
                'accepted',
                'rejected',
                'expired'
            ])->default('notified');

            // When donor responded
            $table->timestamp('responded_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_results');
    }
};
