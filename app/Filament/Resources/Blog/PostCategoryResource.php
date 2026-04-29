<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\PostCategories\Pages\ListPostCategories;
use App\Filament\Resources\Blog\PostCategories\Schemas\PostCategoryForm;
use App\Filament\Resources\Blog\PostCategories\Tables\PostCategoriesTable;
use App\Models\PostCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\NavigationOptions;
use Illuminate\Contracts\Support\Htmlable;
use Override;
use UnitEnum;

class PostCategoryResource extends Resource
{

    protected static ?string $model = PostCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'PostCategory';

    protected static ?int $navigationSort = 2;
    
    public static function form(Schema $schema): Schema
    {
        return PostCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostCategoriesTable::configure($table);
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

    #[Override]
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('is_visible',true)->count();
    }

    #[Override]
    public static function getNavigationBadgeTooltip(): string|Htmlable|null
    {
        return 'Total visible categories';
    }

    #[Override]
    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPostCategories::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('posts');
    }
}
