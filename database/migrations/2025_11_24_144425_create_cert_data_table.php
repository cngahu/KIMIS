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
        Schema::create('cert_data', function (Blueprint $table) {
            $table->id();

            // Excel columns mapped directly
            $table->integer('No')->nullable();
            $table->string('Admn_No', 50)->nullable();
            $table->string('COURSE', 100)->nullable();
            $table->string('Students_Name', 100)->nullable();
            $table->enum('Gender', ['M', 'F'])->nullable();
            $table->string('ID_No', 20)->nullable();
            $table->string('Mobile_No', 15)->nullable();
            $table->string('COUNTY', 50)->nullable();
            $table->string('EMail', 100)->nullable();
            $table->string('SPONSOR', 200)->nullable();
            $table->string('RECEIPT_NUMBER', 50)->nullable();
            $table->decimal('INVOICED', 10, 2)->nullable();
            $table->decimal('AMOUNT_PAID', 10, 2)->nullable();
            $table->decimal('DUE', 10, 2)->nullable();
            $table->string('CERT_NO', 20)->nullable();
            $table->dateTime('START_DATE')->nullable();
            $table->dateTime('END_DATE')->nullable();
            $table->text('COMMENT_SIGNATURE')->nullable();

            $table->timestamps();

            // Indexes for better performance
            $table->index('Admn_No');
            $table->index('CERT_NO');
            $table->index('COUNTY');
            $table->index('START_DATE');
            $table->index('END_DATE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cert_data');
    }
};
