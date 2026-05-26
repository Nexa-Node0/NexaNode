<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ProductPossession;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPossessionPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ProductPossession');
    }

    public function view(AuthUser $authUser, ProductPossession $productPossession): bool
    {
        return $authUser->can('View:ProductPossession');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ProductPossession');
    }

    public function update(AuthUser $authUser, ProductPossession $productPossession): bool
    {
        return $authUser->can('Update:ProductPossession');
    }

    public function delete(AuthUser $authUser, ProductPossession $productPossession): bool
    {
        return $authUser->can('Delete:ProductPossession');
    }

    public function restore(AuthUser $authUser, ProductPossession $productPossession): bool
    {
        return $authUser->can('Restore:ProductPossession');
    }

    public function forceDelete(AuthUser $authUser, ProductPossession $productPossession): bool
    {
        return $authUser->can('ForceDelete:ProductPossession');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ProductPossession');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ProductPossession');
    }

    public function replicate(AuthUser $authUser, ProductPossession $productPossession): bool
    {
        return $authUser->can('Replicate:ProductPossession');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ProductPossession');
    }
}
