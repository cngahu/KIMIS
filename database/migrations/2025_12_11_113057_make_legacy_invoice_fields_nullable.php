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
            // Drop foreign keys first
            $table->dropForeign(['application_id']);
            $table->dropForeign(['course_id']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            // Make columns nullable
            $table->unsignedBigInteger('application_id')->nullable()->change();
            $table->unsignedBigInteger('course_id')->nullable()->change();
        });

        Schema::table('invoices', function (Blueprint $table) {
            // Re-add FKs with ON DELETE SET NULL
            $table->foreign('application_id')
                ->references('id')->on('applications')
                ->onDelete('set null');

            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop modified FKs
            $table->dropForeign(['application_id']);
            $table->dropForeign(['course_id']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            // Revert to NOT NULL
            $table->unsignedBigInteger('application_id')->nullable(false)->change();
            $table->unsignedBigInteger('course_id')->nullable(false)->change();
        });

        Schema::table('invoices', function (Blueprint $table) {
            // Restore original FK behavior (CASCADE / SET NULL depending on old state)
            $table->foreign('application_id')
                ->references('id')->on('applications')
                ->onDelete('cascade');

            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('set null');
        });
    }
};
