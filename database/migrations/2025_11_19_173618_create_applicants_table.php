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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('id_number')->nullable()->index();
            $table->string('phone')->nullable()->index(); // +254 format
            $table->string('email')->nullable();

            $table->date('date_of_birth')->nullable();

            $table->foreignId('home_county_id')->nullable()->constrained('counties');
            $table->foreignId('current_county_id')->nullable()->constrained('counties');
            $table->foreignId('current_subcounty_id')->nullable()->constrained('subcounties');

            $table->string('postal_address')->nullable();
            $table->foreignId('postal_code_id')->nullable()->constrained('postal_codes');

            $table->string('co')->nullable();
            $table->string('town')->nullable(); // you mentioned town field on applicant

            $table->enum('financier', ['self','parent'])->default('self');
            $table->string('kcse_mean_grade')->nullable();

            $table->boolean('declaration')->default(false);

            $table->json('extra')->nullable(); // if you need later

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
