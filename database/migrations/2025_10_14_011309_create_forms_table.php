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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('success_message')->nullable();
            $table->string('submit_button_text')->default('Submit');
            $table->boolean('store_submissions')->default(true);
            $table->boolean('send_notifications')->default(false);
            $table->string('notification_email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_login')->default(false);
            $table->string('recaptcha_status')->default('disabled');
            $table->string('shortcode')->unique();
            $table->timestamps();
        });
    }
    
    /**
     * Determine if the migration should run.
     */
    public function shouldRun(): bool
    {
        return !Schema::hasTable('forms');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
