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
        Schema::table('invoices', function (Blueprint $table) {
            // Add currency support
            $table->foreignId('currency_id')->nullable()->after('customer_id')->constrained()->onDelete('restrict');
            $table->string('currency_code', 3)->nullable()->after('currency_id'); // Store currency code for historical reference
            $table->decimal('exchange_rate', 10, 6)->nullable()->after('currency_code'); // Exchange rate at time of invoice creation
            
            // Deprecate single tax fields (keep for backwards compatibility)
            $table->decimal('tax_rate', 5, 2)->nullable()->change();
            $table->decimal('tax_amount', 10, 2)->nullable()->change();
            
            // Add new calculated fields for multi-tax support
            $table->decimal('total_tax_amount', 10, 2)->default(0)->after('tax_amount');
            $table->json('tax_breakdown')->nullable()->after('total_tax_amount'); // Store tax calculation details
            
            // Add region information for tax calculation
            $table->string('billing_country_code', 2)->nullable()->after('client_address');
            $table->string('billing_region')->nullable()->after('billing_country_code');
            
            $table->index(['currency_id', 'billing_country_code']);
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropColumn([
                'currency_id',
                'currency_code', 
                'exchange_rate',
                'total_tax_amount',
                'tax_breakdown',
                'billing_country_code',
                'billing_region'
            ]);
            
            // Restore original tax fields
            $table->decimal('tax_rate', 5, 2)->nullable(false)->change();
            $table->decimal('tax_amount', 10, 2)->nullable(false)->change();
        });
    }
};
