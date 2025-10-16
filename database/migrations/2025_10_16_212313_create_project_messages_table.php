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
        return !Schema::hasTable('project_messages');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->boolean('is_internal')->default(false); // false = client-visible, true = staff-only
            $table->json('read_by')->nullable(); // Array of user IDs who have read the message
            $table->json('metadata')->nullable(); // AI draft flag, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_messages');
    }
};
