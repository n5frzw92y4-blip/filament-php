<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getCreatedNotificationMessage(): ?string
    {
        return "User created.";
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title("User created.")
            ->body("User created successfully.")
            ->success()
            ->send();
    }
}
