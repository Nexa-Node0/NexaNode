<?php

namespace App\Filament\Resources\Blog\Subscribers\Pages;

use App\Filament\Resources\Blog\SubscribersResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubscribers extends CreateRecord
{
    protected static string $resource = SubscribersResource::class;
}
