<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UserChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;


    protected ?string $heading = 'New Registrations';
    protected string $color = 'info';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        $start =$startDate ? now()->parse($startDate)->startOfDay() : now()->startOfYear();
        $end =$endDate ? now()->parse($endDate)->endOfDay() : now()->endOfYear();
        $data = Trend::model(User::class)
            ->between(
                start: $start,
                end: $end,
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Users created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
