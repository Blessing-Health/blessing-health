<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[
            \Spatie\Permission\PermissionRegistrar::class
            ]->forgetCachedPermissions();

        //create permissions
        $arrayOfPermissionNames = [
            //Users
            'access_users',
            'create_users',
            'update_users',
            'delete_users',

            //Business Plans
            'access_business_plans',
            'create_business_plans',
            'update_business_plans',
            'delete_business_plans',
        ];

        $permissions = collect($arrayOfPermissionNames)->map(fn($permission) => array('name' => $permission, 'guard_name' => 'web'));
        Permission::insert($permissions->toArray());

        //create role & give it permission
        Role::create(array('name' => 'admin'))->givePermissionTo(Permission::all());
        Role::create(array('name' => 'verifier'))->givePermissionTo(array('access_users'));

        //Assign role to users
        User::first()->assignRole('admin');
    }
}
