<?php

namespace App\Filament\Resources\PostModals\Pages;

use App\Filament\Resources\PostModals\PostModalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePostModals extends ManageRecords
{
    protected static string $resource = PostModalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
