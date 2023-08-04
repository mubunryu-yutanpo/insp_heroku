<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use App\Category;
use App\Check;
use App\Idea;
use App\Purchase;
use App\Review;
use App\Chat;
use App\Message;
use App\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    // テスト用のデータをセットアップするメソッド
    protected function setUp(): void
    {
        parent::setUp();
        // テスト用のデータをここでセットアップする
    }

    // テストケースごとにデータベースをリセットするメソッド
    protected function tearDown(): void
    {
        parent::tearDown();
        // テストケースごとにデータベースをリセットする
    }

    // =================================================================
    // テスト：トップページのアイデア一覧取得メソッド
    // =================================================================

    public function testTopIdeas()
    {
        // テスト用のデータをセットアップする

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/home/ideas');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'ideaList',
        ]);
    }

    // =================================================================
    // テスト：マイページ情報取得メソッド
    // =================================================================

    public function testMypage(){
        
        // テスト用のユーザーアカウントを作成し、ログインしている状態にする
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/mypage');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'user',
            'checkList',
            'postList',
            'boughtList',
            'reviewList',
            'notificationList',
        ]);
    }

    // =================================================================
    // テスト：ユーザーのアバター情報取得メソッド
    // =================================================================

    public function testAvatar(){
        
        // テスト用のユーザーアカウントを作成し、ログインしている状態にする
        $user = factory(User::class)->create();
        $user_id = $user->id;
        $this->actingAs($user);

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/' .$user_id. '/avatar');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'avatar',
        ]);
    }

    // =================================================================
    // テスト：アイデア詳細情報取得メソッド
    // =================================================================

    public function testIdeaDetail(){

        // テスト用のアイデアを作成し、そのIDを取得する
        $idea = factory(Idea::class)->create();
        $id = $idea->id;

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/idea/{id}/detail');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'idea',
            'canBuy',
            'reviews',
            'averageScore',
            'isChecked',
            'user_id',
            'seller_id',
            'seller_name',
            'seller_avatar',
            'bought',
        ]);

    }

}

// phpunitのパス問題
// 「echo "export PATH=\$HOME/.composer/vendor/bin:\$PATH" >> ~/.bash_profile」
// 「source ~/.bash_profile」