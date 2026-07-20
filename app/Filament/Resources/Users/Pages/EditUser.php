<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->title("User DELETED.")
                        ->body("User Deleted successfully.")
                        ->success()
                ),
        ];
    }

    protected function getSavedNotificationMessage(): ?string
    {
        return "User saved.";
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title("User updated.")
            ->body("User saved successfully.")
            ->success()
            ->send();
    }
}
