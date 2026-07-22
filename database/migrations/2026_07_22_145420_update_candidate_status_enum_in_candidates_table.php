<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE candidates
            MODIFY COLUMN status ENUM(
                'Active',
                'Exam Scheduled',
                'Completed',
                'Cancelled',
                'Inactive'
            ) NOT NULL DEFAULT 'Active'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE candidates
            MODIFY COLUMN status ENUM(
                'Active',
                'Completed',
                'Cancelled',
                'Inactive'
            ) NOT NULL DEFAULT 'Active'
        ");
    }
};