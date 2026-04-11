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
    Schema::create('chapters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The Student
        $table->string('chapter_name'); // e.g., "Chapter 1: Introduction"
        $table->string('file_path'); // Path to the PDF/Word doc
        $table->text('student_comment')->nullable();
        $table->text('supervisor_comment')->nullable();
        $table->enum('status', ['pending', 'revision_requested', 'approved'])->default('pending');
        $table->timestamps();
    });
    }   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }

};
