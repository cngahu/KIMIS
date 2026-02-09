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
            $table->decimal('half_board_fee', 10, 2)
                ->default(0.00)
                ->after('cost');

            $table->decimal('full_board_fee', 10, 2)
                ->default(0.00)
                ->after('half_board_fee');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'half_board_fee',
                'full_board_fee',
            ]);
        });
    }
};
