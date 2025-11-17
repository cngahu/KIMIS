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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('firstname')->after('surname');
            $table->string('othername')->after('firstname')->nullable();
            $table->unsignedBigInteger('title_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->date('dob')->nullable();
            $table->unsignedBigInteger('nationality');
            $table->unsignedBigInteger('county');
            $table->integer('code')->after('address')->nullable();
            $table->string('city')->after('code')->nullable();
            $table->string('physical_address')->after('code')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('next_of_kin_contact')->nullable();
            $table->foreign('title_id')->references('id')->on('titles');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('nationality')->references('id')->on('countries');
            $table->foreign('county')->references('id')->on('counties');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
