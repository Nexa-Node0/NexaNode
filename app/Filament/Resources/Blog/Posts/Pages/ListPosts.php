<?php

namespace App\Filament\Resources\Blog\Posts\Pages;

use App\Filament\Resources\Blog\PostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

use App\Filament\Widgets\BlogWidget;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Add New Post')
                ->modalWidth(Width::SevenExtraLarge),
            
           
            ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BlogWidget::class,
        ];
    }
}
