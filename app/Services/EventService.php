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

     /**
      * 指定の日付から7日後までのイベントを取得する
      */
     public static function getWeekEvents(Carbon $startDate)
     {
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->whereNotNull('canceled_date')
            ->groupBy('event_id');

        return DB::table('events')
            ->leftJoinSub($reservedPeople, 'reservedPeople', function($join){
                $join->on('events.id', '=', 'reservedPeople.event_id');
                })
            ->whereBetween('start_date', [
                $startDate->format('Y-m-d'),
                $startDate->addDay(7)->format('Y-m-d')
            ])
            ->orderBy('start_date', 'asc')
            ->get();
     }
}
