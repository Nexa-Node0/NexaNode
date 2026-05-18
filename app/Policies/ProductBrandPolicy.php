<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ProductBrand;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductBrandPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ProductBrand');
    }

    public function view(AuthUser $authUser, ProductBrand $productBrand): bool
    {
        return $authUser->can('View:ProductBrand');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ProductBrand');
    }

    public function update(AuthUser $authUser, ProductBrand $productBrand): bool
    {
        return $authUser->can('Update:ProductBrand');
    }

    public function delete(AuthUser $authUser, ProductBrand $productBrand): bool
    {
        return $authUser->can('Delete:ProductBrand');
    }

    public function restore(AuthUser $authUser, ProductBrand $productBrand): bool
    {
        return $authUser->can('Restore:ProductBrand');
    }

    public function forceDelete(AuthUser $authUser, ProductBrand $productBrand): bool
    {
        return $authUser->can('ForceDelete:ProductBrand');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ProductBrand');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ProductBrand');
    }

    public function replicate(AuthUser $authUser, ProductBrand $productBrand): bool
    {
        return $authUser->can('Replicate:ProductBrand');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ProductBrand');
    }

}