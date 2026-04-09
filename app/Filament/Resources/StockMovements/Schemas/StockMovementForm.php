<?php

namespace App\Filament\Resources\StockMovements\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StockMovementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->label('Product')
                    ->searchable()
                    ->preload(),
                Select::make('type')
                    ->options([
                        'in' => 'Stock In',
                        'out' => 'Stock Out',
                    ])
                    ->required()
                    ->label('Movement Type'),
                TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->integer()
                    ->minValue(1)
                    ->label('Quantity'),
                Textarea::make('reason')
                    ->maxLength(65535)
                    ->label('Reason')
                    ->hint('e.g., Purchase Order #123, Sales Order #456, Damage, etc.'),
            ]);
    }
}
