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
        Schema::create('admission_fee_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admission_id');
            $table->unsignedBigInteger('invoice_id')->nullable();

            $table->decimal('amount', 10, 2);
            $table->enum('payment_type', ['full','partial','sponsor','pay_later']);
            $table->enum('status', ['pending','paid','rejected','verified'])->default('pending');

            $table->string('sponsor_name')->nullable();
            $table->string('sponsor_letter')->nullable();
            $table->text('explanation')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->cascadeOnDelete();
            $table->foreign('invoice_id')->references('id')->on('invoices')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_fee_payments');
    }
};
