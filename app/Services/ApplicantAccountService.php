<?php

namespace App\Services;
use App\Models\Admission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class ApplicantAccountService
{
    public function createApplicantAccount0($application)
    {
        // If email already exists, do not recreate
        $existing = User::where('email', $application->email)->first();
        if ($existing) {
            return $existing;
        }

        $password = Str::random(10); // System-generated password

        $user = User::create([
            'name'     => $application->full_name,
            'email'    => $application->email,
            'password' => Hash::make($password),
        ]);

        // Assign applicant role
        $user->assignRole('student');

        // Return both user and raw password so we can email it
        return [
            'user' => $user,
            'password' => $password
        ];
    }
    public function createApplicantAccount($application)
    {
        // Check if user exists
        $existing = User::where('email', $application->email)->first();

        if ($existing) {
            return [
                'user' => $existing,
                'password' => null
            ];
        }

        // Generate random password
        $password = Str::random(10);

        // Split full name (if needed)
        $parts = explode(' ', $application->full_name);
        $surname   = $parts[0] ?? '';
        $firstname = $parts[1] ?? '';
        $othername = implode(' ', array_slice($parts, 2));

        // Create applicant user
        $user = User::create([
            'surname'   => $surname,
            'firstname' => $firstname,
            'othername' => $othername ?: null,
            'username'  => $application->email,
            'email'     => $application->email,
            'password'  => Hash::make($password),
        ]);

        // Assign applicant role
        $user->assignRole('student');
// 2. Create admission record
        Admission::create([
            'application_id' => $application->id,
            'user_id'        => $user->id,
            'status'         => 'offer_sent',
            'required_fee'   => $application->course->cost,
        ]);
        return [
            'user' => $user,
            'password' => $password
        ];
    }
}
