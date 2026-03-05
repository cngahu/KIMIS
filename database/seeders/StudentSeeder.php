<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Gender;
use App\Models\County;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // 🔍 Helper: Get first ID from table or return 1
        $getFirstId = function ($table, $column = 'name') {
            $record = DB::table($table)->first();
            return $record?->id ?? 1;
        };

        // ✅ Ensure Gender table has data
        if (DB::table('genders')->count() === 0) {
            DB::table('genders')->insert([
                ['name' => 'Male', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Female', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // ✅ Ensure Counties table has data (use correct column name)
        if (DB::table('counties')->count() === 0) {
            // Get actual column name for county name
            $columns = DB::getSchemaBuilder()->getColumnListing('counties');
            $nameColumn = in_array('name', $columns) ? 'name' : 
                         (in_array('county', $columns) ? 'county' : 
                         (in_array('county_name', $columns) ? 'county_name' : $columns[1] ?? 'name'));
            
            DB::table('counties')->insert([
                [$nameColumn => 'Nairobi', 'created_at' => now(), 'updated_at' => now()],
                [$nameColumn => 'Mombasa', 'created_at' => now(), 'updated_at' => now()],
                [$nameColumn => 'Kisumu', 'created_at' => now(), 'updated_at' => now()],
                [$nameColumn => 'Unknown', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // ✅ Ensure Country table has data
        if (DB::table('countries')->count() === 0) {
            $columns = DB::getSchemaBuilder()->getColumnListing('countries');
            $nameColumn = in_array('name', $columns) ? 'name' : $columns[1] ?? 'name';
            
            DB::table('countries')->insert([
                [$nameColumn => 'Kenya', 'code' => 'KE', 'created_at' => now(), 'updated_at' => now()],
                [$nameColumn => 'Uganda', 'code' => 'UG', 'created_at' => now(), 'updated_at' => now()],
                [$nameColumn => 'Tanzania', 'code' => 'TZ', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // 🎓 Create 50 dummy students
        User::factory()
            ->count(50)
            ->student()
            ->create()
            ->each(function ($user) {
                if (method_exists($user, 'assignRole')) {
                    try {
                        $user->assignRole('student');
                    } catch (\Exception $e) {
                        // Spatie not set up - skip role assignment
                    }
                }
            });

        // 👨‍💼 Create 5 admins
        User::factory()
            ->count(5)
            ->admin()
            ->create()
            ->each(function ($user) {
                if (method_exists($user, 'assignRole')) {
                    try {
                        $user->assignRole('admin');
                    } catch (\Exception $e) {
                        // Skip if roles not configured
                    }
                }
            });

        // 👨‍🏫 Create 4 HODs
        foreach (['BLD', 'DCE', 'DEP', 'ARCH'] as $program) {
            User::factory()
                ->state(['code' => 'HOD-' . $program . '-01'])
                ->hod()
                ->create();
        }

        $this->command->info('✅ Seeding Complete!');
        $this->command->info('   🎓 50 Students');
        $this->command->info('   👨‍💼 5 Admins');
        $this->command->info('   👨‍🏫 4 HODs');
        $this->command->info('');
        $this->command->info('🔑 Default Passwords:');
        $this->command->info('   Students: Student@2024');
        $this->command->info('   Admins:   Admin@2024');
        $this->command->info('   HODs:     HOD@2024');
    }
}