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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('campus_id'); // from course->college_id

            $table->year('year'); // year of admission e.g. 2025
            $table->string('cohort')->nullable(); // optional e.g. Jan 2025 Intake
            $table->string('semester')->nullable(); // if applicable later

            $table->enum('status', [
                'active',
                'completed',
                'deferred',
                'withdrawn'
            ])->default('active');

            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
