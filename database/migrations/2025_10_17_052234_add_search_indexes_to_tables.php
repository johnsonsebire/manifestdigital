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
        // Add indexes to orders table for search optimization
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!$this->indexExists('orders', 'orders_payment_status_index')) {
                    $table->index('payment_status');
                }
                if (!$this->indexExists('orders', 'orders_customer_id_status_index')) {
                    $table->index(['customer_id', 'status']);
                }
            });
        }

        // Add indexes to projects table
        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $table) {
                if (!$this->indexExists('projects', 'projects_start_date_index')) {
                    $table->index('start_date');
                }
                if (!$this->indexExists('projects', 'projects_end_date_index')) {
                    $table->index('end_date');
                }
                if (!$this->indexExists('projects', 'projects_client_id_status_index')) {
                    $table->index(['client_id', 'status']);
                }
            });
        }

        // Add indexes to form_submissions table
        if (Schema::hasTable('form_submissions')) {
            Schema::table('form_submissions', function (Blueprint $table) {
                if (!$this->indexExists('form_submissions', 'form_submissions_form_id_created_at_index')) {
                    $table->index(['form_id', 'created_at']);
                }
            });
        }

        // Add indexes to services table
        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                if (!$this->indexExists('services', 'services_is_visible_is_available_index')) {
                    $table->index(['is_visible', 'is_available']);
                }
            });
        }
    }

    /**
     * Check if an index exists on a table
     */
    protected function indexExists(string $table, string $index): bool
    {
        $connection = Schema::getConnection();
        $databaseName = $connection->getDatabaseName();
        
        $result = $connection->select(
            "SELECT COUNT(*) as count FROM information_schema.statistics 
             WHERE table_schema = ? AND table_name = ? AND index_name = ?",
            [$databaseName, $table, $index]
        );
        
        return $result[0]->count > 0;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from orders table
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if ($this->indexExists('orders', 'orders_payment_status_index')) {
                    $table->dropIndex(['payment_status']);
                }
                if ($this->indexExists('orders', 'orders_customer_id_status_index')) {
                    $table->dropIndex(['customer_id', 'status']);
                }
            });
        }

        // Drop indexes from projects table
        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $table) {
                if ($this->indexExists('projects', 'projects_start_date_index')) {
                    $table->dropIndex(['start_date']);
                }
                if ($this->indexExists('projects', 'projects_end_date_index')) {
                    $table->dropIndex(['end_date']);
                }
                if ($this->indexExists('projects', 'projects_client_id_status_index')) {
                    $table->dropIndex(['client_id', 'status']);
                }
            });
        }

        // Drop indexes from form_submissions table
        if (Schema::hasTable('form_submissions')) {
            Schema::table('form_submissions', function (Blueprint $table) {
                if ($this->indexExists('form_submissions', 'form_submissions_form_id_created_at_index')) {
                    $table->dropIndex(['form_id', 'created_at']);
                }
            });
        }

        // Drop indexes from services table
        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                if ($this->indexExists('services', 'services_is_visible_is_available_index')) {
                    $table->dropIndex(['is_visible', 'is_available']);
                }
            });
        }
    }
};
