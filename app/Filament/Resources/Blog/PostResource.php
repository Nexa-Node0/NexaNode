<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\Posts\Pages\CreatePost;
use App\Filament\Resources\Blog\Posts\Pages\EditPost;
use App\Filament\Resources\Blog\Posts\Pages\ListPosts;
use App\Filament\Resources\Blog\Posts\Pages\ViewPost;
use App\Filament\Resources\Blog\Posts\Schemas\PostForm;
use App\Filament\Resources\Blog\Posts\Tables\PostsTable;
use App\Models\Post;
use BackedEnum;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Pages\Page;
use App\Enums\NavigationOptions;
use Illuminate\Contracts\Support\Htmlable;
use Override;
use UnitEnum;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    protected static ?string $recordTitleAttribute = 'Post';
    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostsTable::configure($table);
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

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewPost::class,
            EditPost::class
        ]);
    }

    #[Override]
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    #[Override]
    public static function getNavigationBadgeTooltip(): string|Htmlable|null
    {
        return 'Posted this month';
    }

    #[Override]
    public static function getNavigationBadgeColor(): string|array|null
    {
        $postedThisMonth = static::getModel()::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $postedLastMonth = static::getModel()::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $diff = $postedThisMonth - $postedLastMonth;
        $isIncreased = $diff >= 0;

        return $isIncreased ? 'success' : 'warning';   
    }
    

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'view' => ViewPost::route('/{record}'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
