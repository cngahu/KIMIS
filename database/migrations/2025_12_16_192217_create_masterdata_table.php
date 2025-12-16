<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('masterdata', function (Blueprint $table) {
            $table->id();

            $table->string('admissionNo', 255)->nullable();
            $table->string('full_name', 255)->nullable();

            $table->string('campus', 255)->nullable();
            $table->unsignedBigInteger('campus_id')->nullable();

            $table->string('department', 255)->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            $table->string('course_name', 255)->nullable();
            $table->string('course_code', 5)->nullable();
            $table->unsignedBigInteger('course_id')->nullable();

            $table->string('current', 5)->nullable();
            $table->string('intake', 255)->nullable();

            $table->decimal('balance', 14, 2)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('idno', 50)->nullable();

            $table->timestamps();

            // Optional (later): indexes you might want
            $table->index('admissionNo');
            $table->index('campus_id');
            $table->index('department_id');
            $table->index('course_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masterdata');
    }
};
