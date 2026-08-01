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
            $table->enum('exam_mode', ['center', 'online'])
                  ->default('center')
                  ->after('voucher_id');

            $table->unsignedBigInteger('center_id')
                  ->nullable()
                  ->change();

            $table->unsignedBigInteger('center_admin_id')
                  ->nullable()
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_schedules', function (Blueprint $table) {
            $table->dropColumn('exam_mode');

            $table->unsignedBigInteger('center_id')
                  ->nullable(false)
                  ->change();

            $table->unsignedBigInteger('center_admin_id')
                  ->nullable(false)
                  ->change();
        });
    }
};