<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;


class ApiUsers extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.api-users';
    protected static ?string $title= " API Users";
    protected static \BackedEnum|string|null $navigationIcon = Heroicon::SquaresPlus;

    public function table(Table $table): Table
    {
        return $table
            ->records(fn()=>$this ->apiData())
            ->columns([
                TextColumn::make("id"),
                TextColumn::make("name"),
            ])->paginated(false);
    }

    public function apiData()
    {
        $response = Http::get("https://jsonplaceholder.typicode.com/users");
        return $response->json();
    }




}
