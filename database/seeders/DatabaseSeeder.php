<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create the Supervisor (Dr. Smith)
        $supervisor = User::create([
            'name' => 'Dr. Smith',
            'email' => 'supervisor@test.com',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'is_approved' => true, // So they show up in the student's dropdown
            'department' => 'Computer Science',
        ]);

        // 2. Create the Student (Riina)
        User::create([
            'name' => 'Riina Ochieng',
            'email' => 'riina@test.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'university_id' => 'CS-301',
            'department' => 'Computer Science',
            'degree' => 'BSc IT',
            'graduation_year' => '2026',
            'supervisor_id' => $supervisor->id, // Automatically link to Dr. Smith
            'project_title' => 'Automated Project Management Hub',
            'request_status' => 'pending', // Starts in the Amber state
        ]);

        // 3. Create an Admin (Optional)
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}