<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_data')->table('options')->insert([[
            'type' => 'active',
            'id_type' => '0',
            'value_type' => '<span class="label">Tạm khóa</span>',
            'created_at' => '2017-07-01 00:00:01',
            'updated_at' => '2017-07-01 00:00:01',
            'active' => 1,
        ], [
            'type' => 'active',
            'id_type' => '1',
            'value_type' => '<span class="label label-success">Đang hoạt động</span>',
            'created_at' => '2017-07-01 00:00:01',
            'updated_at' => '2017-07-01 00:00:01',
            'active' => 1,
        ], [
            'type' => 'sex',
            'id_type' => '0',
            'value_type' => 'Nữ',
            'created_at' => '2017-07-01 00:00:01',
            'updated_at' => '2017-07-01 00:00:01',
            'active' => 1,
        ], [
            'type' => 'sex',
            'id_type' => '1',
            'value_type' => 'Nam',
            'created_at' => '2017-07-01 00:00:01',
            'updated_at' => '2017-07-01 00:00:01',
            'active' => 1,
        ]]);
    }
}
