<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Gender;
use App\Models\County;
use App\Models\Country;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $surname = fake()->lastName();
        $firstname = fake()->firstName();
        
        return [
            // 👤 Name Fields (MATCH YOUR SCHEMA EXACTLY)
            'surname' => $surname,
            'firstname' => $firstname,
            'othername' => fake()->optional()->firstName(),
            'username' => fake()->unique()->userName(),
            
            // 📧 Email & Auth
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'password_expires_at' => now()->addMonths(3),
            'password_changed_at' => now(),
            'must_change_password' => false,
            'remember_token' => Str::random(10),
            
            // 📱 Contact Info
            'photo' => fake()->imageUrl('60', '60'),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'code' => fake()->optional()->numerify('#####'),
            'physical_address' => fake()->optional()->address(),
            'city' => fake()->city(),
            
            // 👥 Role & Status
            'userrole' => fake()->randomElement(['student', 'admin', 'hod', 'staff']),
            'status' => 'active',
            
            // 🆔 Identifiers
            'title_id' => fake()->randomElement([1, 2, 3]), // Mr, Mrs, Dr, etc.
            'gender_id' => Gender::inRandomOrder()->first()?->id ?? 1,
            'country_id' => 1, // Default: Kenya
            'dob' => fake()->dateTimeBetween('-30 years', '-16 years')->format('Y-m-d'),
            'nationality' => 1,
            'county' => County::inRandomOrder()->first()?->id ?? 1,
            
            // 🆔 National ID
            'nationalid' => fake()->optional()->numerify('########'),
            'national_id' => fake()->optional()->numerify('########'),
            
            // 👨‍👩‍👧 Next of Kin
            'next_of_kin' => fake()->name(),
            'next_of_kin_contact' => fake()->phoneNumber(),
            
            // 🎓 Academic Level (for students)
            'level' => fake()->randomElement(['1', '2', '3', '4']),
        ];
    }

    /**
     * 🎓 State: Create a STUDENT user
     */
    public function student(): static
    {
        return $this->state(function (array $attributes) {
            $surname = fake()->lastName();
            $firstname = fake()->firstName();
            $program = fake()->randomElement(['BLD', 'DCE', 'DEP', 'ARCH', 'ICT']);
            $year = fake()->randomElement([2022, 2023, 2024, 2025]);
            $number = str_pad(fake()->numberBetween(100, 999), 3, '0', STR_PAD_LEFT);
            
            return [
                // Name
                'surname' => $surname,
                'firstname' => $firstname,
                'othername' => '',
                'username' => strtolower("{$firstname}.{$surname}"),
                
                // KIMS Student Email
                'email' => strtolower(sprintf('%s.%s@kihbt.ac.ke', 
                    Str::slug($firstname), 
                    Str::slug($surname)
                )),
                'email_verified_at' => now(),
                
                // Student Role
                'userrole' => 'student',
                'status' => 'active',
                
                // Student Code (Registration Number format)
                'code' => "{$year}/{$program}/{$number}",
                
                // Student Level
                'level' => fake()->randomElement(['1', '2', '3']),
                
                // Default Student Password
                'password' => Hash::make('Student@2024'),
                'must_change_password' => true,
                
                // DOB (student age range)
                'dob' => fake()->dateTimeBetween('-25 years', '-16 years')->format('Y-m-d'),
            ];
        });
    }

    /**
     * 👨‍💼 State: Create an ADMIN user
     */
    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => fake()->unique()->safeEmail(),
                'username' => fake()->unique()->userName(),
                'userrole' => 'admin',
                'status' => 'active',
                'password' => Hash::make('Admin@2024'),
                'must_change_password' => false,
                'code' => 'ADM-' . fake()->numerify('####'),
                'level' => null,
            ];
        });
    }

    /**
     * 👨‍🏫 State: Create a HOD (Head of Department)
     */
    public function hod(): static
    {
        return $this->state(function (array $attributes) {
            $program = fake()->randomElement(['BLD', 'DCE', 'DEP', 'ARCH']);
            
            return [
                'email' => fake()->unique()->safeEmail(),
                'username' => fake()->unique()->userName(),
                'userrole' => 'hod',
                'status' => 'active',
                'password' => Hash::make('HOD@2024'),
                'must_change_password' => false,
                'code' => 'HOD-' . strtoupper($program) . '-' . fake()->numerify('##'),
                'level' => null,
            ];
        });
    }

    /**
     * 🔐 State: Unverified email
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * ❌ State: Inactive/disabled account
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * 🔒 State: Must change password on first login
     */
    public function mustChangePassword(): static
    {
        return $this->state(fn(array $attributes) => [
            'must_change_password' => true,
        ]);
    }
}