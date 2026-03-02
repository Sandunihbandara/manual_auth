<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('maintenance_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();

            $table->dateTime('starts_at');
            $table->dateTime('ends_at');

            $table->string('type')->default('maintenance'); // calibration/repair/etc
            $table->enum('status', ['scheduled','in_progress','completed','cancelled'])->default('scheduled');

            $table->dateTime('remind_at')->nullable();
            $table->boolean('reminded')->default(false);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['instrument_id', 'status']);
            $table->index(['starts_at', 'ends_at']);
            $table->index(['remind_at', 'reminded']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};