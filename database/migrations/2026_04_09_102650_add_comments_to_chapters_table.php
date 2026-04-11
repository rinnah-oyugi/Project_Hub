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
        // Only add if it doesn't exist
        if (!Schema::hasColumn('users', 'project_title')) {
            $table->string('project_title')->nullable();
        }
        
        if (!Schema::hasColumn('users', 'supervisor_id')) {
            $table->foreignId('supervisor_id')->nullable()->constrained('users');
        }
        
        if (!Schema::hasColumn('users', 'request_status')) {
            $table->string('request_status')->default('none');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chapters', function (Blueprint $table) {
            //
        });
    }
};
