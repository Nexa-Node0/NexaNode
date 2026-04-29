<?php

namespace App\Filament\Resources\Inventory;

use App\Filament\Resources\Inventory\StockMovements\Pages\CreateStockMovement;
use App\Filament\Resources\Inventory\StockMovements\Pages\EditStockMovement;
use App\Filament\Resources\Inventory\StockMovements\Pages\ListStockMovements;
use App\Filament\Resources\Inventory\StockMovements\Schemas\StockMovementForm;
use App\Filament\Resources\Inventory\StockMovements\Tables\StockMovementsTable;
use App\Models\StockMovement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Enums\NavigationOptions;
use Override;
use UnitEnum;

class StockMovementResource extends Resource
{
    protected static ?string $model = StockMovement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowsRightLeft;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 3;
    public static function form(Schema $schema): Schema
    {
        return StockMovementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockMovementsTable::configure($table);
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
            'index' => ListStockMovements::route('/'),
            'create' => CreateStockMovement::route('/create'),
            'edit' => EditStockMovement::route('/{record}/edit'),
        ];
    }
}
