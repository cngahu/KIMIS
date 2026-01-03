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

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['academic_department_id']);
            $table->dropColumn('academic_department_id');
        });
    }
};
