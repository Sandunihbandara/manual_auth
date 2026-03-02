<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('department'); // ICT/IAT/ET/AT
            $table->enum('status', ['available','unavailable','maintenance'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['department', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};