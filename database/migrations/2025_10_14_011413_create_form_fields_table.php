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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // text, textarea, email, select, checkbox, radio, file, etc.
            $table->string('label');
            $table->text('options')->nullable(); // For select, checkbox, radio, etc. - stored as JSON
            $table->text('placeholder')->nullable();
            $table->text('help_text')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_unique')->default(false);
            $table->integer('order')->default(0);
            $table->json('validation_rules')->nullable(); // Store validation rules as JSON
            $table->json('attributes')->nullable(); // Additional HTML attributes as JSON
            $table->timestamps();
        });
    }
    
    /**
     * Determine if the migration should run.
     */
    public function shouldRun(): bool
    {
        return !Schema::hasTable('form_fields');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
