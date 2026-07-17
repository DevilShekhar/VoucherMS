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
        Schema::create('exam_schedules', function (Blueprint $table) {

            $table->id();
            $table->foreignId('candidate_id')
                ->constrained('candidates')
                ->cascadeOnDelete();
            $table->foreignId('center_id')
                ->constrained('centers')
                ->cascadeOnDelete();
            $table->foreignId('certification_id')
                ->constrained('certifications')
                ->cascadeOnDelete();
            $table->foreignId('voucher_id')
                ->nullable()
                ->constrained('vouchers')
                ->nullOnDelete();
            $table->date('exam_date');
            $table->time('exam_time');
            $table->enum('exam_status', [
                'Scheduled',
                'Rescheduled',
                'Completed',
                'Cancelled',
                'Absent',
            ])->default('Scheduled');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_schedules');
    }
};
