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
        Schema::create('renewals', function (Blueprint $table) {

            $table->id();
            $table->foreignId('candidate_id')
                ->constrained('candidates')
                ->cascadeOnDelete();

            $table->foreignId('certification_id')
                ->constrained('certifications')
                ->cascadeOnDelete();

            $table->date('expiry_date');
            $table->boolean('reminder_30_sent')->default(false);
            $table->boolean('reminder_15_sent')->default(false);
            $table->boolean('reminder_7_sent')->default(false);
            $table->enum('renewal_status', [
                'Pending',
                'Reminder Sent',
                'Renewed',
                'Expired',
                'Cancelled'
            ])->default('Pending');
            $table->date('next_followup')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewals');
    }
};
