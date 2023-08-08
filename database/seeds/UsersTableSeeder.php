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
        // デフォルトデータを挿入
        $users = [
            [
                'name' => 'test花子',
                'email' => 'hanako@test.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'テスト太郎',
                'email' => 'taro@test.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // データベースにユーザーデータを挿入
        DB::table('users')->insert($users);
    }
}
