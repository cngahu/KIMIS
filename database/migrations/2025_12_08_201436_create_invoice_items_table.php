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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Parent invoice
            $table->unsignedBigInteger('invoice_id');

            // The specific trainee/person/applicant
            $table->unsignedBigInteger('user_id')->nullable();

            // Link back to application or admission (optional)
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('admission_id')->nullable();

            // Course being paid for
            $table->unsignedBigInteger('course_id')->nullable();

            // Invoice line details
            $table->string('item_name');                 // e.g. "Defensive Driving - John Doe"
            $table->decimal('unit_amount', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('total_amount', 10, 2);

            // Additional details
            $table->json('metadata')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('invoice_id')->references('id')
                ->on('invoices')->onDelete('cascade');

            $table->foreign('user_id')->references('id')
                ->on('users')->nullOnDelete();

            $table->foreign('application_id')->references('id')
                ->on('applications')->nullOnDelete();

            $table->foreign('admission_id')->references('id')
                ->on('admissions')->nullOnDelete();

            $table->foreign('course_id')->references('id')
                ->on('courses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
