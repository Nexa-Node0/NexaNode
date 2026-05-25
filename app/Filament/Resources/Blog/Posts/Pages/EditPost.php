<?php

namespace App\Filament\Resources\Blog\Posts\Pages;

use App\Filament\Resources\Blog\PostResource;
use Filament\Resources\Pages\EditRecord;
use App\Helper\BreadcrumbsHelper;
use Filament\Navigation\NavigationItem;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Actions\Action;

use Override;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    public function getBreadcrumbs(): array
    {
        return BreadcrumbsHelper::generateBreadcrumbsURL($this->record, $this->record->title, 'Edit');
    }

    public function getSubNavigation(): array
    {
        return [
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

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return 'This is where the subheading of the post';
    }

    #[Override]
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make('post_edit_saved')
            ->title('Post saved')
            ->body("{$this->record->title} has been saved")
            ->icon('success')
            ->send();
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            Action::make('autosaved')
                ->hidden()
        ];
    }
}
