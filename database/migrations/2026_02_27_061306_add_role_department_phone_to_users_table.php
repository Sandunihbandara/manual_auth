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
        $table->string('role')->default('user');           // user | staff
        $table->string('department')->nullable();          // ICT | IAT | ET | AT
        $table->string('phone', 20)->nullable();           // contact number
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'department', 'phone']);
    });
}

    
    
};
