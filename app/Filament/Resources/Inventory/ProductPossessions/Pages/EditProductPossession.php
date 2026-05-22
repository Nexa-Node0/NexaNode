<?php
namespace App\Filament\Resources\Inventory\ProductPossessions\Pages;

use App\Filament\Resources\Inventory\ProductPossessionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditProductPossession extends EditRecord
{
    protected static string $resource = ProductPossessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
