<?php

use Illuminate\Database\Seeder;

class EntrustPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([[
        	'id' => 1,
            'name' => 'root',
            'display_name' => '<span class="label label-inverse">Root</span>',
            'description' => 'Nhóm tài khoản quan trọng, không thể xóa.',
            'created_at' => '2017-07-02 00:00:01',
            'updated_at' => '2017-07-02 00:00:01'
        ], [
        	'id' => 2,
            'name' => 'admin',
            'display_name' => '<span class="label label-important">Administrator</span>',
            'description' => 'Nhóm tài khoản có toàn quyền trên hệ thống.',
            'created_at' => '2017-07-02 00:00:01',
            'updated_at' => '2017-07-02 00:00:01'
        ], [
        	'id' => 3,
            'name' => 'author',
            'display_name' => '<span class="label label-info">Author</span>',
            'description' => 'Nhóm tài khoản có quyền quản lý dữ liệu trong hệ thống.',
            'created_at' => '2017-07-02 00:00:01',
            'updated_at' => '2017-07-02 00:00:01'
        ], [
        	'id' => 4,
            'name' => 'member',
            'display_name' => '<span class="label">Member</span>',
            'description' => 'Nhóm tài khoản mới đăng ký, chưa có quyền gì trong trang quản trị.',
            'created_at' => '2017-07-02 00:00:01',
            'updated_at' => '2017-07-02 00:00:01'
        ], [
        	'id' => 5,
            'name' => 'vip',
            'display_name' => '<span class="label label-success">VIP</span>',
            'description' => 'Nhóm tài khoản trả tiền, được quản lý bài viết, nội dung riêng của mình.',
            'created_at' => '2017-07-02 00:00:01',
            'updated_at' => '2017-07-02 00:00:01'
        ]]);
        DB::table('role_user')->insert([[
            'user_id' => 89,
            'role_id' => 1
        ]]);
    }
}
