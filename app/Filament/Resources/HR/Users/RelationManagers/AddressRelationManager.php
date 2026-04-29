<?php

namespace App\Filament\Resources\HR\Users\RelationManagers;

use App\Filament\Resources\Location\AddressResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    protected static ?string $relatedResource = AddressResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
