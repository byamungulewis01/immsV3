<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'create employee',
                'activity_id' => 4,
                'guard_name' => 'web',
            ],
            [
                'name' => 'read employee',
                'activity_id' => 4,
                'guard_name' => 'web',
            ],
            [
                'name' => 'update employee',
                'activity_id' => 4,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete employee',
                'activity_id' => 2,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create branch',
                'activity_id' => 1,
                'guard_name' => 'web',
            ],
            [
                'name' => 'read branch',
                'activity_id' => 1,
                'guard_name' => 'web',
            ],
            [
                'name' => 'update branch',
                'activity_id' => 1,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete branch',
                'activity_id' => 1,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create role',
                'activity_id' => 4,
                'guard_name' => 'web',
            ],
            [
                'name' => 'read role',
                'activity_id' => 4,
                'guard_name' => 'web',
            ],
            [
                'name' => 'update role',
                'activity_id' => 4,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete role',
                'activity_id' => 4,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create permission',
                'activity_id' => 2,
                'guard_name' => 'web',
            ],
            [
                'name' => 'read permission',
                'activity_id' => 1,
                'guard_name' => 'web',
            ],
            [
                'name' => 'update permission',
                'activity_id' => 2,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete permission',
                'activity_id' => 2,
                'guard_name' => 'web',
            ],

        ];

        $roles = [
            [
                'name' => 'super admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        foreach ($roles as $role) {
            Role::create($role);
        }

        $superAdmin = Role::findByName('super admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'create employee',
            'read employee',
            'update employee',
            'delete employee',
            'create branch',
            'read branch',
            'update branch',
            'delete branch',
            'create role',
            'read role',
            'update role',
            'delete role',
            'create permission',
            'read permission',
            'update permission',
            'delete permission',
        ]);
    }
}
