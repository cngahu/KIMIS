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
        Schema::create('student_ledgers', function (Blueprint $table) {
            $table->id();

            // -----------------------------
            // Identity & Anchors
            // -----------------------------
            $table->foreignId('student_id')->nullable()
                ->constrained()->nullOnDelete();

            $table->foreignId('masterdata_id')->nullable()
                ->constrained('masterdata')->nullOnDelete();

            $table->foreignId('enrollment_id')->nullable()
                ->constrained()->nullOnDelete();

            // -----------------------------
            // Accounting Core
            // -----------------------------
            $table->enum('entry_type', ['debit', 'credit']);
            $table->string('category', 50);
            // e.g. tuition_fee, opening_balance, ecitizen_payment

            $table->decimal('amount', 14, 2);
            $table->boolean('provisional')->default(true);

            // -----------------------------
            // Academic Context
            // -----------------------------
            $table->string('cycle_term', 10)->nullable(); // Jan, May, Sep
            $table->smallInteger('cycle_year')->nullable();

            $table->foreignId('course_id')->nullable()
                ->constrained()->nullOnDelete();

            $table->foreignId('course_stage_id')->nullable()
                ->constrained()->nullOnDelete();

            // -----------------------------
            // Source & Traceability
            // -----------------------------
            $table->string('source', 50);
            // legacy_projection, system, ecitizen, manual

            $table->string('reference_type', 50)->nullable();
            // invoice, receipt, adjustment

            $table->unsignedBigInteger('reference_id')->nullable();

            $table->text('description');

            // -----------------------------
            // Governance & Audit
            // -----------------------------
            $table->foreignId('created_by')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->timestamps();

            // -----------------------------
            // Indexes (Performance Critical)
            // -----------------------------
            $table->index(['student_id', 'provisional']);
            $table->index(['masterdata_id', 'provisional']);
            $table->index(['cycle_year', 'cycle_term']);
            $table->index(['entry_type', 'category']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_ledgers');
    }
};
