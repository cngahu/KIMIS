<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Alternative course 1 (nullable)
            $table->foreignId('alt_course_1_id')
                ->nullable()
                ->constrained('courses')
                ->nullOnDelete();

            // Alternative course 2 (nullable)
            $table->foreignId('alt_course_2_id')
                ->nullable()
                ->constrained('courses')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Drop foreign key constraints first, then columns
            $table->dropForeign(['alt_course_1_id']);
            $table->dropForeign(['alt_course_2_id']);

            $table->dropColumn(['alt_course_1_id', 'alt_course_2_id']);
        });
    }
};


