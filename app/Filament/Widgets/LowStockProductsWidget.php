<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockProductsWidget extends BaseWidget
{
    protected static ?string $heading = 'Low Stock Products';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->whereColumn('quantity', '<=', 'low_stock_threshold')
                    ->orderBy('quantity', 'asc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Current Stock')
                    ->badge()
                    ->color('danger'),
                Tables\Columns\TextColumn::make('low_stock_threshold')
                    ->label('Threshold')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category'),
            ]);
    }
}
