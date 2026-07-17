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
        Schema::create('vouchers', function (Blueprint $table) {

            $table->id();

            $table->string('voucher_code')->unique();

            $table->foreignId('vendor_id')
                ->constrained('voucher_vendors')
                ->cascadeOnDelete();

            $table->foreignId('certification_id')
                ->constrained('certifications')
                ->cascadeOnDelete();
            $table->date('purchase_date');
            $table->date('expiry_date')->nullable();
            $table->decimal('purchase_price',10,2);
            $table->decimal('cost',10,2);
            $table->enum('status',[
                'Available',
                'Allocated',
                'Used',
                'Expired',
                'Cancelled'
            ])->default('Available');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
