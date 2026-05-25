<?php

namespace App\Filament\Resources\HR\Positions;

use App\Enums\NavigationOptions;
use App\Filament\Resources\HR\Positions\Pages\CreatePosition;
use App\Filament\Resources\HR\Positions\Pages\EditPosition;
use App\Filament\Resources\HR\Positions\Pages\ListPositions;
use App\Filament\Resources\HR\Positions\Schemas\PositionForm;
use App\Filament\Resources\HR\Positions\Tables\PositionsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Models\Position;
use BackedEnum;
use Override;
use UnitEnum;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowUpLeft;

    protected static ?string $recordTitleAttribute = 'name';



    public static function form(Schema $schema): Schema
    {
        return PositionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PositionsTable::configure($table);
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
        return NavigationOptions::HR->getLabel();
    }


    public static function getPages(): array
    {
        return [
            'index' => ListPositions::route('/'),
            'create' => CreatePosition::route('/create'),
            'edit' => EditPosition::route('/{record}/edit'),
        ];
    }
}
