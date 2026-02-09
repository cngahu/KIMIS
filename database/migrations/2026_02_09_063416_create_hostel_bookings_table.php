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
        Schema::create('hostel_bookings', function (Blueprint $table) {
            $table->id();

            // Reference
            $table->string('reference')->unique();

            // Applicant details
            $table->string('full_name');
            $table->string('id_number', 50);
            $table->string('email');
            $table->string('phone');

            // Course context (MUST be nullable for SET NULL)
            $table->foreignId('course_id')
                ->nullable()
                ->constrained('courses')
                ->nullOnDelete();

            $table->foreignId('college_id')
                ->nullable()
                ->constrained('colleges')
                ->nullOnDelete();

            // Boarding
            $table->enum('boarding_type', ['half', 'full']);

            // Status
            $table->enum('status', [
                'pending_payment',
                'paid',
                'cancelled'
            ])->default('pending_payment');

            $table->enum('payment_status', [
                'pending',
                'paid'
            ])->default('pending');

            // Metadata
            $table->json('metadata')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostel_bookings');
    }
};
