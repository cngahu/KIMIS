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
            // Add polymorphic columns (nullable for backward compatibility)
            $table->string('billable_type')->nullable()->after('application_id');
            $table->unsignedBigInteger('billable_id')->nullable()->after('billable_type');

            // Optional: index for fast lookups
            $table->index(['billable_type', 'billable_id'], 'invoices_billable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex('invoices_billable_index');
            $table->dropColumn(['billable_type', 'billable_id']);
        });
    }
};
