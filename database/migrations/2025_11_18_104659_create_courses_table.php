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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');

            $table->enum('course_category', [
                'Diploma',
                'Craft',
                'Higher Diploma',
                'Proficiency'
            ]);

            $table->string('course_code')->unique();

            $table->enum('course_mode', [
                'Long Term',
                'Short Term'
            ]);


            $table->integer('course_duration')->comment('Duration in months');
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
