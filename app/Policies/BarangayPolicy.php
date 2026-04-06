<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Barangay;
use Illuminate\Auth\Access\HandlesAuthorization;

class BarangayPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Barangay');
    }

    public function view(AuthUser $authUser, Barangay $barangay): bool
    {
        return $authUser->can('View:Barangay');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Barangay');
    }

    public function update(AuthUser $authUser, Barangay $barangay): bool
    {
        return $authUser->can('Update:Barangay');
    }

    public function delete(AuthUser $authUser, Barangay $barangay): bool
    {
        return $authUser->can('Delete:Barangay');
    }

    public function restore(AuthUser $authUser, Barangay $barangay): bool
    {
        return $authUser->can('Restore:Barangay');
    }

    public function forceDelete(AuthUser $authUser, Barangay $barangay): bool
    {
        return $authUser->can('ForceDelete:Barangay');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Barangay');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Barangay');
    }

    public function replicate(AuthUser $authUser, Barangay $barangay): bool
    {
        return $authUser->can('Replicate:Barangay');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Barangay');
    }

}