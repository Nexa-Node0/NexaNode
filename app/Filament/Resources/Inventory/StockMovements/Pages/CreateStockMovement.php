<?php

namespace App\Filament\Resources\Inventory\StockMovements\Pages;

use App\Filament\Resources\Inventory\StockMovementResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateStockMovement extends CreateRecord
{
    protected static string $resource = StockMovementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['moved_by'] = Auth::id();
        return $data;
    }
}
