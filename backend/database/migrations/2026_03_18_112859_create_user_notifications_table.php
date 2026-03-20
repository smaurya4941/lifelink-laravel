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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('notification_type');
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->foreignId('related_request_id')->nullable()->constrained('blood_requests')->nullOnDelete();
            $table->foreignId('related_match_id')->nullable()->constrained('match_results')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
