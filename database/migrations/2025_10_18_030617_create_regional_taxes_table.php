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
        Schema::create('regional_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_id')->constrained()->onDelete('cascade');
            $table->foreignId('currency_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('country_code', 2)->nullable(); // ISO country code (e.g., 'GH', 'US')
            $table->string('region')->nullable(); // Region name (e.g., 'West Africa', 'Europe')
            $table->decimal('rate_override', 5, 2)->nullable(); // Override tax rate for this region
            $table->boolean('is_applicable')->default(true); // Whether this tax applies in this region
            $table->boolean('is_inclusive')->nullable(); // Override inclusive setting for this region
            $table->integer('priority')->default(0); // For conflict resolution (higher wins)
            $table->json('conditions')->nullable(); // Additional conditions for tax application
            $table->json('metadata')->nullable(); // Store additional regional tax info
            $table->timestamps();
            
            // Ensure unique combinations
            $table->unique(['tax_id', 'country_code', 'currency_id'], 'regional_taxes_unique_combination');
            $table->index(['country_code', 'is_applicable']);
            $table->index(['region', 'is_applicable']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regional_taxes');
    }
};
