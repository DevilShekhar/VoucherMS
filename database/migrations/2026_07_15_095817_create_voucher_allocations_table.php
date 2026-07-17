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
        Schema::create('voucher_allocations', function (Blueprint $table) {

            $table->id();
            $table->foreignId('voucher_id')
                ->constrained('vouchers')
                ->cascadeOnDelete();

            $table->foreignId('request_id')
                ->constrained('voucher_requests')
                ->cascadeOnDelete();

            $table->foreignId('candidate_id')
                ->constrained('candidates')
                ->cascadeOnDelete();

            $table->foreignId('allocated_to')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('allocated_date');
            $table->date('used_date')->nullable();
            $table->enum('status', [
                'Allocated',
                'Used',
                'Expired',
                'Cancelled'
            ])->default('Allocated');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_allocations');
    }
};
