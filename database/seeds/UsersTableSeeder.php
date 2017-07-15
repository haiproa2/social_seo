<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        	[
        		'id' => '1',
	            'slug' => 'quanly',
	            'username' => 'quanly',
	            'email' => 'minhhai.dw@gmail.com',
	            'password' => bcrypt('123456'),
	            'name' => 'Quản Lý',
	            'telephone' => '0936242502',
	            'created_by' => '1',
	            'active' => '1',
        	],
	        [
	        	'id' => '2',
	            'slug' => 'admin',
	            'username' => 'admin',
	            'email' => 'admin@gmail.com',
	            'password' => bcrypt('123456'),
	            'name' => 'Administrator',
	            'telephone' => null,
	            'created_by' => '1',
	            'active' => '1',
	        ]
        ];

        DB::table('users')->insert($data);
    }
}
