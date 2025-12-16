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
        Schema::create('course_cohorts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('intake_year');
            $table->unsignedTinyInteger('intake_month')
                ->comment('1=Jan, 5=May, 9=Sep');

            $table->enum('status', ['active', 'completed', 'archived'])
                ->default('active');

            $table->timestamps();

            $table->unique(['course_id', 'intake_year', 'intake_month'], 'unique_course_intake');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_cohorts');
    }
};
