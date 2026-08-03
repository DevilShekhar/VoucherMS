<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voucher_requests', function (Blueprint $table) {
            $table->foreignId('approved_by')
                ->nullable()
                ->after('superadmin_approval')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('voucher_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('approved_by');
        });
    }
};
