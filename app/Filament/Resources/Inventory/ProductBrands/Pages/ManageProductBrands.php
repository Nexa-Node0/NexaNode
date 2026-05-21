<?php
namespace App\Filament\Resources\Inventory\ProductBrands\Pages;

use App\Filament\Resources\Inventory\ProductBrandResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageProductBrands extends ManageRecords
{
    protected static string $resource = ProductBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
