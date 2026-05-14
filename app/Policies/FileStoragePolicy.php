<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\FileStorage;
use Illuminate\Auth\Access\HandlesAuthorization;

class FileStoragePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FileStorage');
    }

    public function view(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $authUser->can('View:FileStorage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FileStorage');
    }

    public function update(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $authUser->can('Update:FileStorage');
    }

    public function delete(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $authUser->can('Delete:FileStorage');
    }

    public function restore(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $authUser->can('Restore:FileStorage');
    }

    public function forceDelete(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $authUser->can('ForceDelete:FileStorage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FileStorage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FileStorage');
    }

    public function replicate(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $authUser->can('Replicate:FileStorage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FileStorage');
    }

}