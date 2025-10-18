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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2)->unique(); // ISO 2-letter country code
            $table->string('name');              // Country name
            $table->string('currency_code', 3); // Default currency for this country
            $table->string('region')->nullable(); // Africa, North America, Europe, etc.
            $table->string('phone_code')->nullable(); // +233, +1, etc.
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable(); // Additional country info
            $table->timestamps();
            
            $table->index(['currency_code', 'is_active']);
            $table->index(['region', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
