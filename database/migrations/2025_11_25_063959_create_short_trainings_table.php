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
        Schema::create('short_trainings', function (Blueprint $table) {
            $table->id();
       // Which training/intake this row belongs to
            $table->foreignId('training_id')
                ->constrained()
                ->cascadeOnDelete();

            // Who pays
            $table->enum('financier', ['self', 'employer']);

            // If employer – just name
            $table->string('employer_name')->nullable();

            // Applicant info (one row per applicant)
            $table->string('full_name');
            $table->string('id_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Uploaded national ID
            $table->string('national_id_path')->nullable();
            $table->string('national_id_original_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_trainings');
    }
};
