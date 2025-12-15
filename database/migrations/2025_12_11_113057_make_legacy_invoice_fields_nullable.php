<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Find FK name for invoices.application_id (if it exists)
        $dbName = DB::getDatabaseName();

        $fkName = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', $dbName)
            ->where('TABLE_NAME', 'invoices')
            ->where('COLUMN_NAME', 'application_id')
            ->whereNotNull('REFERENCED_TABLE_NAME')   // ensures it's a real FK
            ->value('CONSTRAINT_NAME');

        Schema::table('invoices', function (Blueprint $table) use ($fkName) {
            if ($fkName) {
                $table->dropForeign($fkName);
            }

            // ✅ Put your nullable changes here, example:
            // $table->unsignedBigInteger('application_id')->nullable()->change();
            // $table->string('legacy_invoice_no')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Optional: revert changes here if you want
    }
};
