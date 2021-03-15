<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
                'status' => 1,
                'email' => 'dsntesic@gmail.com',
                'password' => \Hash::make('admin'),
                'name' => 'Dušan Tešić',
                'phone' => '+38164111111',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),            
        ]); 
        DB::table('users')->insert([
                'status' => 1,
                'email' => 'peric@gmail.com',
                'password' => \Hash::make('admin'),
                'name' => 'Petar Perić',
                'phone' => '+38164222222',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),            
        ]); 
        DB::table('users')->insert([
                'status' => 1,
                'email' => 'markovic@gmail.com',
                'password' => \Hash::make('admin'),
                'name' => 'Marko Marković',
                'phone' => '+381643333333',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),            
        ]); 
        DB::table('users')->insert([
                'status' => 1,
                'email' => 'bojanic@gmail.com',
                'password' => \Hash::make('admin'),
                'name' => 'Bojana Bojanić',
                'phone' => '+3816444444',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),            
        ]); 
        DB::table('users')->insert([
                'status' => 1,
                'email' => 'miljkovic@gmail.com',
                'password' => \Hash::make('admin'),
                'name' => 'Marija Miljković',
                'phone' => '+38164555555',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),            
        ]);         
    }
}
