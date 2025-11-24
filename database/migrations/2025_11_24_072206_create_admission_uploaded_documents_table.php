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
        Schema::create('admission_uploaded_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admission_id');
            $table->unsignedBigInteger('document_type_id');

            $table->string('file_path');
            $table->boolean('verified')->default(0);
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->cascadeOnDelete();
            $table->foreign('document_type_id')->references('id')->on('admission_document_types')->cascadeOnDelete();
            $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_uploaded_documents');
    }
};
