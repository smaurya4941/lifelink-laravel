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
        Schema::create('donor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('blood_group', [
                'A+',
                'A-',
                'B+',
                'B-',
                'AB+',
                'AB-',
                'O+',
                'O-'
            ]);

            $table->integer('age')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->string('emergency_contact')->nullable();

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->date('last_donation_date')->nullable();
            $table->boolean('availability_status')->default(true);
            $table->float('matching_score')->default(0.0);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_live_location_enabled')->default(false);
            $table->decimal('current_latitude', 10, 7)->nullable();
            $table->decimal('current_longitude', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donor_profiles');
    }
};
