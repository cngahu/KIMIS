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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id')->unique();
            $table->unsignedBigInteger('user_id')->unique(); // linked to student login
            $table->enum('status', [
                'offer_sent',
                'offer_accepted',
                'form_submitted',
                'documents_uploaded',
                'docs_verified',
                'fee_pending',
                'fee_paid',
                'admission_number_assigned',
                'admitted'
            ])->default('offer_sent');

            $table->timestamp('offer_accepted_at')->nullable();
            $table->timestamp('form_submitted_at')->nullable();
            $table->timestamp('documents_submitted_at')->nullable();
            $table->timestamp('fee_cleared_at')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->unsignedBigInteger('verified_by')->nullable();
            $table->string('admission_number')->nullable();

            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('applications')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
