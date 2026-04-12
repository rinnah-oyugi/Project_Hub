<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Students no longer require admin approval; normalize existing rows.
     */
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'student')
            ->update(['is_approved' => true]);
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        // Intentionally empty: we cannot know prior is_approved values.
    }
};
