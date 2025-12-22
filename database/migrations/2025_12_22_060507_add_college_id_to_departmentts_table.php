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
//        Schema::table('departmentts', function (Blueprint $table) {
//            // Add column
//            $table->foreignId('college_id')
//                ->after('id')
//                ->constrained('colleges')
//                ->cascadeOnDelete();
//        });
    }

    public function down(): void
    {
//        Schema::table('departmentts', function (Blueprint $table) {
//            // Drop FK first
//            $table->dropForeign(['college_id']);
//            $table->dropColumn('college_id');
//        });
    }
};
