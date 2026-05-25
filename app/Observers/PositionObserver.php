<?php

namespace App\Observers;

use App\Models\Position;
use App\Models\UserPosition;
use Spatie\Permission\Models\Role;

class PositionObserver
{
    /**
     * Handle the Position "created" event.
     */
    public function created(Position $position): void
    {
        $role = Role::firstOrCreate([
            'name'       => $position->slug,
            'guard_name' => 'web'
        ]);

        if ($position->permissions) {
            $role->syncPermissions($position->permissions);
        }
    }

    /**
     * Handle the Position "updated" event.
     */
    public function updated(Position $position): void
    {
        if (!$position->wasChanged('permissions')) {
            return;
        }

        $role = Role::findByName($position->slug, 'web');

        $role->syncPermissions($position->permissions ?? []);

        UserPosition::where('position_id', $position->id)
            ->with('user')
            ->get()
            ->each(function (UserPosition $userPosition) use ($position) {
                $userPosition->user?->syncRoles([$position->name]);
            });
    }

    /**  
     * Handle the Position "deleted" event.
     */
    public function deleted(Position $position): void
    {
        $role = Role::findByName($position->name, 'web');
        $role?->delete();
    }

    /**
     * Handle the Position "restored" event.
     */
    public function restored(Position $position): void
    {
        //
    }

    /**
     * Handle the Position "force deleted" event.
     */
    public function forceDeleted(Position $position): void
    {
        //
    }
}
