<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_category', function (Blueprint $table) {

            $table->foreign('created_by', 'fk_course_category_created_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by', 'fk_course_category_updated_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('course_category', function (Blueprint $table) {

            $table->dropForeign('fk_course_category_created_by');
            $table->dropForeign('fk_course_category_updated_by');

        });
    }
};