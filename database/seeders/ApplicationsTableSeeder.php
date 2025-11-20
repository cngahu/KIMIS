<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Application;

use Illuminate\Support\Str;
use Carbon\Carbon;
class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $genders   = ['Male', 'Female'];
        $financers = ['self', 'parent'];
        $statuses  = ['submitted', 'under_review', 'approved', 'rejected'];

        for ($i = 0; $i < 500; $i++) {

            // random status
            $status = $statuses[array_rand($statuses)];

            // ensure logic: approved/rejected must have reviewer
            $reviewerId = in_array($status, ['approved', 'rejected', 'under_review'])
                ? rand(15, 16)
                : null;

            // set realistic times
            $createdAt = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 23));

            $updatedAt = clone $createdAt;
            if (in_array($status, ['approved', 'rejected', 'under_review'])) {
                $updatedAt = $updatedAt->addDays(rand(1, 5));
            }

            Application::create([
                'course_id'            => rand(316, 320),
                'full_name'            => fake()->name(),
                'id_number'            => fake()->numerify('########'),
                'phone'                => '+2547' . rand(10000000, 99999999),
                'email'                => fake()->unique()->safeEmail(),
                'date_of_birth'        => fake()->date('Y-m-d', '2005-01-01'),
                'gender'               => $genders[array_rand($genders)],
                'home_county_id'       => rand(1, 47),
                'current_county_id'    => rand(1, 47),
                'current_subcounty_id' => rand(1, 3),
                'postal_address'       => fake()->address(),
                'postal_code_id'       => rand(1, 1),
                'co'                   => fake()->name(),
                'town'                 => fake()->city(),
                'financier'            => $financers[array_rand($financers)],
                'kcse_mean_grade'      => fake()->randomElement(['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+']),
                'declaration'          => 1,
                'status'               => $status,
                'payment_status'       => 'paid',
                'reference'            => 'APP-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
                'reviewer_id'          => $reviewerId,
                'reviewer_comments'    => $status === 'rejected' ? 'Incomplete documents' : null,
                'metadata'             => null,
                'created_at'           => $createdAt,
                'updated_at'           => $updatedAt,
            ]);
        }
    }
}
