<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GenerateTestStudents extends Command
{
    protected $signature = 'students:generate {count=10 : Number of students} {--program= : Program code}';
    protected $description = 'Generate dummy student accounts for testing';

    public function handle()
    {
        $count = $this->argument('count');
        $program = $this->option('program');

        $this->info("🎓 Generating $count test students...");

        for ($i = 0; $i < $count; $i++) {
            $prog = $program ?? ['BLD', 'DCE', 'DEP', 'ARCH', 'ICT'][array_rand(['BLD', 'DCE', 'DEP', 'ARCH', 'ICT'])];
            $year = rand(2022, 2025);
            $num = str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
            
            $student = User::factory()->student()->create([
                'code' => "{$year}/{$prog}/{$num}",
            ]);

            if (method_exists($student, 'assignRole')) {
                $student->assignRole('student');
            }
        }

        $this->info("✅ Created $count students!");
        $this->newLine();
        $this->info("🔑 Login Credentials:");
        $this->info("   Email: firstname.surname@kihbt.ac.ke");
        $this->info("   Password: Student@2024");
        $this->newLine();
        
        // Show 3 sample students
        $this->info("📋 Sample Students:");
        User::where('userrole', 'student')
            ->latest()
            ->take(3)
            ->get()
            ->each(function ($s) {
                $this->line("   • {$s->email} | Code: {$s->code}");
            });

        return Command::SUCCESS;
    }
}