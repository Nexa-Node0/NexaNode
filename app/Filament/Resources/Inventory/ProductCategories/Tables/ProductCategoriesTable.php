<?php

namespace App\Filament\Resources\Inventory\ProductCategories\Tables;

use App\Filament\Resources\Inventory\ProductCategories\Schemas\ProductCategoryForm;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(true),
                TextColumn::make('name')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable()
                    ->searchable(isIndividual: true),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(fn (TextColumn $column): ?string => $column->getState()),
                TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
                EditAction::make()
                    ->schema(fn (Schema $schema) => ProductCategoryForm::configure($schema))
                    ->hiddenLabel()
                    ->tooltip('Edit')
                    ->size('xl'),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip('Delete')
                    ->size('xl'),
            ])
            ->bulkActions([
                //
            ]);
    }
}
