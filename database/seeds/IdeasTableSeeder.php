<?php

use Illuminate\Database\Seeder;

class IdeasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // デフォルトデータを挿入
        $ideas = [
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => '【急募！】魔法少女',
                'thumbnail' => '/uploads/img18.png',
                'summary' => '未経験歓迎！　誰でも最短3ヶ月で憧れの魔法少女になれます！',
                'description' => '年齢制限あり。高待遇補償。独自のメソッドで、完全未経験の方でも即戦力級の魔法少女になれます。',
                'price' => 4000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'title' => '第3回　夏の大運動会についてのご連絡',
                'thumbnail' => '/uploads/img24.jpg',
                'summary' => 'さぁ、いこう。',
                'description' => 'この夏、君たちはどこへ向かうのか。共に行こう、あの高みへ。',
                'price' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'category_id' => 6,
                'title' => 'バナー作ります',
                'thumbnail' => '/uploads/img19.png',
                'summary' => 'サムネのようなバナーを格安で作ります。',
                'description' => 'という仕事をしたいな。と思っています。どなたかご教授ください。',
                'price' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];
                
        // データベースにデータを挿入
        DB::table('ideas')->insert($ideas);
    }
    
}
