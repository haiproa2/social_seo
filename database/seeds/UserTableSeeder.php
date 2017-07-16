<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
        	'id' => 89,
            'slug' => 'quan-ly-20170101-000001',
            'username' => 'quanly',
            'email' => 'minhhai.dw@gmail.com',
            'password' => bcrypt('123456'),
            'name' => 'Quản lý',
            'created_by' => 89,
            'updated_by' => 89,
            'created_at' => '2017-07-01 00:00:01',
            'updated_at' => '2017-07-01 00:00:01',
            'active' => 1,
        ], [
        	'id' => 90,
            'slug' => 'admin-20170101-000002',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'name' => 'Administrator',
            'created_by' => 90,
            'updated_by' => 90,
            'created_at' => '2017-07-01 00:00:02',
            'updated_at' => '2017-07-01 00:00:02',
            'active' => 1,
        ]]);
    }
}
