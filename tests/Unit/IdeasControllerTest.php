<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Requests\ValidRequest;
use App\Http\Controllers\IdeasController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Category;
use App\Check;
use App\Idea;
use App\Purchase;
use App\Review;
use App\Chat;
use App\Message;
use App\Notification;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IdeasControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $faker;
    protected $preserveGlobalState = false;

    // テスト用のデータをセットアップするメソッド
    protected function setUp(): void
    {
        parent::setUp();
        // テスト用のデータをここでセットアップする
        $this->ideas = factory(Idea::class, 5)->create();
        // カテゴリーテーブルにデータを挿入
        factory(Category::class)->create(['id' => 1, 'name' => 'テスト']);
        $this->faker = Faker::create();
        $this->seller = factory(User::class)->create();
        $this->buyer = factory(User::class)->create();
        $this->idea = factory(Idea::class)->create(['user_id' => $this->seller->id]);
        $this->chat = factory(Chat::class)->create([
            'idea_id' => $this->idea->id,
            'seller_id' => $this->seller->id,
            'buyer_id' => $this->buyer->id,
        ]);
    }

    // テストケースごとにデータベースをリセットするメソッド
    protected function tearDown(): void
    {
        parent::tearDown();
        // テストケースごとにデータベースをリセットする
    }


    // =================================================================
    // テスト：ApiController/ ideaCreateメソッド
    // =================================================================

    public function testIdeaCreate()
    {
        // テスト用のユーザーを作成（認証済みの状態をシミュレート）
        $user = factory(User::class)->create();
        $this->actingAs($user);
    
        // テスト用のリクエストデータを作成
        $data = [
            'user_id' => $user->id,
            'category' => 1,
            'title' => 'テストアイデアのタイトル',
            'thumbnail' => null, // サムネイルをアップロードしない場合
            'summary' => 'テストアイデアのサマリー',
            'description' => 'テストアイデアの詳細説明',
            'price' => 5000,
        ];
    
        // APIエンドポイントを呼び出す
        $response = $this->post('/new', $data); // 第二引数にリクエストデータを渡す
    
        // 期待されるリダイレクトが返ってきたかを確認
        //$response->assertRedirect('mypage');
    
        // データベースにデータが保存されたかを確認
        $createdIdea = Idea::where([
            'user_id' => $user->id,
            // 'category_id' => $data['category'],
            // 'title' => $data['title'],
            // 'thumbnail' => '/uploads/thumbnail-default.png', // デフォルトのサムネイル
            // 'summary' => $data['summary'],
            // 'description' => $data['description'],
            // 'price' => $data['price'],
        ])->first();

        //dd($data);

        $this->assertNotNull($createdIdea);
    
    }
    
    

}