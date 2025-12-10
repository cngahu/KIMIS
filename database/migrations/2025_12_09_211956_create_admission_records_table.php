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
        Schema::create('admission_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admissionid')->nullable()->index();
            $table->unsignedBigInteger('studentid')->nullable()->index();
            $table->unsignedBigInteger('courseid')->nullable()->index();
            $table->unsignedBigInteger('studyyearid')->nullable()->index();

            $table->decimal('meanpoints', 8, 2)->nullable();
            $table->string('meangrade', 50)->nullable();
            $table->decimal('meanmarks', 8, 2)->nullable();
            $table->string('overallgrade', 50)->nullable();

            $table->string('modifiedby', 100)->nullable();
            $table->boolean('cancelresults')->default(false);

            $table->dateTime('admissiondate')->nullable();

            $table->unsignedBigInteger('streamid')->nullable();
            $table->boolean('boarder')->default(false);
            $table->boolean('refered')->default(false);
            $table->boolean('found')->default(false);

            $table->string('certno', 100)->nullable()->index();
            $table->string('username', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_records');
    }
};
