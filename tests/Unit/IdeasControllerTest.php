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
    // テスト：ideaCreate(アイデア新規投稿)
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
    
    
        // データベースにデータが保存されたかを確認
        $createdIdea = Idea::where([
            'user_id' => $user->id,
            'category_id' => $data['category'],
            'title' => $data['title'],
            'thumbnail' => '/uploads/thumbnail-default.png', // デフォルトのサムネイル
            'summary' => $data['summary'],
            'description' => $data['description'],
            'price' => $data['price'],
        ])->first();

        $this->assertNotNull($createdIdea);
    }
    
    // =================================================================
    // テスト：ideaUpdate(アイデア更新)
    // =================================================================

    public function testIdeaUpdate()
    {
        // テスト用のユーザーを作成（認証済みの状態をシミュレート）
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // テスト用のリクエストデータを作成
        $data = [
            'category' => 1,
            'title' => '更新されたタイトル',
            'thumbnail' => null, // サムネイルをアップロードしない場合
            'summary' => '更新されたサマリー',
            'description' => '更新された詳細説明',
            'price' => 7000,
        ];

        // アイデアを作成してデータベースに保存
        $idea = factory(Idea::class)->create(['user_id' => $user->id]);

        // APIエンドポイントを呼び出す
        $response = $this->post('/' .$idea->id. '/idea/edit', $data); 

        // データベースにデータが更新されたかを確認
        $updatedIdea = Idea::find($idea->id);

        $this->assertEquals($data['category'], $updatedIdea->category_id);
        $this->assertEquals($data['title'], $updatedIdea->title);
        $this->assertEquals('/uploads/thumbnail-default.png', $updatedIdea->thumbnail); // サムネイルは更新されない
        $this->assertEquals($data['summary'], $updatedIdea->summary);
        $this->assertEquals($data['description'], $updatedIdea->description);
        $this->assertEquals($data['price'], $updatedIdea->price);
        
        // 成功時のリダイレクトを確認
        $response->assertRedirect('/mypage');
        $response->assertSessionHas('flash_message', '更新しました！');
    }

    // =================================================================
    // テスト：ideaDelete(アイデア削除)
    // =================================================================

    public function testIdeaDelete()
    {
        // テスト用のユーザーを作成（認証済みの状態をシミュレート）
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // アイデアを作成してデータベースに保存
        $idea = factory(Idea::class)->create(['user_id' => $user->id]);

        // 削除されるか
        $response = $this->post('/idea/' . $idea->id. '/delete');
        $response->assertRedirect('/mypage');
        $response->assertSessionHas('flash_message', '削除しました！');

    }

    // =================================================================
    // テスト：postReview(レビュー投稿)
    // =================================================================

    public function testPostReview()
    {
        // テスト用のユーザーを作成（認証済みの状態をシミュレート）
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // テスト用のアイデアを作成してデータベースに保存
        $idea = factory(Idea::class)->create();

        // レビューのテストデータ
        $data = [
            'comment' => 'テストコメント',
            'score' => 5,
        ];

        // 正常に保存されることを確認
        $response = $this->post('/'. $idea->id. '/review/create' , $data);
        $response->assertRedirect('mypage');
        $response->assertSessionHas('flash_message', 'レビューを投稿しました！');

    }

}