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
        Schema::create('shortcoursedata', function (Blueprint $table) {
            $table->id();
            $table->string('classno')->nullable();
            $table->string('departmentname')->nullable();
            $table->string('coursecode')->nullable();
            $table->string('coursename')->nullable();
            $table->string('venue')->nullable();
            $table->string('classname')->nullable();

            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();

            $table->string('studyactualyear')->nullable();
            $table->string('studyterm')->nullable();

            $table->string('studentid')->nullable();
            $table->string('studentsname')->nullable();
            $table->string('gender')->nullable();
            $table->string('company')->nullable();
            $table->string('certno')->nullable();
            $table->string('mobileno')->nullable();
            $table->string('nationalidno')->nullable();
            $table->string('emailaddress')->nullable();
            $table->string('county')->nullable();

            $table->string('officer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortcoursedata');
    }
};
