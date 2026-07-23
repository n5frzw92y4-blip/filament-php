<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Post;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                TextInput::make('slug')
            ]);
    }
}
