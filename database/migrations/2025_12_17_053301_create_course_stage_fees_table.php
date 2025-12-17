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
        Schema::create('course_stage_fees', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->foreignId('course_stage_id')
                ->constrained('course_stages')
                ->cascadeOnDelete();

            $table->decimal('amount', 12, 2)
                ->default(0.00);

            $table->boolean('is_billable')
                ->default(true);

            // Effective dating (fee history)
            $table->date('effective_from');
            $table->date('effective_to')->nullable();

            $table->timestamps();

            // Indexes for fast lookups
            $table->index(['course_id', 'course_stage_id']);
            $table->index(['effective_from', 'effective_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_stage_fees');
    }
};
