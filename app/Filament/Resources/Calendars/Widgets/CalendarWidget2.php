<?php

namespace App\Filament\Resources\Calendars\Widgets;

use App\Models\Calendar;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget2 extends FullCalendarWidget
{
    public string|null|\Illuminate\Database\Eloquent\Model $model = Calendar::class;
//    protected string $view = 'filament.widgets.calendar-widget';

    public function fetchEvents(array $fetchInfo): array
    {
        return Calendar::query()
            ->where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn(Calendar $event) => [
                    'id' => $event->id,
                    'name' => $event->name,
                    'start' => $event->start,
                    'end' => $event->end,
                    'allDay' => $event->allDay,
                ]
            )
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name'),
            DateTimePicker::make('start'),
            DateTimePicker::make('end'),
            Toggle::make('allDay')->default(true),
        ];
    }
}
