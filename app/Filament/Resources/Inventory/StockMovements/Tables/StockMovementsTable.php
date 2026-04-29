<?php

namespace App\Filament\Resources\Inventory\StockMovements\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class StockMovementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'success' => 'in',
                        'danger' => 'out',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),
                TextColumn::make('reason')
                    ->label('Reason')
                    ->limit(40)
                    ->tooltip(fn (TextColumn $column): ?string => $column->getState()),
                TextColumn::make('movedBy.name')
                    ->label('Moved By')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Recorded At')
                    ->dateTime('M d, Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
