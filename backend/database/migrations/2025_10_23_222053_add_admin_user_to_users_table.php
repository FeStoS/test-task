<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const USERS_TABLE_NAME = 'users';
    protected const ROLES_TABLE_NAME = 'roles';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::USERS_TABLE_NAME, function (Blueprint $table) {
            $email = 'admin@mail.com';
            $id = DB::table('users')->where('email', $email)->value('id')
                ?? DB::table('users')->insertGetId([
                    'first_name' => 'Adminskiy',
                    'last_name' => 'Admin',
                    'middle_name' => 'Adminovich',
                    'email' => $email,
                    'password' => Hash::make('admin1111'),
                    'role_id' => 1,
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(self::USERS_TABLE_NAME, function (Blueprint $table) {
            //
        });
    }
};
