<?php

namespace Database\Seeders;

use App\Models\CourseStage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseStagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $stages = [
            // Year 1
            ['code' => '1.1', 'name' => 'Year 1 Term 1', 'stage_type' => 'academic', 'is_billable' => true],
            ['code' => '1.2', 'name' => 'Year 1 Term 2', 'stage_type' => 'academic', 'is_billable' => true],
            ['code' => '1.3', 'name' => 'Year 1 Term 3', 'stage_type' => 'academic', 'is_billable' => true],

            // Year 2
            ['code' => '2.1', 'name' => 'Year 2 Term 1', 'stage_type' => 'academic', 'is_billable' => true],
            ['code' => '2.2', 'name' => 'Year 2 Term 2', 'stage_type' => 'academic', 'is_billable' => true],
            ['code' => '2.3', 'name' => 'Year 2 Term 3', 'stage_type' => 'academic', 'is_billable' => true],

            // Year 3
            ['code' => '3.1', 'name' => 'Year 3 Term 1', 'stage_type' => 'academic', 'is_billable' => true],
            ['code' => '3.2', 'name' => 'Year 3 Term 2', 'stage_type' => 'academic', 'is_billable' => true],
            ['code' => '3.3', 'name' => 'Year 3 Term 3', 'stage_type' => 'academic', 'is_billable' => true],

            // Non-academic stages
            ['code' => 'VACATION', 'name' => 'Vacation', 'stage_type' => 'vacation', 'is_billable' => false],
            ['code' => 'ATTACHMENT', 'name' => 'Attachment', 'stage_type' => 'attachment', 'is_billable' => false],
            ['code' => 'INTERNSHIP', 'name' => 'Internship', 'stage_type' => 'internship', 'is_billable' => false],
        ];

        foreach ($stages as $stage) {
            CourseStage::updateOrCreate(
                ['code' => $stage['code']],
                $stage
            );
        }
    }
}
