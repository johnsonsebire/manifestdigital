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
        Schema::create('expiration_reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
            
            // Reminder details
            $table->enum('reminder_type', ['15_days', '10_days', '5_days', '1_day', 'expired'])->index();
            $table->datetime('sent_at');
            $table->string('email_template_used');
            $table->string('recipient_email');
            
            // Delivery tracking
            $table->enum('status', ['sent', 'failed', 'bounced', 'delivered', 'opened', 'clicked'])->default('sent');
            $table->text('error_message')->nullable();
            $table->string('email_provider_id')->nullable(); // For tracking with email services
            
            // Additional metadata
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['subscription_id', 'reminder_type']);
            $table->index(['sent_at']);
            $table->index(['status']);
            
            // Prevent duplicate reminders for same subscription/type combination
            $table->unique(['subscription_id', 'reminder_type'], 'unique_subscription_reminder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expiration_reminder_logs');
    }
};
