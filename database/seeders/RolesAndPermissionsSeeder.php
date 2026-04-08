<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $defaultRoles = [
            ['super_admin', 0], 
            ['admin', 1], 
            ['author', 2]
        ];
       
        foreach($defaultRoles as $roleData){

            $role = $roleData[0];
            $accessLevel = $roleData[1];

            $rolePermission = Role::updateOrCreate(['name' => $role]);
            
            if($accessLevel == 0){
                $rolePermission->givePermissionTo(Permission::all());
            }
            
           User::create([
                'name'     => $role,
                'email'    => "$role@nexanode.com",
                'password' => Hash::make('password')
            ])->assignRole($role);
        }
    }
}
