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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            
            // Subscription timeline
            $table->datetime('starts_at');
            $table->datetime('expires_at');
            $table->datetime('next_billing_date')->nullable();
            $table->datetime('current_period_start');
            $table->datetime('current_period_end');
            
            // Billing configuration
            $table->enum('billing_interval', ['monthly', 'yearly', 'one_time'])->default('monthly');
            $table->integer('minimum_term_months')->nullable();
            $table->decimal('renewal_price', 12, 2)->nullable();
            $table->decimal('renewal_discount_percentage', 5, 2)->default(0);
            
            // Subscription control
            $table->boolean('auto_renew')->default(true);
            $table->enum('status', ['active', 'expired', 'cancelled', 'pending_renewal', 'suspended', 'trial'])->default('active');
            $table->datetime('trial_ends_at')->nullable();
            $table->datetime('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            
            // Custom arrangements
            $table->json('custom_billing_terms')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['customer_id', 'status']);
            $table->index(['expires_at', 'status']);
            $table->index(['next_billing_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
