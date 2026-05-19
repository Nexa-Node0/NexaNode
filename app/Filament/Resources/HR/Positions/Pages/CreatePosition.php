<?php

namespace App\Filament\Resources\HR\Positions\Pages;

use App\Filament\Resources\HR\Positions\PositionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePosition extends CreateRecord
{
    protected static string $resource = PositionResource::class;
}
