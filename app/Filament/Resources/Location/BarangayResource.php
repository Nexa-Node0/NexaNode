<?php

namespace App\Filament\Resources\Location;

use App\Filament\Resources\Location\Barangays\Pages\CreateBarangay;
use App\Filament\Resources\Location\Barangays\Pages\EditBarangay;
use App\Filament\Resources\Location\Barangays\Pages\ListBarangays;
use App\Filament\Resources\Location\Barangays\Schemas\BarangayForm;
use App\Filament\Resources\Location\Barangays\Tables\BarangaysTable;

use App\Models\Barangay;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Enums\NavigationOptions;
use Override;
use UnitEnum;

class BarangayResource extends Resource
{
    protected static ?string $model = Barangay::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $label = "Streets";
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return BarangayForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BarangaysTable::configure($table);
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
        return NavigationOptions::Location->getLabel();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBarangays::route('/'),
            'create' => CreateBarangay::route('/create'),
            'edit' => EditBarangay::route('/{record}/edit'),
        ];
    }
}
