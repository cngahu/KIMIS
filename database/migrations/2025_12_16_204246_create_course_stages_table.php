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
        Schema::create('course_stages', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            // Examples: 1.1, 1.2, VACATION, ATTACHMENT, INTERNSHIP

            $table->string('name');
            // Human readable: Year 1 Term 1, Vacation, Attachment

            $table->enum('stage_type', [
                'academic',
                'vacation',
                'attachment',
                'internship'
            ]);

            $table->boolean('is_billable')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_stages');
    }
};
