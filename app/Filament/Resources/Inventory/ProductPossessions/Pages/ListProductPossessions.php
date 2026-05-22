<?php
namespace App\Filament\Resources\Inventory\ProductPossessions\Pages;

use App\Filament\Resources\Inventory\ProductPossessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductPossessions extends ListRecords
{
    protected static string $resource = ProductPossessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
