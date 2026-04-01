<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('userid', 64)->unique()->nullable()->after('id');
        });

        if (! DB::table('users')->where('userid', 'test1')->exists()) {
            DB::table('users')->insert([
                'userid' => 'test1',
                'name' => 'テストユーザー',
                'email' => 'test1@bookmanager.local',
                'password' => Hash::make('test1234'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $ownerId = (int) DB::table('users')->where('userid', 'test1')->value('id');

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });

        DB::table('books')->whereNull('user_id')->update(['user_id' => $ownerId]);
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('userid');
        });
    }
};
