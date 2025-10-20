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
        Schema::table('service_expiration_reminders', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // Reminder configuration
            $table->json('reminder_days_before')->default('[15, 10, 5, 0]'); // Days before expiration
            $table->string('email_template')->nullable(); // Custom template override
            $table->boolean('is_active')->default(true);
            
            // Custom schedule support
            $table->json('custom_schedule')->nullable(); // For complex reminder schedules
            $table->text('custom_message')->nullable(); // Custom reminder message
            
            // Metadata for additional configuration
            $table->json('metadata')->nullable();
            
            // Indexes for performance
            $table->index(['service_id', 'is_active']);
            $table->index(['customer_id', 'is_active']);
            
            // Unique constraint: one reminder config per service per customer
            $table->unique(['service_id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_expiration_reminders', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropForeign(['customer_id']);
            $table->dropUnique(['service_id', 'customer_id']);
            $table->dropIndex(['service_id', 'is_active']);
            $table->dropIndex(['customer_id', 'is_active']);
            $table->dropColumn([
                'service_id', 'customer_id', 'reminder_days_before', 
                'email_template', 'is_active', 'custom_schedule', 
                'custom_message', 'metadata'
            ]);
        });
    }
};
