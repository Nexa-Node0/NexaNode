<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class TaskPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AuthUser $user): bool
    {
        // return true;
        return $user->can('ViewAny:Task');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(AuthUser $user, Task $task): bool
    {
        // return false;

        return $user->can('View:Task');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AuthUser $user): bool
    {
        // return false;

        return $user->can('Create:Task');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AuthUser $user, Task $task): bool
    {
        // return false;
        return $user->can('Update:Task');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AuthUser $user, Task $task): bool
    {
        // return false;
        return $user->can('Delete:Task');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AuthUser $user, Task $task): bool
    {
        // return false;
        return $user->can('Restore:Task');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AuthUser $user, Task $task): bool
    {
        // return false;
        return $user->can('ForceDelete:Task');
    }
}
