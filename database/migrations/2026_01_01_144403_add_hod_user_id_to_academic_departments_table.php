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
        Schema::table('academic_departments', function (Blueprint $table) {
            $table->unsignedBigInteger('hod_user_id')
                ->nullable()
                ->after('college_id');

            $table->foreign('hod_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('academic_departments', function (Blueprint $table) {
            $table->dropForeign(['hod_user_id']);
            $table->dropColumn('hod_user_id');
        });
    }
};
