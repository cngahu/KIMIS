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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Course applied for
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();

            // Personal Info
            $table->string('full_name');
            $table->string('id_number')->nullable();
            $table->string('phone'); // +254 format
            $table->string('email')->nullable();

            $table->date('date_of_birth')->nullable();

            // Location
            $table->foreignId('home_county_id')->nullable()->constrained('counties');
            $table->foreignId('current_county_id')->nullable()->constrained('counties');
            $table->foreignId('current_subcounty_id')->nullable()->constrained('subcounties');

            // Address
            $table->string('postal_address')->nullable();
            $table->foreignId('postal_code_id')->nullable()->constrained('postal_codes');
            $table->string('co')->nullable();
            $table->string('town')->nullable();

            // Education + Other
            $table->enum('financier', ['self','parent'])->default('self');
            $table->string('kcse_mean_grade')->nullable();

            $table->boolean('declaration')->default(false);

            // Application + Payment Status
            $table->enum('status', ['pending_payment','submitted','under_review','approved','rejected'])
                ->default('pending_payment');

            $table->enum('payment_status', ['pending','paid','failed'])
                ->default('pending');

            $table->string('reference')->unique(); // unique application reference

            // Admin review fields
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('reviewer_comments')->nullable();

            // Extra metadata
            $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
