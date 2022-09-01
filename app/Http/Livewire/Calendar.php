<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\EventService;

use Carbon\CarbonImmutable;

class Calendar extends Component
{
    public $currenDate;
    public $currentWeek;
    public $events;
    public $checkDay;
    public $dayOfWeek;

    public function mount()
    {
        $carbonDate = CarbonImmutable::today();
        $this->currentDate = $carbonDate->format('Y年m月d日');
        $this->currentWeek = [];
        $this->events = EventService::getWeekEvents($carbonDate);

        for ($i = 0; $i < 7; $i++)
        {
            $targetDate = $carbonDate->addDays($i);
            $this->checkDay = $targetDate->format('Y-m-d');
            $this->dayOfWeek = $targetDate->dayName;
            $this->currentWeek[] = [
                'day' => $targetDate->format('Y年m月d日'),
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek
            ];
        }
    }

    /**
     * 指定の日付を起点に、7日後までの日付を持った配列を返す
     */
    public function getDate($date)
    {
        $carbonDate = CarbonImmutable::parse($date);
        $this->currentDate = $carbonDate->format('Y年m月d日');
        $this->currentWeek = [];
        $this->events = EventService::getWeekEvents(CarbonImmutable::parse($date));

        for($i = 0; $i < 7; $i++)
        {
            $targetDate = $carbonDate->addDays($i);
            $this->checkDay = $targetDate->format('Y-m-d');
            $this->dayOfWeek = $targetDate->dayName;
            $this->currentWeek[] = [
                'day' => $targetDate->format('Y年m月d日'),
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek
            ];
        }
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
