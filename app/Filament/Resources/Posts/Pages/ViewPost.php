<?php
namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use App\Helper\BreadcrumbsHelper;

class ViewPost extends ViewRecord {
    protected static string $resource = PostResource::class;
    
    public function getTitle(): string|Htmlable
    {
        return $this->record->title;
    }
     
    public function getBreadcrumbs(): array
    {
        return BreadcrumbsHelper::generateBreadcrumbsURL($this->record, $this->record->title, 'Edit');
    }
}