<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
         |--------------------------------------------------------------------------
         | 1. Create Permissions (with group_name)
         |--------------------------------------------------------------------------
         */
        $permissions = [
            'courses' => [
                'view courses',
                'create courses',
                'edit courses',
                'delete courses',
            ],

            'requirements' => [
                'add requirements',
                'delete requirements',
            ],

            'trainings' => [
                'view trainings',
                'manage trainings',
            ],

            'users' => [
                'manage users',
            ],
        ];

        foreach ($permissions as $group => $perms) {
            foreach ($perms as $permissionName) {
                Permission::firstOrCreate(
                    [
                        'name'       => $permissionName,
                        'guard_name' => 'web',
                    ],
                    [
                        'group_name' => $group,
                    ]
                );
            }
        }

        /*
         |--------------------------------------------------------------------------
         | 2. Create Roles (including student)
         |--------------------------------------------------------------------------
         */
        $roles = [
            'hod',
            'campus_registrar',
            'kihbt_registrar',
            'director',
            'student', // 👈 added
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        /*
         |--------------------------------------------------------------------------
         | 3. Assign Permissions To Each Role
         |--------------------------------------------------------------------------
         */
        $hod = Role::findByName('hod');
        $hod->syncPermissions([
            'view courses',
            'create courses',
            'edit courses',
            'view trainings',
            'add requirements',
        ]);

        $campusRegistrar = Role::findByName('campus_registrar');
        $campusRegistrar->syncPermissions([
            'view courses',
            'view trainings',
            'manage trainings',
        ]);

        $kihbtRegistrar = Role::findByName('kihbt_registrar');
        $kihbtRegistrar->syncPermissions([
            'view courses',
            'view trainings',
            'manage trainings',
            'manage users',
        ]);

        $director = Role::findByName('director');
        $director->syncPermissions(Permission::all()); // Director has everything

        // Optionally: student has no special permissions (portal-only user)
        // $student = Role::findByName('student');
        // $student->syncPermissions([]); // or give read-only permissions if you wish

        echo "Roles and Permissions seeded successfully.\n";
    }
}
