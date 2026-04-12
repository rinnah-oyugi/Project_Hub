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
            'is_approved' => true,
            'university_id' => 'FAC-CS-001',
            'department' => 'Computer Science',
        ]);

        // 2. Create the Student (Riina)
        User::create([
            'name' => 'Riina Ochieng',
            'email' => 'riina@test.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_approved' => true,
            'university_id' => 'CS-301',
            'department' => 'Computer Science',
            'degree' => 'BSc IT',
            'graduation_year' => '2026',
            'supervisor_id' => $supervisor->id,
            'project_title' => 'Automated Project Management Hub',
            'request_status' => 'pending',
        ]);

        // 3. Create an Admin (Optional)
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_approved' => true,
            'university_id' => 'ADM-001',
            'department' => 'Administration',
        ]);
    }
}