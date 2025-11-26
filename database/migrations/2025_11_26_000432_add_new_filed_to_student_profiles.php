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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->unique(); // instead of admission_id!

            // BIO DETAILS (from application)
            $table->string('id_number')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();

            // CONTACT & ADDRESS
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('town')->nullable();
            $table->unsignedBigInteger('home_county_id')->nullable();
            $table->unsignedBigInteger('current_county_id')->nullable();

            // GUARDIAN / SPONSOR
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_relationship')->nullable();

            // NEXT OF KIN
            $table->string('nok_name')->nullable();
            $table->string('nok_phone')->nullable();
            $table->string('nok_relationship')->nullable();

            // MEDICAL
            $table->string('disability')->nullable();
            $table->string('chronic_illness')->nullable();
            $table->string('allergies')->nullable();

            // ACADEMIC BACKGROUND
            $table->string('kcse_mean_grade')->nullable();
            $table->string('school_attended')->nullable();
            $table->string('year_completed')->nullable();

            // FLEXIBLE STORAGE FOR ANY FUTURE FIELDS
            $table->json('extra_data')->nullable();

            $table->timestamps();

            // Relations
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
