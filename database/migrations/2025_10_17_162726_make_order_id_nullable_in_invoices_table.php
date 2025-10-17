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
            $table->foreignId('order_id')->nullable()->change();
            
            // Add fields for manual invoices (non-registered clients)
            $table->string('client_name')->nullable()->after('customer_id');
            $table->string('client_email')->nullable()->after('client_name');
            $table->string('client_phone')->nullable()->after('client_email');
            $table->text('client_address')->nullable()->after('client_phone');
            $table->string('client_company')->nullable()->after('client_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable(false)->change();
            
            $table->dropColumn([
                'client_name',
                'client_email',
                'client_phone',
                'client_address',
                'client_company',
            ]);
        });
    }
};