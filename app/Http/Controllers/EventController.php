<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Reservation;
use App\Services\EventService;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();

        /* 予約しているユーザーの人数をイベントごとに集計 */
        $reservedPeople = Reservation::query()
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->whereNotNull('canceled_date')
            ->groupBy('event_id');

        $events = Event::query()
            /* 直前に宣言した、予約しているユーザーの人数の集計をjoinする */
            ->leftJoinSub($reservedPeople, 'reservedPeople', fn ($join) => $join->on('events.id', '=', 'reservedPeople.event_id'))
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date', 'asc')->paginate(10);
        return view('manager.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $check = EventService::checkEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        if ($check) {
            session()->flash('status', '既に他のイベントが登録されている時間帯です');
            return redirect()->route('events.create')->withInput();
        }

        $startDate = EventService::joinDateAndTime($request['event_date'], $request['start_time']);
        $endDate = EventService::joinDateAndTime($request['event_date'], $request['end_time']);

        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible']
        ]);

        session()->flash('status', '登録okです');

        return to_route('events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $reservations = [];

        $users = $event->users;

        foreach($users as $user)
        {
            $reservedInfo = [
                'name' => $user->name,
                'number_of_people' => $user->pivot->number_of_people, // pivot で中間テーブルである reservations のカラムを取得できる
                'canceled_date' =>  $user->pivot->canceled_date // canceled_date が設定されているものは、キャンセル済みのため表示に含めない
            ];
            $reservations[] = $reservedInfo;
        }

        return view('manager.events.show', compact('event', 'users', 'reservations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('manager.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $check = EventService::countEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        if ($check > 1) {
            session()->flash('status', '既に他のイベントが登録されている時間帯です');
            return redirect()->route('events.edit', ['event' => $event])->withInput();
        }

        $startDate = EventService::joinDateAndTime($request['event_date'], $request['start_time']);
        $endDate = EventService::joinDateAndTime($request['event_date'], $request['end_time']);

        $event = Event::findOrFail($event->id);
        $event->name = $request['event_name'];
        $event->information = $request['information'];
        $event->start_date =  $startDate;
        $event->end_date = $endDate;
        $event->max_people = $request['max_people'];
        $event->is_visible = $request['is_visible'];
        $event->save();

        session()->flash('status', "イベント「{$event->name}」を更新しました");

        return to_route('events.index');
    }

    /**
     * 本日より前の日付のイベント情報を一覧表示する
     */
    public function past()
    {
        $today = Carbon::today();

        /* 予約しているユーザーの人数をイベントごとに集計 */
        $reservedPeople = Reservation::query()
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->whereNotNull('canceled_date')
            ->groupBy('event_id');


        $events = Event::query()
        /* 直前に宣言した、予約しているユーザーの人数の集計をjoinする */
        ->leftJoinSub($reservedPeople, 'reservedPeople', fn ($join) => $join->on('events.id', '=', 'reservedPeople.event_id'))
        ->whereDate('start_date', '<', $today)->orderBy('start_date', 'asc')
        ->paginate(10);

        return view('manager.events.past', compact('events'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
