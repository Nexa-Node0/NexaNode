<?php

namespace App\Filament\Resources\Inventory\StockMovements\Pages;

use App\Filament\Resources\Inventory\StockMovementResource;
use Filament\Resources\Pages\EditRecord;

class EditStockMovement extends EditRecord
{
    protected static string $resource = StockMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
