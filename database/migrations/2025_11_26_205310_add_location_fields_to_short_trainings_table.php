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
        Schema::table('short_trainings', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('short_trainings', 'home_county_id')) {
                $table->foreignId('home_county_id')->nullable()->constrained('counties')->onDelete('set null');
            }

            if (!Schema::hasColumn('short_trainings', 'current_county_id')) {
                $table->foreignId('current_county_id')->nullable()->constrained('counties')->onDelete('set null');
            }

            if (!Schema::hasColumn('short_trainings', 'current_subcounty_id')) {
                $table->foreignId('current_subcounty_id')->nullable()->constrained('subcounties')->onDelete('set null');
            }

            if (!Schema::hasColumn('short_trainings', 'postal_code_id')) {
                $table->foreignId('postal_code_id')->nullable()->constrained('postal_codes')->onDelete('set null');
            }

            if (!Schema::hasColumn('short_trainings', 'postal_address')) {
                $table->string('postal_address')->nullable();
            }

            if (!Schema::hasColumn('short_trainings', 'co')) {
                $table->string('co')->nullable()->comment('C/O field');
            }

            if (!Schema::hasColumn('short_trainings', 'town')) {
                $table->string('town')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('short_trainings', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['home_county_id']);
            $table->dropForeign(['current_county_id']);
            $table->dropForeign(['current_subcounty_id']);
            $table->dropForeign(['postal_code_id']);

            // Drop columns
            $table->dropColumn('home_county_id');
            $table->dropColumn('current_county_id');
            $table->dropColumn('current_subcounty_id');
            $table->dropColumn('postal_code_id');
            $table->dropColumn('postal_address');
            $table->dropColumn('co');
            $table->dropColumn('town');
        });
    }
};
