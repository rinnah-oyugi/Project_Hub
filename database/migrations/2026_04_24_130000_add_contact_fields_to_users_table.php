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
            $table->string('phone')->nullable()->after('department');
            $table->text('address')->nullable()->after('phone');
            $table->string('emergency_contact')->nullable()->after('address');
            $table->string('emergency_phone')->nullable()->after('emergency_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'address', 
                'emergency_contact',
                'emergency_phone'
            ]);
        });
    }
};
