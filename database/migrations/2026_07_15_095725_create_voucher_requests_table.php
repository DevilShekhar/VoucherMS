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
        Schema::create('voucher_requests', function (Blueprint $table) {

            $table->id();

            $table->string('request_no')->unique();
            $table->foreignId('candidate_id')
                ->constrained('candidates')
                ->cascadeOnDelete();

            $table->foreignId('certification_id')
                ->constrained('certifications')
                ->cascadeOnDelete();

            $table->foreignId('requested_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('center_id')
                ->constrained('centers')
                ->cascadeOnDelete();

            $table->enum('status', [
                'Pending',
                'Approved',
                'Rejected',
                'Allocated'
            ])->default('Pending');

            $table->enum('admin_approval', [
                'Pending',
                'Approved',
                'Rejected'
            ])->default('Pending');

            $table->enum('superadmin_approval', [
                'Pending',
                'Approved',
                'Rejected'
            ])->default('Pending');

            $table->text('remarks')->nullable();
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_requests');
    }
};
