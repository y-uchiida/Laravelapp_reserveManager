<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'information',
        'max_people',
        'start_date',
        'end_date',
        'is_visible'
    ];

    /**
     * start_date カラムから、イベント実施の日付を取得する
     */
    protected function eventDate(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->start_date)->format('Y/m/d')
        );
    }

    /**
     * start_date カラムから、Date フォーマット互換の日付を取得する
     */
    protected function editEventDate(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->start_date)->format('Y-m-d')
        );
    }

    /**
     * start_date カラムから、イベントの開始時刻を取得する
     */
    protected function startTime(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->start_date)->format('H:i')
        );
    }

    /**
     * end_date カラムから、イベントの終了時刻を取得する
     */
    protected function endTime(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->end_date)->format('H:i')
        );
    }

}
