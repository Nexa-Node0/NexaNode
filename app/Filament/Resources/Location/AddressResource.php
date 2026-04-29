<?php
namespace App\Filament\Resources\Location;

use App\Filament\Resources\Location\Addresses\Pages\CreateAddress;
use App\Filament\Resources\Location\Addresses\Pages\EditAddress;
use App\Filament\Resources\Location\Addresses\Pages\ListAddresses;
use App\Filament\Resources\Location\Addresses\Schemas\AddressForm;
use App\Filament\Resources\Location\Addresses\Tables\AddressesTable;

use App\Models\Address;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use App\Enums\NavigationOptions;

use UnitEnum;
use Override;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeAmericas;

    // protected static ?string $recordTitleAttribute = 'line1';
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return $ownerRecord->user->name . "'s Addresses";
    }
    protected static ?string $navigationParentItem = 'Users';

    public static function form(Schema $schema): Schema
    {
        return AddressForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddressesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
            'employee' => Addresses\RelationManagers\EmployeeRelationManager::class,
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
            'index'  => ListAddresses::route('/'),
            'create' => CreateAddress::route('/create'),
            'edit'   => EditAddress::route('/{record}/edit'),
        ];
    }
}
