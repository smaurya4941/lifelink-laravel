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
        Schema::table('blood_requests', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('blood_requests', 'blood_group')) {
                $table->string('blood_group', 5)->after('id');
            }

            if (!Schema::hasColumn('blood_requests', 'units_required')) {
                $table->unsignedInteger('units_required');
            }

            if (!Schema::hasColumn('blood_requests', 'patient_name')) {
                $table->string('patient_name');
            }

            if (!Schema::hasColumn('blood_requests', 'hospital_name')) {
                $table->string('hospital_name');
            }

            if (!Schema::hasColumn('blood_requests', 'hospital_address')) {
                $table->text('hospital_address');
            }

            if (!Schema::hasColumn('blood_requests', 'city')) {
                $table->string('city');
            }

            if (!Schema::hasColumn('blood_requests', 'state')) {
                $table->string('state');
            }

            if (!Schema::hasColumn('blood_requests', 'pincode')) {
                $table->string('pincode', 10);
            }

            if (!Schema::hasColumn('blood_requests', 'contact_person')) {
                $table->string('contact_person');
            }

            if (!Schema::hasColumn('blood_requests', 'contact_phone')) {
                $table->string('contact_phone', 15);
            }

            if (!Schema::hasColumn('blood_requests', 'urgency_level')) {
                $table->enum('urgency_level', ['low', 'medium', 'high', 'critical'])->default('medium');
            }

            if (!Schema::hasColumn('blood_requests', 'required_date')) {
                $table->date('required_date')->nullable();
            }

            if (!Schema::hasColumn('blood_requests', 'notes')) {
                $table->text('notes')->nullable();
            }

            if (!Schema::hasColumn('blood_requests', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('blood_requests', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable();
            }

            if (!Schema::hasColumn('blood_requests', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable();
            }

            if (!Schema::hasColumn('blood_requests', 'radius_km')) {
                $table->integer('radius_km')->default(5);
            }

            if (!Schema::hasColumn('blood_requests', 'requester_id')) {
                $table->foreignId('requester_id')
                      ->constrained('users')
                      ->cascadeOnDelete();
            }

            // timestamps check (special case)
            if (!Schema::hasColumn('blood_requests', 'created_at') &&
                !Schema::hasColumn('blood_requests', 'updated_at')) {
                $table->timestamps();
            }
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            //
        });
    }
};
