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
        Schema::create('short_training_applications', function (Blueprint $table) {
            $table->bigIncrements('id');

            // link to training schedule
            $table->unsignedBigInteger('training_id')->comment('references trainings.id');

            // who pays
            $table->enum('financier', ['self', 'employer'])->default('self');

            // Employer / payer details (nullable for self-financed)
            $table->string('employer_name')->nullable();
            $table->string('employer_contact_person')->nullable();
            $table->string('employer_phone', 50)->nullable();
            $table->string('employer_email')->nullable();
            $table->string('employer_postal_address')->nullable();
            $table->unsignedBigInteger('employer_postal_code_id')->nullable();
            $table->string('employer_town')->nullable();
            $table->unsignedBigInteger('employer_county_id')->nullable();

            // bookkeeping
            $table->string('reference')->unique()->comment('e.g. STAPP-XXXXXX');
            $table->unsignedInteger('total_participants')->default(1);

            // workflow
            $table->enum('status', ['pending_payment', 'paid', 'cancelled'])->default('pending_payment');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');

            // any extra json metadata (validation: json_valid at DB level can be added if desired)
            $table->json('metadata')->nullable();

            $table->timestamps();

            // indexes & foreign keys
            $table->index(
                ['training_id', 'status', 'payment_status'],
                'st_app_train_status_pay_idx'
            );

            $table->foreign('training_id')->references('id')->on('trainings')->onDelete('cascade');

            $table->foreign('employer_postal_code_id')->references('id')->on('postal_codes')->onDelete('set null');
            $table->foreign('employer_county_id')->references('id')->on('counties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('short_training_applications', function (Blueprint $table) {
            // drop foreign keys (if they exist)
            if (Schema::hasColumn('short_training_applications', 'training_id')) {
                $table->dropForeign(['training_id']);
            }
            if (Schema::hasColumn('short_training_applications', 'employer_postal_code_id')) {
                $table->dropForeign(['employer_postal_code_id']);
            }
            if (Schema::hasColumn('short_training_applications', 'employer_county_id')) {
                $table->dropForeign(['employer_county_id']);
            }
        });

        Schema::dropIfExists('short_training_applications');
    }
};
