<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserCounterWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Total Users", User::count())
                ->description("Total Users for this year")
                ->color('primary'),
            Stat::make("Total users of Morocco",User::whereHas("country", fn($q)=> $q->where("name","Morocco"))->count()),
            Stat::make("Total users of Puerto rico",User::whereHas("country", fn($q)=> $q->where("name","Puerto rico"))->count()),

        ];
    }
}
