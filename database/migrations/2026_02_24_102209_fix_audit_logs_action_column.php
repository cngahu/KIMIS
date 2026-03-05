<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            // Option A: Make nullable (safest)
            $table->string('action')->nullable()->change();
            
            // Option B: Add default value (if action should always have a value)
            // $table->string('action')->default('login')->change();
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('action')->nullable(false)->change();
            // or: $table->string('action')->default(null)->change();
        });
    }
};