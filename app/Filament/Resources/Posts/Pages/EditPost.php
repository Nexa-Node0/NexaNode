<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Helper\BreadcrumbsHelper;
use Filament\Navigation\NavigationItem;
use Illuminate\Contracts\Support\Htmlable;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;
 
    public function getBreadcrumbs(): array
    {
        return BreadcrumbsHelper::generateBreadcrumbsURL($this->record, $this->record->title, 'Edit');
    }

    public function getSubNavigation(): array
    {
        return[
            NavigationItem::make('View')
                ->url(ViewPost::getUrl(['record' => $this->record]))
                ->isActiveWhen(fn() => request()->routeIs(ViewPost::getRouteName()))
                ->icon('heroicon-o-eye'),
            
            NavigationItem::make('Edit')
                ->url(EditPost::getUrl(['record' => $this->record]))
                ->isActiveWhen(fn() => request()->routeIs(EditPost::getRouteName()))
                ->icon('heroicon-o-pencil'),
        ]; 
    }

    public function getTitle(): string|Htmlable
    {
        return $this->record->title;
    }
}
