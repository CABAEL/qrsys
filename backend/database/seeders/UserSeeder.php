<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($count = 0;$count <= 5;){

            $db = DB::table('users')->insert
            (
                [
                'username' => 'admin'.$count,
                'password' => Hash::make('admin'),
                'role' => 'admin',
                ],
            );

            if($db){
                DB::table('clients')->insert
                (
                    [
                    'user_id' => $count,
                    'client_name' => 'admin_'.$count,
                    'contact_no' => '1212111',
                    'email' => 'vallesmark15@gmail.com',
                    'address' => 'vallesmark15@gmail.com',
                    'description' => 'sample sample',
                    ],
                );
            }

            $count++;
        }



    }
}
