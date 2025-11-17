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
        Schema::table('educationqualifications', function (Blueprint $table) {
            //
            $table->string('institution_contact')->nullable();
            $table->string('course_name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educationqualifications', function (Blueprint $table) {
            //
            $table->dropColumn('institution_contact');
            $table->dropColumn('course_name');
        });
    }
};
