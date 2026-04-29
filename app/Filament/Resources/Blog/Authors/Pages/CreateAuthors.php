<?php

namespace App\Filament\Resources\Blog\Authors\Pages;

use App\Filament\Resources\Blog\AuthorsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthors extends CreateRecord
{
    protected static string $resource = AuthorsResource::class;
}
