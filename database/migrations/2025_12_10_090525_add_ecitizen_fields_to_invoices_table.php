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
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('invoice_amount', 10, 2)
                ->nullable()
                ->after('amount');  // Store official invoice_amount from eCitizen

            $table->string('payment_channel')
                ->nullable()
                ->after('invoice_amount');

            $table->string('ecitizen_invoice_number')
                ->nullable()
                ->after('payment_channel'); // This stores "invoice_number" from payload
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_amount');
            $table->dropColumn('payment_channel');
            $table->dropColumn('ecitizen_invoice_number');
        });
    }
};
