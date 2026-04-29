<?php

namespace App\Filament\Resources\Inventory;

use App\Filament\Resources\Inventory\ProductCategories\Pages\CreateProductCategory;
use App\Filament\Resources\Inventory\ProductCategories\Pages\EditProductCategory;
use App\Filament\Resources\Inventory\ProductCategories\Pages\ListProductCategories;
use App\Filament\Resources\Inventory\ProductCategories\Schemas\ProductCategoryForm;
use App\Filament\Resources\Inventory\ProductCategories\Tables\ProductCategoriesTable;
use App\Models\ProductCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Enums\NavigationOptions;
use Override;
use UnitEnum;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::FolderOpen;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;
    public static function form(Schema $schema): Schema
    {
        return ProductCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductCategoriesTable::configure($table);
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
            'index' => ListProductCategories::route('/'),
            'create' => CreateProductCategory::route('/create'),
            'edit' => EditProductCategory::route('/{record}/edit'),
        ];
    }
}
