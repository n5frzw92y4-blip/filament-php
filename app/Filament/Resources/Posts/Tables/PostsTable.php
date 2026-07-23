<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")
                    ->label("ID")
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make("comments_count")
                    ->counts("comments"),
                ImageColumn::make('image')->disk("public")->toggleable(),
                TextColumn::make('title')->label(__("resource.post.title"))
                    ->sortable()
                    ->searchable()->toggleable(),
                TextColumn::make('slug')
                    ->label(__("resource.post.slug"))
                    ->sortable()
                    ->searchable()->toggleable(),
                TextColumn::make('category.name')
                    ->sortable()
                    ->searchable()->toggleable(),
                ColorColumn::make('color'),
                TextColumn::make('created_at')
                    ->label("created At ")
                    ->dateTime()
                    ->sortable()->toggleable(),
                TextColumn::make("tags")
                    ->label("tags")
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make("published")
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true)
            ])->defaultSort("title","asc")
            ->filters([
                Filter::make("created_at")
                    ->label("Creation Date:")
                    ->schema([
                        DatePicker::make("created_at")
                            ->label("Select Date:")
                    ])
                    ->query(function($query, $data){
                        return $query
                            ->when($data["created_at"],function($q, $date){
                                $q->whereDate("created_at",$date);
                            });
                    }),
                SelectFilter::make("category_id")
                    ->label("Select Category")
                    ->relationship("category", "name")
                    ->preload()
            ])
            ->recordActions([
                Action::make("Status")
                    ->label("Status Change")
                    ->icon(Heroicon::ArrowUpCircle)
                    ->schema([
                        Checkbox::make("published")
                    ])
                    ->action(function(array $data,Post $record){
                        $record->published= $data['published'];
                        $record->save();
                    }),
                ReplicateAction::make(),
                DeleteAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
