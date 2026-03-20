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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            // Link to match result
            $table->foreignId('match_result_id')
                ->constrained('match_results')
                ->onDelete('cascade');
            // Donor
            $table->foreignId('donor_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Recipient
            $table->foreignId('recipient_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Hospital
            $table->foreignId('hospital_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->integer('units_donated')->default(1);

            $table->date('donation_date');

            $table->enum('status', [
                'completed',
                'failed'
            ])->default('completed');
            $table->boolean('is_successful')->default(true);

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
