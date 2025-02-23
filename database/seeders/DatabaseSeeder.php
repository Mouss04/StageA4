<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create Roles
        $roles = ['admin', 'visitor', 'moderator'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $role = Role::firstOrCreate(['name' => 'admin']);

        foreach (config('permission.admin-permissions-list') as $model => $actions) {

            foreach ($actions as $action) {
                $permission = Permission::firstOrCreate([
                    'name' => "$action $model",
                    'guard_name' => 'web',
                ]);
                $role->givePermissionTo($permission);
            }
        }
        $role = Role::firstOrCreate(['name' => 'visitor']);

        foreach (config('permission.visitor-permissions-list') as $model => $actions) {

            foreach ($actions as $action) {
                $permission = Permission::firstOrCreate([
                    'name' => "$action $model",
                    'guard_name' => 'web',
                ]);
                $role->givePermissionTo($permission);
            }
        }
        $role = Role::firstOrCreate(['name' => 'moderator']);

        foreach (config('permission.moderator-permissions-list') as $model => $actions) {

            foreach ($actions as $action) {
                $permission = Permission::firstOrCreate([
                    'name' => "$action $model",
                    'guard_name' => 'web',
                ]);
                $role->givePermissionTo($permission);
            }
        }

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'full_name' => 'Admin User',
                'nickname' => 'admin',
                'password' => Hash::make('password'),
                'institution' => 'Admin Institution',
                'address' => 'Admin Address',
                'country' => 'Admin Country',
                'state' => 'Admin State',
            ]
        );
        $admin->assignRole('admin');

        // Create Visitor User
        $visitor = User::firstOrCreate(
            ['email' => 'visitor@example.com'],
            [
                'full_name' => 'Visitor User',
                'nickname' => 'visitor',
                'password' => Hash::make('password'),
                'institution' => 'Visitor Institution',
                'address' => 'Visitor Address',
                'country' => 'Visitor Country',
                'state' => 'Visitor State',
            ]
        );
        $visitor->assignRole('visitor');

        $moderator = User::firstOrCreate(
            ['email' => 'moderator@example.com'],
            [
                'full_name' => 'Moderator User',
                'nickname' => 'moderator',
                'password' => Hash::make('password'),
                'institution' => 'Moderator Institution',
                'address' => 'Moderator Address',
                'country' => 'Moderator Country',
                'state' => 'Moderator State',
            ]
        );
        $moderator->assignRole('moderator');
    }
}
