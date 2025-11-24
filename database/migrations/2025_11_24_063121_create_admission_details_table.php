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
        Schema::create('admission_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admission_id');
            $table->unsignedBigInteger('student_id');

            // Parent/Guardian
            $table->string('parent_name')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('parent_id_number')->nullable();
            $table->string('parent_relationship')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('parent_occupation')->nullable();

            // Next of Kin
            $table->string('nok_name')->nullable();
            $table->string('nok_phone')->nullable();
            $table->string('nok_relationship')->nullable();
            $table->string('nok_address')->nullable();

            // Personal
            $table->string('religion')->nullable();
            $table->string('disability_status')->nullable();
            $table->string('chronic_illness')->nullable();
            $table->string('allergies')->nullable();

            // Education
            $table->string('education_school')->nullable();
            $table->string('education_year')->nullable();
            $table->string('education_index_number')->nullable();

            // Emergency
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();

            // Declaration
            $table->boolean('declaration')->default(0);
            $table->timestamp('form_completed_at')->nullable();

            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->cascadeOnDelete();
            $table->foreign('student_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_details');
    }
};
