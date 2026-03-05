<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class QuickStudentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔧 Preparing reference data...');
        
        // ✅ STEP 1: Ensure reference tables have at least ID=1
        $this->ensureReferenceData();
        
        $this->command->info('🎓 Creating 50 dummy students...');
        
        $students = [];
        
        for ($i = 0; $i < 50; $i++) {
            $firstName = fake()->firstName();
            $surname = fake()->lastName();
            $program = fake()->randomElement(['BLD', 'DCE', 'DEP', 'ARCH', 'ICT']);
            $year = fake()->randomElement([2022, 2023, 2024, 2025]);
            $num = str_pad(fake()->numberBetween(100, 999), 3, '0', STR_PAD_LEFT);
            
            $students[] = [
                // 👤 Name (REQUIRED)
                'surname' => $surname,
                'firstname' => $firstName,
                'othername' => '',
                
                // 🔐 Auth (REQUIRED)
                'email' => strtolower("{$firstName}.{$surname}@kihbt.ac.ke"),
                'email_verified_at' => now(),
                'password' => Hash::make('Student@2024'),
                'remember_token' => Str::random(10),
                
                // 👥 Role (REQUIRED - matches your ENUM)
                'userrole' => 'user',
                'status' => 'active',
                
                // 🆔 Registration code
                'code' => "{$year}/{$program}/{$num}",
                
                // 📱 Basic contact
                'username' => strtolower("{$firstName}.{$surname}"),
                'phone' => fake()->phoneNumber(),
                
                // 📅 DOB
                'dob' => fake()->dateTimeBetween('-25 years', '-16 years')->format('Y-m-d'),
                
                // 🆔 National ID (NOT NULL columns)
                'nationalid' => fake()->numerify('########'),
                'national_id' => fake()->numerify('########'),
                
                // ⚙️ Password settings
                'must_change_password' => true,
                'password_expires_at' => now()->addMonths(3),
                'password_changed_at' => now(),
                
                // 🎓 Academic level
                'level' => (string)fake()->randomElement([1, 2, 3]),
                
                // 🔗 Foreign Keys - NOW SAFE (ID=1 guaranteed to exist)
                'title_id' => 1,
                'gender_id' => 1,
                'country_id' => 1,
                'county' => 1,
                'nationality' => 1,
                
                // ⏰ Timestamps (REQUIRED)
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // ✅ STEP 2: Insert students
        DB::table('users')->insert($students);
        
        $this->command->info('✅ 50 students created successfully!');
        $this->command->info('🔑 Password: Student@2024');
        $this->command->info('📧 Format: firstname.surname@kihbt.ac.ke');
        
        $sample = DB::table('users')->where('userrole', 'user')->first();
        if ($sample) {
            $this->command->info("🧪 Test: {$sample->email} | Code: {$sample->code}");
        }
    }
    
    /**
     * ✅ Ensure reference tables have ID=1 records
     */
    private function ensureReferenceData(): void
    {
        // titles table
        if (DB::table('titles')->count() === 0) {
            DB::table('titles')->insert([
                ['id' => 1, 'name' => 'Mr.', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        
        // genders table
        if (DB::table('genders')->count() === 0) {
            DB::table('genders')->insert([
                ['id' => 1, 'name' => 'Male', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        
        // countries table (NO 'code' column - only insert 'name')
        if (DB::table('countries')->count() === 0) {
            DB::table('countries')->insert([
                ['id' => 1, 'name' => 'Kenya', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        
        // counties table
        if (DB::table('counties')->count() === 0) {
            DB::table('counties')->insert([
                ['id' => 1, 'name' => 'Nairobi', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        
        $this->command->info('   ✅ Reference data ensured (titles, genders, countries, counties)');
    }
}