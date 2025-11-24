<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_data', function (Blueprint $table) {
            $table->id();

            // From Excel
            $table->unsignedInteger('row_no')->nullable();           // "No"
            $table->string('admn_no')->nullable();                   // "Admn. No"
            $table->string('course')->nullable();                    // "COURSE"
            $table->string('student_name')->nullable();              // "Students Name"
            $table->string('gender', 10)->nullable();                // "Gender"
            $table->string('id_no')->nullable();                     // "ID No."
            $table->string('mobile_no')->nullable();                 // "Mobile No."
            $table->string('county')->nullable();                    // "COUNTY"
            $table->string('email')->nullable();                     // "EMail"
            $table->string('sponsor')->nullable();                   // "SPONSOR"
            $table->string('receipt_number')->nullable();            // "RECEIPT NUMBER "
            $table->decimal('invoiced', 12, 2)->nullable();          // "INVOICED"
            $table->decimal('amount_paid', 12, 2)->nullable();       // "AMOUNT PAID"
            $table->decimal('due', 12, 2)->nullable();               // "DUE"
            $table->string('cert_no')->nullable();                   // "CERT NO."
            $table->date('start_date')->nullable();                  // "START DATE"
            $table->date('end_date')->nullable();                    // "END DATE"
            $table->text('comment_signature')->nullable();           // "COMMENT / SIGNATURE"

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_data');
    }
};
