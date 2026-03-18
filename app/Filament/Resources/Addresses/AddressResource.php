<?php
namespace App\Filament\Resources\Addresses;

use App\Filament\Resources\Addresses\Pages\CreateAddress;
use App\Filament\Resources\Addresses\Pages\EditAddress;
use App\Filament\Resources\Addresses\Pages\ListAddresses;
use App\Filament\Resources\Addresses\Schemas\AddressForm;
use App\Filament\Resources\Addresses\Tables\AddressesTable;
use App\Models\Address;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

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
            'employee' => RelationManagers\EmployeeRelationManager::class,
        ];
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
