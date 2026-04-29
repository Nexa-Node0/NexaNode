<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\Authors\Pages\CreateAuthors;
use App\Filament\Resources\Blog\Authors\Pages\EditAuthors;
use App\Filament\Resources\Blog\Authors\Pages\ListAuthors;
use App\Filament\Resources\Blog\Authors\Schemas\AuthorsForm;
use App\Filament\Resources\Blog\Authors\Tables\AuthorsTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\NavigationOptions;
use Filament\Navigation\NavigationGroup;
use Override;
use UnitEnum;

class AuthorsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $recordTitleAttribute = 'Authors';

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

    #[Override]
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return NavigationOptions::Blog->getLabel();
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
