<?php

namespace App\Filament\Resources\Inventory\Products\Pages;

use App\Filament\Resources\Inventory\ProductResource;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
             \App\Filament\Widgets\InventoryStatsWidget::class
        ];  
    }
}
