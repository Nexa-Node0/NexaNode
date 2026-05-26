<?php
namespace App\Filament\Resources\Inventory\Products\RelationManagers;

use App\Filament\Resources\ProductPossessions\Tables\ProductPossessionsTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ProductPosessionsRelationManager extends RelationManager
{
    protected static string $relationship = 'deployedItems';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('product.name')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return ProductPossessionsTable::getTableContents($table);
    }
}
