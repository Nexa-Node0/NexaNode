<?php

namespace App\Filament\Resources\Blog\Subscribers\Pages;

use App\Filament\Resources\Blog\SubscribersResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubscribers extends ListRecords
{
    protected static string $resource = SubscribersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
