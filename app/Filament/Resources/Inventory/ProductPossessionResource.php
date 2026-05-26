<?php
namespace App\Filament\Resources\Inventory;

use App\Enums\NavigationOptions;
use App\Filament\Resources\Inventory\ProductPossessions\Pages\ListProductPossessions;
use App\Filament\Resources\Inventory\ProductPossessions\Schemas\ProductPossessionForm;
use App\Filament\Resources\ProductPossessions\Tables\ProductPossessionsTable;
use App\Models\ProductPossession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Override;
use UnitEnum;

class ProductPossessionResource extends Resource
{
    protected static ?string $model = ProductPossession::class;

    protected static string|BackedEnum|null $navigationIcon       = Heroicon::Swatch;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::OutlinedSwatch;

    protected static ?string $recordTitleAttribute = 'currentOwner.name';

    #[Override]
    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return NavigationOptions::Inventory->getLabel();
    }

    public static function form(Schema $schema): Schema
    {
        return ProductPossessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductPossessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductPossessions::route('/'),
            // 'create' => CreateProductPossession::route('/create'),
            // 'edit' => EditProductPossession::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
