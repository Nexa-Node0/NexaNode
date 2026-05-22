<?php

namespace App\Filament\Resources\Blog\Posts\Pages;

use App\Filament\Resources\Blog\PostResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!auth()->user()->hasRole('admin')) {
            $data['user_id'] = auth()->id(); // ← auto-assign to self
        }

        return $data;
    }
}
