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
        Schema::create('currency_exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('from_currency', 3); // e.g., USD
            $table->string('to_currency', 3);   // e.g., GHS
            $table->decimal('rate', 12, 6);     // Exchange rate
            $table->string('source')->default('manual'); // manual, api, etc.
            $table->date('rate_date');          // Date this rate is for
            $table->timestamp('fetched_at')->nullable(); // When rate was fetched
            $table->json('metadata')->nullable(); // Source info, confidence, etc.
            $table->timestamps();
            
            $table->unique(['from_currency', 'to_currency', 'rate_date'], 'currency_rates_unique');
            $table->index(['from_currency', 'to_currency']);
            $table->index('rate_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_exchange_rates');
    }
};
