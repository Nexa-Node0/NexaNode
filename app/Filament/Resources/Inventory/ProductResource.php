<?php

namespace App\Filament\Resources\Inventory;

use App\Filament\Resources\Inventory\Products\Pages\CreateProduct;
use App\Filament\Resources\Inventory\Products\Pages\EditProduct;
use App\Filament\Resources\Inventory\Products\Pages\ListProducts;
use App\Filament\Resources\Inventory\Products\Schemas\ProductForm;
use App\Filament\Resources\Inventory\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Enums\NavigationOptions;
use Override;
use UnitEnum;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Squares2x2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;
    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    #[Override]
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return NavigationOptions::Inventory->getLabel();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
