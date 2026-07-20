<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Find the unique index on voucher_code
        $indexes = DB::select("
            SHOW INDEX
            FROM vouchers
            WHERE Column_name = 'voucher_code'
        ");

        foreach ($indexes as $index) {
            if ((int) $index->Non_unique === 0) {
                DB::statement("ALTER TABLE vouchers DROP INDEX `{$index->Key_name}`");
            }
        }

        // Change column to TEXT
        DB::statement("
            ALTER TABLE vouchers
            MODIFY voucher_code TEXT NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE vouchers
            MODIFY voucher_code VARCHAR(191) NOT NULL
        ");

        DB::statement("
            ALTER TABLE vouchers
            ADD UNIQUE INDEX voucher_code_unique (voucher_code)
        ");
    }
};