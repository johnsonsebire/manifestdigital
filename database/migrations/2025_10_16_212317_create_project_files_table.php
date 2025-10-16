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
        return !Schema::hasTable('project_files');
    }


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->string('model_type'); // Polymorphic: Project, Task, ProjectMessage
            $table->unsignedBigInteger('model_id');
            $table->foreignId('uploader_id')->constrained('users')->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable(); // in bytes
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_files');
    }
};
