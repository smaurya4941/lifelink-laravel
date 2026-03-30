<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('hospitals')) {
            Schema::create('hospitals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
                $table->string('hospital_name');
                $table->string('license_number');
                $table->text('address');
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('pincode', 20)->nullable();
                $table->string('contact_phone', 20)->nullable();
                $table->decimal('latitude', 10, 7)->nullable();
                $table->decimal('longitude', 10, 7)->nullable();
                $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();
            });
        }

        // Backfill from legacy hospital_profiles if present.
        if (Schema::hasTable('hospital_profiles')) {
            $legacyRows = DB::table('hospital_profiles')->orderBy('id')->get();
            foreach ($legacyRows as $row) {
                $user = DB::table('users')->where('id', $row->user_id)->first();
                if (!$user) {
                    continue;
                }

                DB::table('hospitals')->updateOrInsert(
                    ['user_id' => $row->user_id],
                    [
                        'hospital_name' => $row->hospital_name ?? ('Hospital #' . $row->user_id),
                        'license_number' => $row->license_number ?? ('UNKNOWN-' . $row->user_id),
                        'address' => $row->address ?? ($user->address ?? 'Address not provided'),
                        'city' => $user->city ?? null,
                        'state' => $user->traditional_state ?? null,
                        'pincode' => $user->pincode ?? null,
                        'contact_phone' => $user->phone_number ?? null,
                        'latitude' => $user->latitude ?? null,
                        'longitude' => $user->longitude ?? null,
                        'verification_status' => ((int) ($row->verification_status ?? 0) === 1) ? 'verified' : 'pending',
                        'verified_at' => ((int) ($row->verification_status ?? 0) === 1) ? now() : null,
                        'created_at' => $row->created_at ?? now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        // Ensure hospital-flagged users have a hospital record.
        $hospitalUsers = DB::table('users')
            ->where(function ($query) {
                $query->where('is_hospital', true)->orWhere('role', 'hospital');
            })
            ->get();

        foreach ($hospitalUsers as $user) {
            DB::table('hospitals')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'hospital_name' => $user->name . ' Hospital',
                    'license_number' => 'PENDING-' . $user->id,
                    'address' => $user->address ?? 'Address not provided',
                    'city' => $user->city ?? null,
                    'state' => $user->traditional_state ?? null,
                    'pincode' => $user->pincode ?? null,
                    'contact_phone' => $user->phone_number ?? null,
                    'latitude' => $user->latitude ?? null,
                    'longitude' => $user->longitude ?? null,
                    'verification_status' => 'pending',
                    'verified_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};

