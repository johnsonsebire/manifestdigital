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
        Schema::create('team_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('id_key')->unique();
            $table->string('name');
            $table->string('role');
            $table->string('photo')->nullable();
            $table->json('contact')->nullable();
            $table->text('bio');
            $table->json('skills')->nullable();
            $table->json('experience')->nullable();
            $table->json('achievements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }
    
    /**
     * Determine if the migration should run.
     */
    public function shouldRun(): bool
    {
        return !Schema::hasTable('team_profiles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_profiles');
    }
};
