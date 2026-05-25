<?php

namespace App\Observers;

use App\Models\UserPosition;
use App\Models\Position;
use Spatie\Permission\Models\Role;

class UserPositionObserver
{
    /**
     * Handle the UserPosition "created" event.
     */
    public function created(UserPosition $userPosition): void
    {
        $position = $userPosition->position;
        $user = $userPosition->user;

        if (!$position || !$user) {
            return;
        }


        $role = Role::findOrCreate($position->slug, 'web');

        if ($role) {
            $user->assignRole($role);
        }
    }

    /**
     * Handle the UserPosition "updated" event.
     */
    public function updated(UserPosition $userPosition): void
    {
        $user = $userPosition->user;
        dd($user);
        if (!$user) {
            return;
        }

        if ($userPosition->wasChanged('position_id')) {
            $oldPosition = Position::findOrFail($userPosition->getOriginal('position_id'));
            // dd($oldPosition);
            if ($oldPosition) {
                $user->removeRole($oldPosition->name);
            }


            $newPosition = $userPosition->position;
            if ($newPosition) {
                $role = Role::findOrCreate($newPosition->slug, 'web');

                if ($role) {
                    $user->assignRole($role);
                }
            }
        }
    }

    /**
     * Handle the UserPosition "deleted" event.
     */
    public function deleted(UserPosition $userPosition): void
    {
        $position = $userPosition->position;
        $user = $userPosition->user;

        if ($position && $user) {
            $user->removeRole($position->slug);
        }
    }

    /**
     * Handle the UserPosition "restored" event.
     */
    public function restored(UserPosition $userPosition): void
    {
        //
    }

    /**
     * Handle the UserPosition "force deleted" event.
     */
    public function forceDeleted(UserPosition $userPosition): void
    {
        //
    }
}
