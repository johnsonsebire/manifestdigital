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
            // Check if the column doesn't already exist
            if (!Schema::hasColumn('invoices', 'additional_fees')) {
                $table->decimal('additional_fees', 10, 2)->default(0)->after('discount_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'additional_fees')) {
                $table->dropColumn('additional_fees');
            }
        });
    }
};
