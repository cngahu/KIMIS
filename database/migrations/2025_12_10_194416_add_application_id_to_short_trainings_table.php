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
            // Add application_id if not present
            if (!Schema::hasColumn('short_trainings', 'application_id')) {
                $table->unsignedBigInteger('application_id')
                    ->nullable()
                    ->after('id');
            }

            // Add FK
            $table->foreign('application_id', 'st_part_application_fk')
                ->references('id')
                ->on('short_training_applications')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('short_trainings', function (Blueprint $table) {
            if (Schema::hasColumn('short_trainings', 'application_id')) {
                $table->dropForeign('st_part_application_fk');
                $table->dropColumn('application_id');
            }
        });
    }
};
