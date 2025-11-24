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
        Schema::table('admissions', function (Blueprint $table) {
            $table->enum('status', [
                'offer_sent',
                'offer_accepted',
                'form_submitted',
                'documents_uploaded',
                'docs_verified',
                'fee_pending',
                'fee_paid',
                'admission_number_assigned',
                'admitted',
                'awaiting_sponsor_verification',
            ])->default('offer_sent')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            //
        });
    }
};
