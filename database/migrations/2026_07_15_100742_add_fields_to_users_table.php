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
        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('role_id')
                ->nullable()
                ->after('id')
                ->constrained('roles')
                ->nullOnDelete();

            $table->foreignId('center_id')
                ->nullable()
                ->after('role_id')
                ->constrained('centers')
                ->nullOnDelete();

            $table->string('employee_code')
                ->nullable()
                ->unique()
                ->after('center_id');

            $table->string('mobile', 20)
                ->nullable()
                ->after('email');

            $table->string('profile_photo')
                ->nullable()
                ->after('password');

            $table->boolean('status')
                ->default(true)
                ->after('profile_photo');

            $table->timestamp('last_login')
                ->nullable()
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['role_id']);
            $table->dropForeign(['center_id']);

            $table->dropColumn([
                'role_id',
                'center_id',
                'employee_code',
                'mobile',
                'profile_photo',
                'status',
                'last_login'
            ]);
        });
    }
};
