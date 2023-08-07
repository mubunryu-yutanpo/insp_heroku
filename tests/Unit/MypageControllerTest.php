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

class MypageControllerTest extends TestCase
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
        Mail::fake();
    }

    // テストケースごとにデータベースをリセットするメソッド
    protected function tearDown(): void
    {
        parent::tearDown();
        // テストケースごとにデータベースをリセットする
    }


    // =================================================================
    // テスト：update(プロフィール編集)
    // =================================================================

    public function testUpdateProfile()
    {
        // テスト用のユーザーを作成
        $password = 'testpassword'; // ユーザー登録時に設定したパスワードをここで指定する
        $user = factory(User::class)->create([
            'password' => bcrypt($password)
        ]);
        $this->actingAs($user);

        // テスト用のリクエストデータを作成（パスワードはユーザー登録時に設定したものと同じ）
        $data = [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => $password,
            'password_confirmation' => $password,
            'introduction' => 'テスト自己紹介',
            // 画像などのパラメーターも必要に応じて追加
        ];

        // メール送信を無効化
        Mail::fake();

        // APIエンドポイントを呼び出す
        $response = $this->post('/' . $user->id . '/profEdit', $data);

        // リダイレクトされることを確認
        $response->assertRedirect('/mypage');

        // セッションにフラッシュメッセージが含まれていることを確認
        $response->assertSessionHas('flash_message', '情報を更新しました');

        // ユーザー情報が変更されていることを確認
        $updatedUser = User::find($user->id);
        $this->assertEquals('テストユーザー', $updatedUser->name);
        $this->assertEquals('test@example.com', $updatedUser->email);
        $this->assertEquals('テスト自己紹介', $updatedUser->introduction);

    }


    // =================================================================
    // テスト：destroy(退会処理)
    // =================================================================

    public function testDestroy()
    {
        // テスト用のユーザーを作成（認証済みの状態をシミュレート）
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // APIエンドポイントを呼び出す
        $response = $this->post('/' . $user->id . '/withdrow');

        // リダイレクトされることを確認
        $response->assertRedirect('/');

        // セッションにフラッシュメッセージが含まれていることを確認
        $response->assertSessionHas('flash_message', '退会しました');

        // ユーザー情報が削除されていることを確認
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

}