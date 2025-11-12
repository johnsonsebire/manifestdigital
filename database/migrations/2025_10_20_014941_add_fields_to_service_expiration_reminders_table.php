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
            // Check if columns exist before adding them
            if (!Schema::hasColumn('service_expiration_reminders', 'service_id')) {
                $table->foreignId('service_id')->constrained()->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('service_expiration_reminders', 'customer_id')) {
                $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('cascade');
            }
            
            // Reminder configuration
            if (!Schema::hasColumn('service_expiration_reminders', 'reminder_days_before')) {
                $table->json('reminder_days_before')->nullable(); // Days before expiration
            }
            
            if (!Schema::hasColumn('service_expiration_reminders', 'email_template')) {
                $table->string('email_template')->nullable(); // Custom template override
            }
            
            if (!Schema::hasColumn('service_expiration_reminders', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            
            // Custom schedule support
            if (!Schema::hasColumn('service_expiration_reminders', 'custom_schedule')) {
                $table->json('custom_schedule')->nullable(); // For complex reminder schedules
            }
            
            if (!Schema::hasColumn('service_expiration_reminders', 'custom_message')) {
                $table->text('custom_message')->nullable(); // Custom reminder message
            }
            
            // Metadata for additional configuration
            if (!Schema::hasColumn('service_expiration_reminders', 'metadata')) {
                $table->json('metadata')->nullable();
            }
        });
        
        // Add indexes and constraints separately after ensuring columns exist
        try {
            Schema::table('service_expiration_reminders', function (Blueprint $table) {
                $table->index(['service_id', 'is_active']);
            });
        } catch (\Exception $e) {
            // Index already exists, skip
        }
        
        try {
            Schema::table('service_expiration_reminders', function (Blueprint $table) {
                $table->index(['customer_id', 'is_active']);
            });
        } catch (\Exception $e) {
            // Index already exists, skip
        }
        
        try {
            Schema::table('service_expiration_reminders', function (Blueprint $table) {
                $table->unique(['service_id', 'customer_id']);
            });
        } catch (\Exception $e) {
            // Unique constraint already exists, skip
        }
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
