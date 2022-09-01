<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventService
{
    /**
     * 同一の日付時刻で実施されるイベントの有無を真偽値で取得する
     */
    public static function checkEventDuplication($eventDate, $startTime, $endTime)
    {
        return DB::table('events')
            ->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->exists();
    }

    public static function joinDateAndTime($date, $time)
    {
        return Carbon::createFromFormat('Y-m-d H:i', "$date $time");
    }

    /**
     * 同一の日付時刻で実施されるイベントの件数を取得する
     */
    public static function countEventDuplication($eventDate, $startTime, $endTime)
    {
      return DB::table('events')
          ->whereDate('start_date', $eventDate)
          ->whereTime('end_date', '>', $startTime)
          ->whereTime('start_date', '<', $endTime)
          ->count();
     }
}
