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
        Schema::create('cohort_stage_timelines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_cohort_id')
                ->constrained('course_cohorts')
                ->cascadeOnDelete();

            $table->foreignId('course_stage_id')
                ->constrained('course_stages')
                ->restrictOnDelete();

            $table->unsignedInteger('sequence_number')
                ->comment('Order of stage within the cohort');

            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();

            $table->unique(
                ['course_cohort_id', 'sequence_number'],
                'unique_stage_sequence_per_cohort'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cohort_stage_timelines');
    }
};
