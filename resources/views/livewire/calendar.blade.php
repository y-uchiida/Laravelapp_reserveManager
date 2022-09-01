<div>
    <input id="calendar" class="block mt-1 w-full" type="text" name="calendar"
        value="{{ $currentDate }}"
        wire:change="getDate($event.target.value)"
    />
    @for($day = 0; $day < 7; $day++)
        {{ $currentWeek[$day] }}
    @endfor

    @if ($events !== null)
        @foreach($events as $event)
            {{ $event->name }} ({{ $event->start_date }})
        @endforeach
    @endif
</div>
