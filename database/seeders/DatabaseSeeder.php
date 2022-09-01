<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /*
        * usersモデルにサンプルのユーザーデータを追加するシーダーを追加
        * 名前空間が一緒なので、use で読み込みしなくてOK
        */
        $this->call([ UserDefaultSeeder::class ]);

        $this->call([ EventSeeder::class ]);

        $this->call([ ReservationSeeder::class ]);
    }
}
