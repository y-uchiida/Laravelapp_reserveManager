<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dummyDate = $this->faker->dateTimeThisMonth;

        /* ランダムデータ生成時のルール */
        return [
            'name' => $this->faker->name,
            'information' => $this->faker->realText,
            'max_people' => $this->faker->numberBetween(1,20), // 1 ~ 20 人まで予約できるデータを作る
            'start_date' => $dummyDate->format('Y-m-d H:i:s'),
            'end_date' => $dummyDate->modify('+1hour')->format('Y-m-d H:i:s'), // 予約終了時刻が予約開始時刻よりも過去にならないように、 時間を加算して設定する
            'is_visible' => $this->faker->boolean,
        ];
    }
}
