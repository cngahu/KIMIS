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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Polymorphic relation (model being audited)
            $table->string('auditable_type', 150)->index();
            $table->unsignedBigInteger('auditable_id')->index();

            // Actor
            $table->unsignedBigInteger('user_id')->nullable()->index();

            // Action type
            $table->string('action', 50)->index(); // created, updated, deleted, login, logout, custom

            // Data changes
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // Context metadata
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url')->nullable();

            $table->timestamps();

            // Important compound index for fast audits
            $table->index(['auditable_type', 'auditable_id'], 'auditable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
