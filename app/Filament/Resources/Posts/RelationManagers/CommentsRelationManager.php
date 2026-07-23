<?php

namespace App\Filament\Resources\Posts\RelationManagers;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

//    protected static ?string $relatedResource = PostResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Textarea::make('body')
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id"),
                TextColumn::make('body'),
                TextColumn::make('created_at')
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
