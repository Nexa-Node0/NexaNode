<?php

namespace App\Filament\Resources\Location\Barangays\Pages;

use App\Filament\Resources\Location\BarangayResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBarangay extends EditRecord
{
    protected static string $resource = BarangayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
