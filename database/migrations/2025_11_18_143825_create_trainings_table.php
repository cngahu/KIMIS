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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            // Foreign keys
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');

            $table->foreignId('college_id')->constrained('colleges')->onDelete('cascade');

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('status')->nullable();
            $table->decimal('cost', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
