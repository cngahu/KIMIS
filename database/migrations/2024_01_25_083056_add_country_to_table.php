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
            $table->unsignedBigInteger('country');
            $table->foreign('country')->references('id')->on('countries');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educationqualifications', function (Blueprint $table) {
            //
            $table->dropColumn('country');
        });
    }
};
