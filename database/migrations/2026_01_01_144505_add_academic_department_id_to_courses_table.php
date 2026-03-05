<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Only run if table exists
        if (Schema::hasTable('academic_departments')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->unsignedBigInteger('academic_department_id')
                    ->nullable()
                    ->after('department_id');

                $table->foreign('academic_department_id')
                    ->references('id')
                    ->on('academic_departments')
                    ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('academic_departments') && Schema::hasColumn('courses', 'academic_department_id')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropForeign(['academic_department_id']);
                $table->dropColumn('academic_department_id');
            });
        }
    }
};