<?php

/*
 * 以下のコマンドによりひな形を生成した
 * sail artisan make:seeder UserDefaultSeeder
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB; // データベース操作のファサード
use Illuminate\Support\Facades\Hash; // ハッシュ生成のファサード

class UserDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin_sample',
                'email' => 'admin_sample@example.com',
                'password' => Hash::make('admin_sample@example.com'),
                'role' => 1, // admin 権限
            ],
            [
                'name' => 'manager_sample',
                'email' => 'manager_sample@example.com',
                'password' => Hash::make('manager_sample@example.com'),
                'role' => 5, // manager 権限
            ],
            [
                'name' => 'user_sample',
                'email' => 'user_sample@example.com',
                'password' => Hash::make('user_sample@example.com'),
                'role' => 9, // user 権限
            ],
        ]);
    }
}
