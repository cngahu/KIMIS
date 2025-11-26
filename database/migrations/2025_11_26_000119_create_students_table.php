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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // tied to login account
            $table->unsignedBigInteger('admission_id')->unique(); // tied to admission workflow

            $table->string('student_number')->unique(); // e.g. KIHBT/2025/01234

            $table->unsignedBigInteger('course_id'); // program
            $table->unsignedBigInteger('campus_id'); // derived from course->college_id

            $table->date('admitted_at')->nullable();
            $table->enum('status', [
                'active',
                'deferred',
                'completed',
                'terminated',
                'suspended',
                'graduated'
            ])->default('active');

            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admission_id')->references('id')->on('admissions')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
