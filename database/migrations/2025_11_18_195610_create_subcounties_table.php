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
        Schema::create('subcounties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('county_id')->constrained('counties')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();

            $table->unique(['county_id', 'name']); // Prevent duplicates within same county
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcounties');
    }
};
