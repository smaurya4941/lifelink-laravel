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
        Schema::create('recipient_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->text('medical_condition')->nullable();

            $table->string('emergency_contact');
            $table->enum('blood_group', [
                'A+','A-','B+','B-','AB+','AB-','O+','O-'
            ]);

            $table->integer('age')->nullable();
            $table->integer('weight')->nullable();

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipient_profiles');
    }
};
