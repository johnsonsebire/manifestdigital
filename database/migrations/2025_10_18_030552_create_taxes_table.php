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
        if (!Schema::hasTable('taxes')) {
            Schema::create('taxes', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // e.g., "VAT", "GST", "Sales Tax"
                $table->string('code')->unique(); // e.g., "VAT", "GST", "ST"
                $table->decimal('rate', 5, 2); // Tax rate percentage (e.g., 15.00 for 15%)
                $table->enum('type', ['percentage', 'fixed'])->default('percentage');
                $table->decimal('fixed_amount', 10, 2)->nullable(); // For fixed amount taxes
                $table->string('description')->nullable();
                $table->boolean('is_inclusive')->default(false); // Whether tax is included in price
                $table->boolean('is_active')->default(true);
                $table->boolean('is_default')->default(false); // Whether this tax applies by default
                $table->integer('sort_order')->default(0); // For display ordering
                $table->json('metadata')->nullable(); // Additional configuration
                $table->timestamps();
                
                $table->index(['is_active', 'is_default']);
                $table->index('sort_order');
            });
        } else {
            // Table exists, check and add missing columns
            Schema::table('taxes', function (Blueprint $table) {
                if (!Schema::hasColumn('taxes', 'name')) {
                    $table->string('name');
                }
                if (!Schema::hasColumn('taxes', 'code')) {
                    $table->string('code')->unique();
                }
                if (!Schema::hasColumn('taxes', 'rate')) {
                    $table->decimal('rate', 5, 2);
                }
                if (!Schema::hasColumn('taxes', 'type')) {
                    $table->enum('type', ['percentage', 'fixed'])->default('percentage');
                }
                if (!Schema::hasColumn('taxes', 'fixed_amount')) {
                    $table->decimal('fixed_amount', 10, 2)->nullable();
                }
                if (!Schema::hasColumn('taxes', 'description')) {
                    $table->string('description')->nullable();
                }
                if (!Schema::hasColumn('taxes', 'is_inclusive')) {
                    $table->boolean('is_inclusive')->default(false);
                }
                if (!Schema::hasColumn('taxes', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
                if (!Schema::hasColumn('taxes', 'is_default')) {
                    $table->boolean('is_default')->default(false);
                }
                if (!Schema::hasColumn('taxes', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (!Schema::hasColumn('taxes', 'metadata')) {
                    $table->json('metadata')->nullable();
                }
            });

            // Add indexes if they don't exist
            $indexNames = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableIndexes('taxes');
            
            if (!isset($indexNames['taxes_is_active_is_default_index'])) {
                Schema::table('taxes', function (Blueprint $table) {
                    $table->index(['is_active', 'is_default']);
                });
            }
            
            if (!isset($indexNames['taxes_sort_order_index'])) {
                Schema::table('taxes', function (Blueprint $table) {
                    $table->index('sort_order');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
