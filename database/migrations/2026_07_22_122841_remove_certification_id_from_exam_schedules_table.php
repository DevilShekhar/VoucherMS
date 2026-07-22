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
        Schema::table('exam_schedules', function (Blueprint $table) {

            // Drop foreign key first (if exists)
            $table->dropForeign(['certification_id']);

            // Remove column
            $table->dropColumn('certification_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_schedules', function (Blueprint $table) {

            $table->foreignId('certification_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();
        });
    }
};