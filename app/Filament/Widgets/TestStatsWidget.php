<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestStatsWidget extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;
        return [
            Stat::make("Total Users",User::query()
                ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                ->count())
                ->description("Total Users for this year")
                ->descriptionIcon(Heroicon::ArrowUpLeft, IconPosition::Before)
                ->chart(
                    User::selectRaw("MONTH(created_at) as month, COUNT(*) as count")
                        ->whereYear("created_at", now()->year)
                        ->groupBy("month")
                        ->orderBy("month")
                        ->pluck("count")
                        ->toArray()
                )
                ->descriptionColor("success")
                ->color("success"),
            Stat::make("Total Posts",Post::count())
                ->description("Total Posts for this year")
                ->descriptionIcon(Heroicon::ArrowUpLeft, IconPosition::Before)
                ->chart(
                    User::selectRaw("MONTH(created_at) as month, COUNT(*) as count")
                        ->whereYear("created_at", now()->year)
                        ->groupBy("month")
                        ->orderBy("month")
                        ->pluck("count")
                        ->toArray()
                )
                ->descriptionColor("warning")
                ->color("warning"),
            Stat::make("Total Products",Product::count())
                ->description("Total Products for this year")
                ->descriptionIcon(Heroicon::ArrowUpLeft, IconPosition::Before)
                ->chart(
                    User::selectRaw("MONTH(created_at) as month, COUNT(*) as count")
                        ->whereYear("created_at", now()->year)
                        ->groupBy("month")
                        ->orderBy("month")
                        ->pluck("count")
                        ->toArray()
                )
                ->descriptionColor("info")
                ->color("info"),
        ];
    }
}
