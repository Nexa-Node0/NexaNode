<?php

namespace App\Filament\Resources\Authors;

use App\Filament\Resources\Authors\Pages\CreateAuthors;
use App\Filament\Resources\Authors\Pages\EditAuthors;
use App\Filament\Resources\Authors\Pages\ListAuthors;
use App\Filament\Resources\Authors\Schemas\AuthorsForm;
use App\Filament\Resources\Authors\Tables\AuthorsTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class AuthorsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $recordTitleAttribute = 'Authors';

    protected static string|UnitEnum|null $navigationGroup = 'Blog';

    protected static ?string $navigationLabel = 'Authors';

    protected static ?int $navigationSort = 3;
    
    public static function form(Schema $schema): Schema
    {
        return AuthorsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuthorsTable::configure($table);
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
            'index' => ListAuthors::route('/'),
            'create' => CreateAuthors::route('/create'),
            'edit' => EditAuthors::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return User::role('author');
    }
}
