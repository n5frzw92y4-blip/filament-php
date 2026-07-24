<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Actions\Action;
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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\Prism;
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
                                    ->searchable()
                                    ->live(),
                                ColorPicker::make('color'),
                            ])->Columns(2),

                        MarkdownEditor::make('body')
                            ->hintAction(
                                Action::make('generateBody')
                                    ->label('Generate with IA')
                                    ->icon(Heroicon::Sparkles)
                                    ->color('primary')
                                    ->requiresConfirmation()
                                    ->action(function (Set $set, Get $get) {
                                        $title = $get('title');
                                        $categoryId = $get('category_id');
                                        $category = $categoryId
                                            ? Category::find($categoryId)?->name
                                            : null;

                                        $prompt = "Tu es un rédacteur de contenu spécialisé en blogging."
                                            . " Rédige un article de blog complet et bien structuré au format Markdown, à partir des informations suivantes :\n\n"
                                            . "- Titre : \"{$title}\"\n"
                                            . ($category ? "- Catégorie : \"{$category}\"\n" : "")
                                            . "\nConsignes :\n"
                                            . "- Commence par une courte introduction accrocheuse (2-3 phrases) qui donne envie de lire la suite.\n"
                                            . "- Structure le corps avec des sous-titres pertinents (##) et des paragraphes courts et clairs.\n"
                                            . "- Utilise un ton engageant, naturel et professionnel, adapté à la thématique.\n"
                                            . "- Ajoute des listes à puces si cela aide à la lisibilité.\n"
                                            . "- Termine par une brève conclusion ou un appel à l'action.\n"
                                            . "- Longueur totale : entre 400 et 600 mots.\n"
                                            . "- N'invente pas de faits, de chiffres ou de sources précises si tu n'es pas certain.\n\n"
                                            . "Réponds uniquement avec le contenu Markdown de l'article, sans introduction, sans commentaire, sans balises de code (pas de ```).";

                                        $response = Prism::text()
                                            ->using(Provider::Gemini, 'gemini-3.6-flash')
                                            ->withPrompt($prompt)
                                            ->asText();

                                        $text = trim($response->text);
                                        $text = preg_replace('/^```(?:markdown)?\s*|\s*```$/', '', $text);
                                        $text = trim($text);

                                        $set('body', $text);
                                    })
                            ),
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
                                DatePicker::make('published_at'),
                            ])
                    ])->ColumnSpan(1),


            ])->columns(3);
    }
}
