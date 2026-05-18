<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BlogSubscriber;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogSubscriberPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:BlogSubscriber');
    }

    public function view(AuthUser $authUser, BlogSubscriber $blogSubscriber): bool
    {
        return $authUser->can('View:BlogSubscriber');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:BlogSubscriber');
    }

    public function update(AuthUser $authUser, BlogSubscriber $blogSubscriber): bool
    {
        return $authUser->can('Update:BlogSubscriber');
    }

    public function delete(AuthUser $authUser, BlogSubscriber $blogSubscriber): bool
    {
        return $authUser->can('Delete:BlogSubscriber');
    }

    public function restore(AuthUser $authUser, BlogSubscriber $blogSubscriber): bool
    {
        return $authUser->can('Restore:BlogSubscriber');
    }

    public function forceDelete(AuthUser $authUser, BlogSubscriber $blogSubscriber): bool
    {
        return $authUser->can('ForceDelete:BlogSubscriber');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:BlogSubscriber');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:BlogSubscriber');
    }

    public function replicate(AuthUser $authUser, BlogSubscriber $blogSubscriber): bool
    {
        return $authUser->can('Replicate:BlogSubscriber');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:BlogSubscriber');
    }

}