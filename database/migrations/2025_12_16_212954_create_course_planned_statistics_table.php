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
        Schema::create('course_planned_statistics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_cohort_id')
                ->constrained('course_cohorts')
                ->cascadeOnDelete();

            $table->unsignedInteger('planned_male')->default(0);
            $table->unsignedInteger('planned_female')->default(0);

            $table->string('source')
                ->default('Planning / Gantt');

            $table->timestamps();

            $table->unique(
                ['course_cohort_id'],
                'unique_planned_stats_per_cohort'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_planned_statistics');
    }
};
