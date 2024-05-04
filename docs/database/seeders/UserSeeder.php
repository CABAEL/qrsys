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

        for($count = 1;$count <= 5;){

            // DB::table('clients')->insert([
            //     'user_id' => $count+1000,
            //     'client_name' => $count+1000 ."_"."client",
            //     'address' => 'test',
            //     'contact_no' => '12312312',
            //     'email'=> '12312312',
            //     'description'=> '12312312',
            //     'logo'=> '12312312',
            //     'created_by' => 1
            // ]);

            $db = DB::table('users')->insert
            (
                [
                'username' => 'admin'.$count,
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'created_by' => $count
                ],
            );

            if($db){
                DB::table('admin_users')->insert
                (
                    [
                    'user_id' => $count,
                    'picture' => "",
                    'fname' => 'fnameadmin_'.$count,
                    'mname' => 'mnameadmin_'.$count,
                    'lname' => 'lnameadmin_'.$count,
                    'contact_no' => "0909090909090909",
                    'email' => $count.'_sampleEmail@gmail.com',
                    'address' => 'address_'.$count,
                    'description' => 'sample sample_'.$count,
                    'created_by' => $count
                    ],
                );
            }

            $count++;
        }



    }
}
