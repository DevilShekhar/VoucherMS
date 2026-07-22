<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Adds location_id after 'mobile' column and sets up the foreign key constraint
            $table->foreignId('location_id')
                  ->nullable()
                  ->after('mobile')
                  ->constrained('locations') // Assumes target table is 'locations'
                  ->nullOnDelete();          // Sets to NULL if the location is deleted
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drops foreign key first, then the column
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }
};