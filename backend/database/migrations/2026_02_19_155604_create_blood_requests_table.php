<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_requests', function (Blueprint $table) {

            $table->id();

            // Who created the request (recipient or hospital)
            $table->foreignId('requester_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Blood requirement
            $table->enum('blood_group', [
                'A+','A-','B+','B-','AB+','AB-','O+','O-'
            ]);

            $table->integer('units_required')->default(1);

            // Hospital details
            $table->string('hospital_name');

            $table->string('city');

            // GPS coordinates for map feature
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Search radius for nearby donors
            $table->integer('radius_km')->default(10);

            // Urgency classification
            $table->enum('urgency_level', [
                'normal',
                'medium',
                'critical'
            ])->default('normal');

            // Request lifecycle status
            $table->enum('status', [
                'pending',
                'matched',
                'completed',
                'cancelled'
            ])->default('pending');

            // Required date
            $table->date('required_date')->nullable();

            // Extra notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};

