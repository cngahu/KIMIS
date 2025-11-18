<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class SubcountyPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $timestamp = Carbon::now();

        $permissions = [
            [
                'name'       => 'subcounty.index',
                'guard_name' => 'web',
                'group_name' => 'subcounty',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name'       => 'subcounty.view',
                'guard_name' => 'web',
                'group_name' => 'subcounty',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name'       => 'subcounty.create',
                'guard_name' => 'web',
                'group_name' => 'subcounty',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name'       => 'subcounty.edit',
                'guard_name' => 'web',
                'group_name' => 'subcounty',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name'       => 'subcounty.delete',
                'guard_name' => 'web',
                'group_name' => 'subcounty',
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
