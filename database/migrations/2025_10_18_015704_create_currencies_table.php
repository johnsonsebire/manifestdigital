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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // USD, GHS, EUR, etc.
            $table->string('name'); // US Dollar, Ghana Cedi, etc.
            $table->string('symbol', 10); // $, ₵, €, etc.
            $table->decimal('exchange_rate_to_usd', 12, 6)->default(1); // Current rate to USD
            $table->boolean('is_base_currency')->default(false); // USD will be true
            $table->boolean('is_active')->default(true);
            $table->integer('decimal_places')->default(2);
            $table->string('format')->nullable(); // e.g., '$1,234.56' or '₵1,234.56'
            $table->json('metadata')->nullable(); // Additional currency info
            $table->timestamp('exchange_rate_updated_at')->nullable();
            $table->timestamps();
            
            $table->index(['is_active', 'code']);
            $table->index('is_base_currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
