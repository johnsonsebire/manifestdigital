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
        Schema::table('invoices', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['customer_id']);
            
            // Make customer_id nullable
            $table->foreignId('customer_id')->nullable()->change();
            
            // Re-add the foreign key constraint (nullable)
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['customer_id']);
            
            // Make customer_id not nullable again
            $table->foreignId('customer_id')->nullable(false)->change();
            
            // Re-add the foreign key constraint (not nullable)
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }
};
