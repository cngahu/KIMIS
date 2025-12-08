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
            // Category of invoice (application fee, admission fee, course fee, etc)
            $table->enum('category', [
                'application_fee',
                'admission_fee',
                'course_fee',
                'knec_application',

                'misc'
            ])->default('misc')->after('invoice_number');

            // Who this invoice belongs to — nullable because guest users may generate invoices
            $table->unsignedBigInteger('user_id')->nullable()->after('application_id');

            // Course associated with the invoice
            $table->unsignedBigInteger('course_id')->nullable()->after('user_id');

            // Foreign keys
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['course_id']);

            $table->dropColumn(['category', 'user_id', 'course_id']);
        });
    }
};
