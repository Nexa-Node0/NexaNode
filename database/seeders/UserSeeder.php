<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create super admin account
        $super_admin = User::firstOrCreate([
            'email' => 'superadmin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('superadmin'),
            ]);

        //attach a role for super admin
        Role::create(['name' => 'super_admin']);
        $super_admin->assignRole('super_admin');

        //Create an admin account
        $admin = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin123'),
            ]);

        //attach a role for admin
        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        //Create a fake users
        User::factory(10)->create();

        //Create unverified fake accounts
        User::factory(5)->unverified()->create();
    }
}
