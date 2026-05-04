<?php
declare (strict_types = 1);
namespace App\Policies;

use App\Models\FileStorage;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class FileStoragePolicy
{
    use HandlesAuthorization;

    private function check(string $ability, AuthUser $authUser, ?FileStorage $file = null): bool
    {
        // Root FileStorage permission = access to ALL files
        if ($authUser->can("{$ability}:FileStorage")) {
            return true;
        }

        // Morph-specific permission = only access to their own files
        if ($file?->fileable_name && $authUser->can("{$ability}:{$file->fileable_name}")) {
            return true;
        }

        return false;
    }

    public function viewAny(AuthUser $authUser): bool
    {
        // No file instance here, so just check root + all known morph resources
        return $authUser->can('ViewAny:FileStorage')
        || $authUser->can('ViewAny:ProjectFile');
    }

    public function view(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $this->check('View', $authUser, $fileStorage);
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FileStorage')
        || $authUser->can('Create:ProjectFile');
    }

    public function update(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $this->check('Update', $authUser, $fileStorage);
    }

    public function delete(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $this->check('Delete', $authUser, $fileStorage);
    }

    public function restore(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $this->check('Restore', $authUser, $fileStorage);
    }

    public function forceDelete(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $this->check('ForceDelete', $authUser, $fileStorage);
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FileStorage')
        || $authUser->can('ForceDeleteAny:ProjectFile');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FileStorage')
        || $authUser->can('RestoreAny:ProjectFile');
    }

    public function replicate(AuthUser $authUser, FileStorage $fileStorage): bool
    {
        return $this->check('Replicate', $authUser, $fileStorage);
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FileStorage')
        || $authUser->can('Reorder:ProjectFile');
    }
}
