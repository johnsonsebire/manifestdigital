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
        return !Schema::hasTable('service_price_histories');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_price_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->decimal('old_price', 12, 2);
            $table->decimal('new_price', 12, 2);
            $table->string('currency', 3);
            $table->text('reason')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_price_histories');
    }
};
