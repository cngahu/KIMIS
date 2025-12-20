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
        Schema::create('student_cycle_registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();

            $table->foreignId('course_stage_id')->constrained('course_stages');

            // Cycle identity
            $table->year('cycle_year');
            $table->enum('cycle_term', ['Jan', 'May', 'Sep']);

            // Registration lifecycle
            $table->enum('status', ['pending_payment', 'confirmed', 'withdrawn'])
                ->default('pending_payment');

            $table->timestamp('registered_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();

            // Billing
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();

            $table->unique([
                'student_id',
                'cycle_year',
                'cycle_term'
            ], 'unique_student_cycle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_cycle_registrations');
    }
};
