<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin Add
        DB::table('users')->insert([

            [
                'surname'=>'Admin',
                'firstname'=>'',
                'othername'=>'',
                'title_id'=>1,
                'gender_id'=>1,
                'country_id'=>1,
                'nationality'=>1,
                'county'=>1,

                'username'=>'Admin',
                'email'=>'admin@gmail.com',
                'password'=>Hash::make('password'),

                'userrole'=>'admin',
                'status'=>'active',

            ],
            [
                'surname'=>'Vendor',
                'firstname'=>'',
                'othername'=>'',
                'title_id'=>1,
                'gender_id'=>1,
                'country_id'=>1,
                'nationality'=>1,
                'county'=>1,
                'username'=>'Vendor',
                'email'=>'vendor@gmail.com',
                'password'=>Hash::make('password'),
                'userrole'=>'vendor',
                'status'=>'active',
            ],
            [
                'surname'=>'User',
                'username'=>'User',
                'firstname'=>'',
                'othername'=>'',
                'title_id'=>1,
                'gender_id'=>1,
                'country_id'=>1,
                'nationality'=>1,
                'county'=>1,
                'email'=>'user@gmail.com',
                'password'=>Hash::make('password'),
                'userrole'=>'user',
                'status'=>'active',
            ]
        ]);
    }
}
