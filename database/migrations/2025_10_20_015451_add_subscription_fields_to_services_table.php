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
        Schema::table('services', function (Blueprint $table) {
            // Basic subscription configuration
            $table->boolean('is_subscription')->default(false)->after('created_by');
            $table->integer('subscription_duration_months')->nullable()->after('is_subscription');
            $table->boolean('auto_renew_enabled')->default(true)->after('subscription_duration_months');
            
            // Billing terms and policies
            $table->integer('minimum_billing_term_months')->nullable()->after('auto_renew_enabled');
            $table->integer('grace_period_days')->default(0)->after('minimum_billing_term_months');
            $table->boolean('prorated_billing')->default(false)->after('grace_period_days');
            
            // Fees and pricing
            $table->decimal('early_termination_fee', 10, 2)->nullable()->after('prorated_billing');
            $table->decimal('setup_fee', 10, 2)->nullable()->after('early_termination_fee');
            $table->decimal('renewal_discount_percentage', 5, 2)->nullable()->after('setup_fee');
            
            // Policies and configuration
            $table->text('cancellation_policy')->nullable()->after('renewal_discount_percentage');
            $table->json('reminder_schedule')->nullable()->after('cancellation_policy');
            $table->string('custom_expiration_email_template')->nullable()->after('reminder_schedule');
            $table->json('subscription_metadata')->nullable()->after('custom_expiration_email_template');
            
            // Add indexes for subscription queries
            $table->index(['is_subscription', 'available', 'visible']);
            $table->index(['is_subscription', 'auto_renew_enabled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['is_subscription', 'available', 'visible']);
            $table->dropIndex(['is_subscription', 'auto_renew_enabled']);
            
            // Drop subscription fields
            $table->dropColumn([
                'is_subscription',
                'subscription_duration_months',
                'auto_renew_enabled',
                'minimum_billing_term_months',
                'grace_period_days',
                'prorated_billing',
                'early_termination_fee',
                'setup_fee',
                'renewal_discount_percentage',
                'cancellation_policy',
                'reminder_schedule',
                'custom_expiration_email_template',
                'subscription_metadata',
            ]);
        });
    }
};
