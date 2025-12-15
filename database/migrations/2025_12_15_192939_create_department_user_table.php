<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
Schema::create('department_user', function (Blueprint $table) {
$table->id();

// IMPORTANT: reference departmentts table (your actual name)
$table->unsignedBigInteger('department_id');
$table->unsignedBigInteger('user_id');

$table->timestamps();

$table->unique(['department_id', 'user_id']);

// Foreign keys (match the actual table names)
$table->foreign('department_id')
->references('id')
->on('departmentts')
->cascadeOnDelete();

$table->foreign('user_id')
->references('id')
->on('users')
->cascadeOnDelete();
});
}

public function down(): void
{
Schema::dropIfExists('department_user');
}
};
