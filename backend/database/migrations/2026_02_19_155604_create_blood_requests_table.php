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

            // Patient info
            $table->string('patient_name')->nullable();

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
            $table->string('hospital_address')->nullable();

            $table->string('city');
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();

            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();

            // GPS coordinates for map feature
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Search radius for nearby donors
            $table->integer('radius_km')->default(10);

            // Urgency classification
            $table->enum('urgency_level', [
                'critical',
                'high',
                'medium',
                'low'
            ])->default('medium');

            // Request lifecycle status
            $table->enum('status', [
                'pending',
                'matched',
                'confirmed',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('pending');

            // Required date
            $table->date('required_date')->nullable();

            // Extra notes
            $table->text('notes')->nullable();
            $table->text('description')->nullable();

            // Confirmation workflow
            $table->foreignId('confirmed_donor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmation_date')->nullable();
            $table->text('confirmation_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
