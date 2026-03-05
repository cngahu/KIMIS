<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferenceDataSeeder extends Seeder
{
    public function run(): void
    {
        // Seed titles
        if (DB::table('titles')->count() === 0) {
            DB::table('titles')->insert([
                ['name' => 'Mr.'],
                ['name' => 'Mrs.'],
                ['name' => 'Ms.'],
                ['name' => 'Dr.'],
            ]);
        }
        
        // Seed genders
        if (DB::table('genders')->count() === 0) {
            DB::table('genders')->insert([
                ['name' => 'Male'],
                ['name' => 'Female'],
            ]);
        }
        
        // Seed countries
        if (DB::table('countries')->count() === 0) {
            DB::table('countries')->insert([
                ['name' => 'Kenya', 'code' => 'KE'],
            ]);
        }
        
        // Seed counties
        if (DB::table('counties')->count() === 0) {
            DB::table('counties')->insert([
                ['name' => 'Nairobi'],
                ['name' => 'Mombasa'],
                ['name' => 'Unknown'],
            ]);
        }
        
        $this->command->info('✅ Reference data seeded!');
    }
}