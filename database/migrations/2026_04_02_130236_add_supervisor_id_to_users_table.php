<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('student'); 
            }
            if (!Schema::hasColumn('users', 'is_approved')) {
                $table->boolean('is_approved')->default(0); 
            }
            if (!Schema::hasColumn('users', 'supervisor_id')) {
                $table->foreignId('supervisor_id')->nullable()->constrained('users')->onDelete('set null');
            }
            
            // Adding checks to the rest of the columns to prevent the "Duplicate Column" error
            if (!Schema::hasColumn('users', 'project_description')) {
                $table->text('project_description')->nullable();
            }
            if (!Schema::hasColumn('users', 'request_status')) {
                $table->string('request_status')->default('none'); 
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'office_location')) {
                $table->string('office_location')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Always drop the Foreign Key BEFORE the column
            $table->dropForeign(['supervisor_id']);

            $table->dropColumn([
                'role',
                'is_approved',
                'supervisor_id', 
                'project_title', 
                'project_description', 
                'request_status',
                'phone_number',
                'office_location'
            ]);
        });
    }
};