<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodayUsersStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Today Users', User::WhereDate("created_at", today())
                ->count(),
            )
            ->icon(Heroicon::UserGroup)
        ];
    }
}
