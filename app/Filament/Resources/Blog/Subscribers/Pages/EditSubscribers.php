<?php

namespace App\Filament\Resources\Blog\Subscribers\Pages;

use App\Filament\Resources\Blog\SubscribersResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubscribers extends EditRecord
{
    protected static string $resource = SubscribersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
