<?php

namespace App\Filament\Resources\Blog\Authors\Pages;

use App\Filament\Resources\Blog\AuthorsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAuthors extends EditRecord
{
    protected static string $resource = AuthorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
