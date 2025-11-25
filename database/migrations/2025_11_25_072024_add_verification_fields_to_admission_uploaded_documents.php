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
        Schema::table('admission_uploaded_documents', function (Blueprint $table) {
            $table->enum('verified_status', ['pending','approved','rejected','pending_fix'])->default('pending');
//            $table->text('comment')->nullable()->after('verified_status');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_uploaded_documents', function (Blueprint $table) {
            //
        });
    }
};
