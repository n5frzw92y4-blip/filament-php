<?php

namespace App\Filament\Resources\Calendars\Pages;

use App\Filament\Resources\Calendars\CalendarResource;
use App\Filament\Resources\Calendars\Widgets\CalendarWidget2;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\Page;

class ListCalendars extends Page
{
    protected static string $resource = CalendarResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget2::class,
        ];
    }
}
