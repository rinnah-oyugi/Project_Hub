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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('student');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // --- FIGMA REGISTRATION FIELDS ---
            $table->string('university_id')->nullable();
            $table->string('department')->nullable();
            $table->string('degree')->nullable();
            $table->string('graduation_year')->nullable();

            // --- PROJECT HUB FIELDS ---
            // Stores which supervisor the student chose
            $table->unsignedBigInteger('supervisor_id')->nullable(); 
            $table->string('project_title')->nullable();
            $table->text('project_description')->nullable();
            
            // Status can be: none, pending, approved, or declined
            $table->string('request_status')->default('none');
            
            // Used to approve supervisor accounts
            $table->boolean('is_approved')->default(false);

            $table->rememberToken();
            $table->timestamps();
            
            // Foreign key link (optional but pro)
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};