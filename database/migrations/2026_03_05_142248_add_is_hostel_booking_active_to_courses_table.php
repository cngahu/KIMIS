<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->boolean('is_hostel_booking_active')->default(false)->after('course_name');
            // Optional: add index for better query performance
            $table->index('is_hostel_booking_active');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['is_hostel_booking_active']); // if you added the index
            $table->dropColumn('is_hostel_booking_active');
        });
    }
};