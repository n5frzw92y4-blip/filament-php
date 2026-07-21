<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use function Laravel\Prompts\select;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('fields')
                    ->description("Fill in fields ")
                    ->icon(Heroicon::RocketLaunch)
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('title')->rules("required|min:3")
                                     ->live(onBlur:true)
                                    ->afterStateUpdated(function (string $operation, string $state, Set $set){
                                        $set("slug", Str::slug($state));
                                    }),
                                TextInput::make('slug')->unique()
                                    ->validationMessages([
                                        "unique"=>"slug already exists",
                                    ]),
                                Select::make('category_id')
                                    ->label("category")
                                    ->relationship("category", "name")
                                    ->searchable(),
                                ColorPicker::make('color'),
                            ])->Columns(2),

                        MarkdownEditor::make('body'),
                    ])->ColumnSpan(2),
                Group::make()
                    ->schema([
                        Section::make('Image Upload')
                            ->schema([
                                FileUpload::make('image')->disk('public')->directory("posts"),
                            ]),
                        Section::make('Meta')
                            ->schema([
                                Select::make('tags')
                                    ->relationship("tags", "name")
                                    ->multiple()
                                    ->preload(),
                                Checkbox::make('published'),
                                Datepicker::make('published_at'),
                            ])
                    ])->ColumnSpan(1),


            ])->columns(3);
    }
}
