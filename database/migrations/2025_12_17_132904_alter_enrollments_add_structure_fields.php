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
        Schema::table('enrollments', function (Blueprint $table) {

            // Canonical cohort
            $table->foreignId('course_cohort_id')
                ->nullable()
                ->after('course_id')
                ->constrained('course_cohorts')
                ->nullOnDelete();

            // Current stage
            $table->foreignId('course_stage_id')
                ->nullable()
                ->after('course_cohort_id')
                ->constrained('course_stages')
                ->nullOnDelete();

            // Enrollment origin
            $table->string('source')
                ->nullable()
                ->after('semester')
                ->comment('legacy, system, activation');

            // Activation timestamp
            $table->timestamp('activated_at')
                ->nullable()
                ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {

            $table->dropForeign(['course_cohort_id']);
            $table->dropForeign(['course_stage_id']);

            $table->dropColumn([
                'course_cohort_id',
                'course_stage_id',
                'source',
                'activated_at',
            ]);
        });
    }
};
