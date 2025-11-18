<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PostalCodesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $timestamp = Carbon::now();

        $permissions = [
            [
                'name'       => 'postal_codes.index',
                'guard_name' => 'web',
                'group_name' => 'postal_codes',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name'       => 'postal_codes.view',
                'guard_name' => 'web',
                'group_name' => 'postal_codes',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name'       => 'postal_codes.create',
                'guard_name' => 'web',
                'group_name' => 'postal_codes',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name'       => 'postal_codes.edit',
                'guard_name' => 'web',
                'group_name' => 'postal_codes',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name'       => 'postal_codes.delete',
                'guard_name' => 'web',
                'group_name' => 'postal_codes',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                [
                    'name'       => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ],
                $permission
            );
        }
    }
}
