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
        Schema::table('student_ledgers', function (Blueprint $table) {

            // Explicit ledger owner (account holder)
            $table->string('ledger_owner_type')->nullable()->after('masterdata_id');
            $table->unsignedBigInteger('ledger_owner_id')->nullable()->after('ledger_owner_type');

            // Index for fast balance lookups
            $table->index(
                ['ledger_owner_type', 'ledger_owner_id'],
                'student_ledgers_ledger_owner_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('student_ledgers', function (Blueprint $table) {
            $table->dropIndex('student_ledgers_ledger_owner_index');
            $table->dropColumn(['ledger_owner_type', 'ledger_owner_id']);
        });
    }
};
