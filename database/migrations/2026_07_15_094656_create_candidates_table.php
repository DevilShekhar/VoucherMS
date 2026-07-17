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
        Schema::create('candidates', function (Blueprint $table) {

            $table->id();

            $table->string('candidate_code')->unique();

            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            $table->foreignId('center_id')
                ->nullable()
                ->constrained('centers')
                ->nullOnDelete();

            $table->foreignId('executive_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('course_id')
                ->nullable()
                ->constrained('courses')
                ->nullOnDelete();

            $table->foreignId('certification_id')
                ->nullable()
                ->constrained('certifications')
                ->nullOnDelete();

            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('mobile', 20);
            $table->string('company')->nullable();
            $table->string('gst_number', 30)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->enum('status', [
                'Active',
                'Inactive',
                'Completed',
                'Cancelled'
            ])->default('Active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
