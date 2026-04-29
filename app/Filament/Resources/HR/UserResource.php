<?php

namespace App\Filament\Resources\HR;

use App\Filament\Resources\HR\Users\Pages\CreateUser;
use App\Filament\Resources\HR\Users\Pages\EditUser;
use App\Filament\Resources\HR\Users\Pages\ListUsers;
use App\Filament\Resources\HR\Users\Schemas\UserForm;
use App\Filament\Resources\HR\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Enums\NavigationOptions;
use Override;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;
    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'information' => Users\RelationManagers\EmployeesRelationManager::class,
            'address'     => Users\RelationManagers\AddressRelationManager::class,
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
