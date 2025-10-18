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
        Schema::create('regional_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('currency_id')->constrained()->onDelete('cascade');
            $table->string('country_code', 2)->nullable(); // ISO 2-letter country code
            $table->string('region')->nullable(); // North America, Europe, Africa, etc.
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2); // Original USD price for reference
            $table->decimal('markup_percentage', 5, 2)->default(0); // Additional markup for region
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable(); // Additional pricing rules
            $table->timestamps();
            
            $table->unique(['service_id', 'currency_id', 'country_code']);
            $table->index(['country_code', 'is_active']);
            $table->index(['region', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regional_pricing');
    }
};
