<?php

namespace App\Filament\Resources;

use App\Models\Task;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Override;

class TaskResource extends Resource
{
    //Make a Resource and not visible in navigation, just to create policy in filament shield
    protected static ?string $mode = Task::class;

    public static function canAccess(): bool
    {
        return false;
    }


    // #[Override]
    // public static function getEloquentQuery(): Builder
    // {
    //     $user = auth()->user();

    //     if ($user->can('view_any_task')) {
    //         return Task::query();
    //     }

    //     return Task::query()->where('assigned_to', $user->id);
    // }

    protected static bool $shouldRegisterNavigation = false;
}
