<?php

namespace App\Filament\Resources\Blog\Authors\Pages;

use App\Filament\Resources\Blog\AuthorsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\TopAuthorWidget;
class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return[
            TopAuthorWidget::class
        ];
    }
}
