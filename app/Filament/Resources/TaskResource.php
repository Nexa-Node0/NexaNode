<?php
namespace App\Filament\Resources;

use App\Models\Task;
use Filament\Resources\Resource;

class TaskResource extends Resource
{
    //Make a Resource and not visible in navigation, just to create policy in filament shield
    protected static ?string $mode = Task::class;

    public static function canAccess(): bool
    {
        return false;
    }

    protected static bool $shouldRegisterNavigation = false;
}
