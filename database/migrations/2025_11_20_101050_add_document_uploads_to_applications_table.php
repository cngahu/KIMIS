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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('kcse_certificate_path')->nullable()->after('kcse_mean_grade');
            $table->string('school_leaving_certificate_path')->nullable()->after('kcse_certificate_path');
            $table->string('birth_certificate_path')->nullable()->after('school_leaving_certificate_path');
            $table->string('national_id_path')->nullable()->after('birth_certificate_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'kcse_certificate_path',
                'school_leaving_certificate_path',
                'birth_certificate_path',
                'national_id_path',
            ]);
        });
    }
};
