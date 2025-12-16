<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {

            $table->unsignedBigInteger('hod_approver_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('registrar_approver_id')->nullable()->after('hod_approver_id');
            $table->unsignedBigInteger('kihbt_registrar_approver_id')->nullable()->after('registrar_approver_id');
            $table->unsignedBigInteger('director_approver_id')->nullable()->after('kihbt_registrar_approver_id');

            // Foreign keys
            $table->foreign('hod_approver_id')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('registrar_approver_id')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('kihbt_registrar_approver_id')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('director_approver_id')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropForeign(['hod_approver_id']);
            $table->dropForeign(['registrar_approver_id']);
            $table->dropForeign(['kihbt_registrar_approver_id']);
            $table->dropForeign(['director_approver_id']);

            $table->dropColumn([
                'hod_approver_id',
                'registrar_approver_id',
                'kihbt_registrar_approver_id',
                'director_approver_id',
            ]);
        });
    }
};
