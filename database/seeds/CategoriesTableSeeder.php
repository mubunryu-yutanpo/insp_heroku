<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // デフォルトデータを挿入
        $categories = [
            ['name' => 'マッチング'],
            ['name' => '掲示板'],
            ['name' => 'SNS'],
            ['name' => 'シェアリング'],
            ['name' => 'ECサイト'],
            ['name' => '情報配信'],
            ['name' => 'その他'],
        ];

        DB::table('categories')->insert($categories);
    }
}
