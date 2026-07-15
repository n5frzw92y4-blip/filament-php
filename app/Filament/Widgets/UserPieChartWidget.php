<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class UserPieChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'User Pie Chart Widget';

    protected ?string $maxHeight = '260px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [100,200,300],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ]
                ],
            ],
            'labels' => ['Morocco','Puerto Rico', 'Mexico'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
