<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\EventService;

use Carbon\Carbon;

class Calendar extends Component
{
    public $currenDate;
    public $currentWeek;
    public $events;

    public function mount()
    {
        $this->currentDate = Carbon::today()->format('Y年m月d日');
        $this->currentWeek = [];
        $this->events = EventService::getWeekEvents(Carbon::today());

        for ($i = 0; $i < 7; $i++)
        {
            $this->currentWeek[] = Carbon::today()->addDays($i)->format('m月d日');
        }
    }

    /**
     * 指定の日付を起点に、7日後までの日付を持った配列を返す
     */
    public function getDate($date)
    {
        $carbonDate = Carbon::parse($date);
        $this->currentDate = $carbonDate->format('Y年m月d日');
        $this->currentWeek = [];
        $this->events = EventService::getWeekEvents(Carbon::parse($date));

        for($i = 0; $i < 7; $i++)
        {
            $this->currentWeek[] = $carbonDate->addDays($i)->format('m月d日');
        }
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
