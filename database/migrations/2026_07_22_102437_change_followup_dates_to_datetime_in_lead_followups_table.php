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
        Schema::table('lead_followups', function (Blueprint $table) {
            $table->dateTime('followup_date')->change();
            $table->dateTime('next_followup')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('lead_followups', function (Blueprint $table) {
            $table->date('followup_date')->change();
            $table->date('next_followup')->nullable()->change();
        });
    }
};
