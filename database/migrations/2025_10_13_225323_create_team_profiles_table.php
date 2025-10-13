<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Determine if the migration should run.
     */
    public function shouldRun(): bool
    {
        return !Schema::hasTable('team_profiles');
    }
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('id_key')->unique(); // Unique identifier for the profile
            $table->string('name');
            $table->string('role');
            $table->string('photo')->nullable(); // Path to photo or font awesome icon class
            $table->json('contact'); // Email, phone, location, social media links
            $table->text('bio');
            $table->json('skills'); // Array of skill categories and their items
            $table->json('experience'); // Array of work experiences
            $table->json('achievements'); // Array of achievements
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_profiles');
    }
};
