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
        return !Schema::hasTable('order_change_requests');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_change_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['upgrade', 'downgrade', 'custom_change'])->default('upgrade');
            $table->json('old_snapshot')->nullable();
            $table->json('new_snapshot')->nullable();
            $table->decimal('proposed_amount', 12, 2)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'applied'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_change_requests');
    }
};
