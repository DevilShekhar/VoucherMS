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
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('candidate_id')
                ->constrained('candidates')
                ->cascadeOnDelete();

            $table->string('invoice_no')->unique();
            $table->date('invoice_date');
            $table->enum('gst_type', [
                'CGST_SGST',
                'IGST',
                'No GST'
            ])->default('No GST');
            $table->decimal('total_amount', 10, 2);

            $table->enum('status', [
                'Draft',
                'Generated',
                'Paid',
                'Cancelled'
            ])->default('Draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
