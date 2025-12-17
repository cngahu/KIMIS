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
        Schema::create('student_opening_balances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('amount', 14, 2)
                ->comment('Opening balance carried from legacy system');

            $table->date('as_of_date')
                ->comment('Balance position date');

            $table->string('source')
                ->nullable()
                ->comment('legacy_masterdata, manual_adjustment, etc');

            $table->timestamps();

            // Safety: one opening balance per student
            $table->unique('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_opening_balances');
    }
};
