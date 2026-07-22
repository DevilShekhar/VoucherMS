<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('centers', function (Blueprint $table) {
            $table->renameColumn('manager_id', 'center_exe_id');
        });
    }

    public function down(): void
    {
        Schema::table('centers', function (Blueprint $table) {
            $table->renameColumn('center_exe_id', 'manager_id');
        });
    }
};
