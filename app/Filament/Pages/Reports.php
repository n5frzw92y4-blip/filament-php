<?php

namespace App\Filament\Pages;

use App\Livewire\TodayUsersStats;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class Reports extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.reports';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Report';
    protected static ?string $title = 'User Report';

    public function getHeaderWidgets(): array
    {
        return [
         TodayUsersStats::class
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->whereDate('created_at', today())
            )
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('created_at'),
            ]);
    }
}
