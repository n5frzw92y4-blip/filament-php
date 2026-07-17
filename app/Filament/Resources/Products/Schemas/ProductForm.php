<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Prism\Prism\Facades\Prism;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make("Product Info")
//                        ->icon(Heroicon::)
                        ->description("fill all the fields")
                        ->schema([
                            Group::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->live(onBlur: true),
                                    TextInput::make('sku'),
                                    Select::make('category_id')
                                        ->relationship('category', 'name')
                                        ->required()
                                ])->columns(2),

                            MarkdownEditor::make('description')
                                ->hintAction(
                                    Action::make('generate_description')
                                        ->icon('heroicon-m-sparkles')
                                        ->label('Generate with AI')
                                        ->action(function (Get $get, Set $set) {
                                            $name = $get('name');

                                            if (empty($name)) {
                                                Notification::make()
                                                    ->warning()
                                                    ->title('Name required')
                                                    ->body('Please enter a product name first.')
                                                    ->send();
                                                return;
                                            }

                                            $response = Prism::text()
                                                ->using('gemini', 'gemini-3.1-flash-lite')
                                                ->withSystemPrompt(
                                                    "You are an expert e-commerce copywriter. Given only a product name, you infer the most " .
                                                    "likely product category, typical features, and target audience, then write a catchy, " .
                                                    "high-converting description around that inference. You write in clear, persuasive " .
                                                    "language that emphasizes benefits over specs. You always output only the Markdown " .
                                                    "description itself, with no preamble, no explanations, and no surrounding quotes."
                                                )
                                                ->withPrompt(
                                                    "Product name: {$name}\n\n" .
                                                    "Write a product description in Markdown with this exact structure:\n" .
                                                    "- A bold H2 headline (not just the product name restated)\n" .
                                                    "- 2-3 short persuasive sentences focused on benefits, based on what this type of product is typically used for\n" .
                                                    "- A bullet list of 3-5 plausible key features or benefits for this kind of product\n" .
                                                    "- A short call-to-action closing sentence\n" .
                                                    "- Keep the total length under 150 words\n" .
                                                    "- Output only the Markdown, nothing else"
                                                )
                                                ->generate();

                                            $set('description', $response->text);
                                        })
                                ),
                        ]),

                    Step::make("Pricing & Stock")
                        ->description("fill price and stock")
                        ->schema([
                            Group::make()
                                ->schema([
                                    TextInput::make('price'),
                                    TextInput::make('stock')
                                ])->columns(2),
                        ]),

                    Step::make("Media & Status")
                        ->description("fill media and status")
                        ->schema([
                            FileUpload::make('image')->disk("public")->directory("products"),
                            Checkbox::make('is_active'),
                            Checkbox::make('is_featured'),
                        ])
                ])
                    ->columnSpanFull()
                    ->skippable()
                    ->submitAction(
                        Action::make('save')
                            ->label("Save Product")
                            ->button()
                            ->color('primary')
                            ->submit("save")
                    )
            ]);
    }
}
