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
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id();
            $table->string('admissionno')->nullable()->index();
            $table->string('studentsname')->nullable();
            $table->string('emailaddress')->nullable();
            $table->date('dob')->nullable();

            $table->boolean('accountactivated')->default(false);
            $table->string('unlockkey')->nullable();
            $table->string('studentpassword')->nullable();

            $table->string('studentid')->nullable()->index();
            $table->string('mobileno')->nullable();
            $table->string('nationalidno')->nullable()->index();
            $table->string('birthcertificateno')->nullable();
            $table->string('guardiancell')->nullable();
            $table->string('pobox')->nullable();
            $table->string('indexno')->nullable();
            $table->string('townname')->nullable();
            $table->string('guardianname')->nullable();
            $table->string('formerschool')->nullable();
            $table->string('certificatetype')->nullable();
            $table->string('certificateyear')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('admlastpart')->nullable();
            $table->string('relationship')->nullable();
            $table->string('kcsemeangrade')->nullable();
            $table->text('remarks')->nullable();
            $table->text('nextofkinaddress')->nullable();
            $table->string('series')->nullable();
            $table->string('applno')->nullable()->index();
            $table->string('county')->nullable();

            $table->dateTime('dateandtime')->nullable();
            $table->string('sponsorid')->nullable();
            $table->string('enggrade')->nullable();
            $table->string('mathgrade')->nullable();
            $table->string('phygrade')->nullable();
            $table->string('district')->nullable();
            $table->string('officer')->nullable();
            $table->string('company')->nullable();

            $table->boolean('active')->default(true);
            $table->decimal('cautionfeeamt', 10, 2)->nullable();

            $table->string('lastupdateby')->nullable();
            $table->dateTime('lastupdate')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodatas');
    }
};
