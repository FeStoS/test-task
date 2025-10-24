<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected const TABLE_NAME = 'roles';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            DB::table(self::TABLE_NAME)->insert([
                ['name' => 'admin', 'created_at'=>now(), 'updated_at'=>now()],
                ['name' => 'user',  'created_at'=>now(), 'updated_at'=>now()],
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            DB::table(self::TABLE_NAME)->whereIn('name', ['admin', 'user'])->delete();
        });
    }
};
