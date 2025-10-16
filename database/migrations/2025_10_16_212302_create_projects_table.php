<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Determine if this migration should run.
     */
    public function shouldRun(): bool
    {
        return !Schema::hasTable('projects');
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['planning', 'in_progress', 'on_hold', 'complete', 'archived'])->default('planning');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('deadline')->nullable();
            $table->decimal('estimated_hours', 8, 2)->nullable();
            $table->decimal('spent_hours', 8, 2)->default(0);
            $table->enum('visibility', ['private', 'client', 'public'])->default('client');
            $table->json('settings')->nullable(); // AI automation flags, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
