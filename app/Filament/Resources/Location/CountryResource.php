<?php
namespace App\Filament\Resources\Location;

use App\Filament\Resources\Location\Countries\Pages\CreateCountry;
use App\Filament\Resources\Location\Countries\Pages\EditCountry;
use App\Filament\Resources\Location\Countries\Pages\ListCountries;
use App\Filament\Resources\Location\Countries\Schemas\CountryForm;
use App\Filament\Resources\Location\Countries\Tables\CountriesTable;
use App\Models\Country;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Enums\NavigationOptions;
use Override;
use UnitEnum;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeAsiaAustralia;
    protected static ?int $navigationSort = 0;
    protected static ?string $recordTitleAttribute  = 'name';

    public static function form(Schema $schema): Schema
    {
        return CountryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CountriesTable::configure($table);
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
            'index'  => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'edit'   => EditCountry::route('/{record}/edit'),
        ];
    }
}
