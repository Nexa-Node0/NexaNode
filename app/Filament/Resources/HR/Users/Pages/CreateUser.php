<?php

namespace App\Filament\Resources\HR\Users\Pages;

use App\Filament\Resources\HR\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
