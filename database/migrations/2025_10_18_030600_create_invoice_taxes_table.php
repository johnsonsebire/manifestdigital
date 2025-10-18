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
        Schema::create('invoice_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('tax_id')->constrained()->onDelete('cascade');
            $table->decimal('tax_rate', 5, 2); // Tax rate at time of invoice creation
            $table->decimal('taxable_amount', 10, 2); // Amount this tax applies to
            $table->decimal('tax_amount', 10, 2); // Calculated tax amount
            $table->boolean('is_inclusive')->default(false); // Whether tax was included in price
            $table->json('metadata')->nullable(); // Store tax calculation details
            $table->timestamps();
            
            $table->unique(['invoice_id', 'tax_id']);
            $table->index('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_taxes');
    }
};
