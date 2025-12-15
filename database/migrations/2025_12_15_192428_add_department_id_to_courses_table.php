<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Ensure column exists (but don't add if it already exists)
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('college_id');
            }
        });

        // 2) Drop FK if it already exists (any name)
        $dbName = DB::getDatabaseName();

        $fkName = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', $dbName)
            ->where('TABLE_NAME', 'courses')
            ->where('COLUMN_NAME', 'department_id')
            ->whereNotNull('CONSTRAINT_NAME')
            ->where('CONSTRAINT_NAME', '!=', 'PRIMARY')
            ->value('CONSTRAINT_NAME');

        if ($fkName) {
            DB::statement("ALTER TABLE `courses` DROP FOREIGN KEY `{$fkName}`");
        }

        // 3) Add FK (use a UNIQUE custom name to avoid collision)
        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('department_id', 'fk_courses_departmentts_department_id')
                ->references('id')
                ->on('departmentts')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Drop our custom FK if it exists, then column (optional)
        try {
            DB::statement("ALTER TABLE `courses` DROP FOREIGN KEY `fk_courses_departmentts_department_id`");
        } catch (\Throwable $e) {
        }

        Schema::table('courses', function (Blueprint $table) {
            // Only drop column if you want rollback to remove it:
            // if (Schema::hasColumn('courses', 'department_id')) $table->dropColumn('department_id');
        });
    }
};
