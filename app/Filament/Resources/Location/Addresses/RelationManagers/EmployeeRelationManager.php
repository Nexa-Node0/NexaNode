<?php

namespace App\Filament\Resources\Location\Addresses\RelationManagers;

use App\Filament\Resources\Employees\EmployeeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class EmployeeRelationManager extends RelationManager
{
    protected static string $relationship = 'employee';

    protected static ?string $relatedResource = EmployeeResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
