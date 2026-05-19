<?php

namespace App\Filament\Resources\HR\Positions\Pages;

use App\Filament\Resources\HR\Positions\PositionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Override;

class ListPositions extends ListRecords
{
    protected static string $resource = PositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    #[Override]
    public function getTitle(): string|Htmlable
    {
        return 'Position Management';
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return 'Manage job positions across all departments.';
    }
}
