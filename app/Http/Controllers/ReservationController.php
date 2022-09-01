<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function detail(Event $event)
    {
        /* イベントを予約している人数の取得 */
        $reservedPeople = Reservation::query()
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people')) // event_id と number_of_people を取得結果に持つ
            ->whereNull('canceled_date') // キャンセル日付がnull == 有効な予約 に絞り込み
            ->groupBy('event_id') // イベントIDで集約し、number_of_people のイベントごとの合計数を得る
            ->having('event_id', $event->id) // 指定のイベントIDのデータだけ取り出す
            ->first(); // havingでid絞り込みしているためレコードは1件しかないので、first で取得

        if (!is_null($reservedPeople)) {
            $reservablePeople = $event->max_people - $reservedPeople->number_of_people;
        } else {
            $reservablePeople = $event->max_people;
        }

        $isReserved = Reservation::where('user_id', '=', Auth::id())
        ->where('event_id', '=', $event->id)
        ->where('canceled_date', '=', null)
        ->latest()
        ->first();

        return view('event-detail', compact('event', 'reservablePeople', 'isReserved'));
    }

    public function reserve(Request $request)
    {
        $event = Event::findOrFail($request['id']);

        /* イベントを予約している人数の取得 */
        $reservedPeople = Reservation::query()
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people')) // event_id と number_of_people を取得結果に持つ
            ->whereNull('canceled_date') // キャンセル日付がnull == 有効な予約 に絞り込み
            ->groupBy('event_id') // イベントIDで集約し、number_of_people のイベントごとの合計数を得る
            ->having('event_id', $event->id) // 指定のイベントIDのデータだけ取り出す
            ->first(); // havingでid絞り込みしているためレコードは1件しかないので、first で取得

        /* 予約者がいれば、その分だけ残席数を減らす */
        $remain_reservable = $event->max_people - ($reservedPeople ? $reservedPeople->number_of_people : 0);

        if ($remain_reservable >= $request['reserved_people']) {
            /* リクエストされた予約数に対して、残席数の方が多い場合は予約可能 */
            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $request['id'],
                'number_of_people' => $request['reserved_people']
            ]);

            session()->flash('status', 'イベント予約しました');
            return to_route('dashboard');
        } else {
            /* 残席数が足りない場合はエラーで返す */
            session()->flash('status', '予約可能な人数を超えています');
            return redirect()->route('events.reserve', ['event' => $event])->withInput();
        }
    }
}
