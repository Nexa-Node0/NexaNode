<?php
namespace App\Filament\Resources\Inventory\Products\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
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

    public static function getTableContents(Table $table, $full = false)
    {
        return $table
            ->columns([
                TextColumn::make('originalOwner.name'),
                TextColumn::make('currentOwner.name'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => $state->color()),
                TextColumn::make('release_date')
                    ->date('M d, Y - D')
                    ->sortable(),
                TextColumn::make('transferred_date')
                    ->date('M d, Y - D')
                    ->placeholder('Not Set')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('returned_date')
                    ->date('M d, Y - D')
                    ->placeholder('Not Set')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ]);
    }

    public function table(Table $table): Table
    {
        return static::getTableContents($table);
    }
}
