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
            $table->text('proposal_student_comment')->nullable()->after('project_description');
            $table->text('proposal_supervisor_comment')->nullable()->after('proposal_student_comment');
            $table->enum('proposal_status', ['pending', 'approved', 'rejected'])->default('pending')->after('proposal_supervisor_comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['proposal_student_comment', 'proposal_supervisor_comment', 'proposal_status']);
        });
    }
};
