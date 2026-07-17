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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->string('certification_code')->unique();
            $table->string('certification_name');

            $table->string('vendor')->nullable();

            $table->integer('validity_months')->nullable()
                ->comment('Certificate validity in months');

            $table->integer('exam_duration')->nullable()
                ->comment('Exam duration in minutes');

            $table->integer('passing_marks')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
