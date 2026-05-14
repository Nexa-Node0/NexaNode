<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\Subscribers\Pages\CreateSubscribers;
use App\Filament\Resources\Blog\Subscribers\Pages\EditSubscribers;
use App\Filament\Resources\Blog\Subscribers\Pages\ListSubscribers;
use App\Filament\Resources\Blog\Subscribers\Schemas\SubscribersForm;
use App\Filament\Resources\Blog\Subscribers\Tables\SubscribersTable;
use App\Models\BlogSubscriber;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Enums\NavigationOptions;
use Override;
use UnitEnum;

class SubscribersResource extends Resource
{
    protected static ?string $model = BlogSubscriber::class;
    protected static ?string $navigationLabel = 'Subscribers';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SubscribersForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscribersTable::configure($table);
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
            'index' => ListSubscribers::route('/'),
            'create' => CreateSubscribers::route('/create'),
            'edit' => EditSubscribers::route('/{record}/edit'),
        ];
    }
     
    #[Override]
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return NavigationOptions::Blog->getLabel();
    }
}
