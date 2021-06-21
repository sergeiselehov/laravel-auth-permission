<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Create permissions
        Permission::create(['name' => 'list']);
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);

        //Create roles and assign existing permissions
        $client = Role::create(['name' => 'client']);

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo('list');

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo('list');
        $admin->givePermissionTo('create');
        $admin->givePermissionTo('edit');
        $admin->givePermissionTo('delete');

        //Create users
        $user = \App\Models\User::factory()->create([
            'name' => 'Example Client User',
            'email' => 'client@example.com',
            'password' => '11111111',
        ]);
        $user->assignRole($client);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Manager User',
            'email' => 'manager@example.com',
            'password' => '11111111',
        ]);
        $user->assignRole($manager);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
            'password' => '11111111',
        ]);
        $user->assignRole($admin);
    }
}
