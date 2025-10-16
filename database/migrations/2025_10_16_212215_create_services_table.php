<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        /** 
     * Determine if this migration should run.
     */
    public function shouldRun(): bool
    {
        return !Schema::hasTable('services');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->text('long_description')->nullable();
            $table->enum('type', ['package', 'subscription', 'custom', 'one_time', 'ai_enhanced', 'consulting', 'add_on'])->default('package');
            $table->decimal('price', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('billing_interval')->nullable(); // monthly, yearly, one_time
            $table->json('metadata')->nullable();
            $table->boolean('available')->default(true);
            $table->boolean('visible')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
