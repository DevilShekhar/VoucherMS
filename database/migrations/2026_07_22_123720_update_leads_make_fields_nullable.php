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
        Schema::table('leads', function (Blueprint $table) {

            $table->foreignId('center_id')
                ->nullable()
                ->change();

            $table->foreignId('course_id')
                ->nullable()
                ->change();

            $table->string('candidate_name')
                ->nullable()
                ->change();

            $table->string('email')
                ->nullable()
                ->change();

            $table->string('company')
                ->nullable()
                ->change();

            $table->string('city')
                ->nullable()
                ->change();

            $table->string('priority')
                ->nullable()
                ->default('Medium')
                ->change();

            $table->text('remarks')
                ->nullable()
                ->change();

            $table->foreignId('assigned_to')
                ->nullable()
                ->change();

            $table->string('other_course_name')
                ->nullable()
                ->after('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {

            $table->foreignId('center_id')
                ->nullable(false)
                ->change();

            $table->foreignId('course_id')
                ->nullable(false)
                ->change();

            $table->string('candidate_name')
                ->nullable(false)
                ->change();

            $table->string('email')
                ->nullable()
                ->change();

            $table->string('company')
                ->nullable()
                ->change();

            $table->string('city')
                ->nullable()
                ->change();

            $table->string('priority')
                ->default('Medium')
                ->nullable(false)
                ->change();

            $table->text('remarks')
                ->nullable()
                ->change();

            $table->foreignId('assigned_to')
                ->nullable()
                ->change();

            $table->dropColumn('other_course_name');
        });
    }
};
