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
            $table->integer('userid');
            $table->string('academiclevel');
            $table->date('startDate');
            $table->date('exitDate');
            $table->string('institutionName');
            $table->string('grade');
            $table->string('certificate');
            $table->date('entryDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educationqualifications', function (Blueprint $table) {
            //
        });
    }
};
