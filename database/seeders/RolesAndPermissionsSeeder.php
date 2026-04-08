<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $super_admin = Role::updateOrCreate(['name' => 'super_admin'])->givePermissionTo(Permission::all());
        
        $super_admin_user = \App\Models\User::inRandomOrder()->first();

        $super_admin_user->update([
            'name' => 'super_admin',
            'email' => 'super_admin@gmail.com'
        ]);

        $super_admin_user->assignRole('super_admin');

        \App\Models\User::findOrFail(2)?->assignRole('author');
    }
}
