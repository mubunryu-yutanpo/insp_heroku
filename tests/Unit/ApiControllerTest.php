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
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiControllerTest extends TestCase
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
        $this->faker = Faker::create();
        // テスト用のデータをセットアップする
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
    // テスト：topIdeas（TOPページのアイデア一覧取得）
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
    // テスト： mypage
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
    // テスト： avatar（アバター情報取得）
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
    // テスト： ideaDetail(アイデア詳細）
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

    // =================================================================
    // テスト： checks(気になる一覧）
    // =================================================================

    public function testChecks()
    {
        // テスト用のデータをセットアップする
        $user = factory(User::class)->create();
        $user_id = $user->id;
        factory(Check::class, 10)->create([
            'user_id' => $user_id,
            'idea_id' => $this->ideas->random()->id,
        ]);

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/'.$user_id.'/checks');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'checkIdeas',
        ]);
    }


    // =================================================================
    // テスト： boughts(購入済み一覧)
    // =================================================================

    public function testBoughts()
    {
        // テスト用のデータをセットアップする
        $user = factory(User::class)->create();
        $user_id = $user->id;
        $boughts = factory(Purchase::class, 5)->create([
            'user_id' => $user->id,
        ]);

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/'.$user_id.'/boughts');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'boughtList',
        ]);
    }

    // =================================================================
    // テスト： myPosts(投稿済み一覧)
    // =================================================================

    public function testMyPosts()
    {
        // テスト用のデータをセットアップする
        $user = factory(User::class)->create();
        $user_id = $user->id;
        $posts = factory(Idea::class, 5)->create([
            'user_id' => $user->id,
        ]);

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/'.$user_id.'/myPosts/');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'postsList',
        ]);
    }

    // =================================================================
    // テスト： reviews（全てのレビュー）
    // =================================================================

    public function testReviews()
    {
        // テスト用のデータをセットアップする
        $reviews = factory(Review::class, 5)->create([
            'comment' => substr($this->faker->sentence, 0, 255), // 255文字までに制限
        ]);
        $idea = factory(Idea::class)->create();
        $idea_id = $idea->id;

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/'.$idea_id.'/reviews');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'reviewList',
        ]);
    }

    // =================================================================
    // テスト： myReviews(自分のアイデアに対するレビュー一覧）
    // =================================================================

    public function testMyReviews()
    {
        // テスト用のデータをセットアップする
        $user = factory(User::class)->create();
        $user_id = $user->id;
        $ideas = factory(Idea::class, 3)->create(['user_id' => $user->id]);
        $reviews = factory(Review::class, 5)->create([
            'user_id' => $user->id,
            'idea_id' => $ideas->first()->id,
            'comment' => 'Short comment', // 適切な長さの値を指定する
        ]);

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/'.$user_id.'/reviews');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'reviewList',
        ]);
    }


    // =================================================================
    // テスト： ideaReviews(特定のアイデアに対するレビュー一覧）
    // =================================================================


    public function testIdeaReviews()
    {
        // テスト用のデータをセットアップする
        $idea = factory(Idea::class)->create();
        $idea_id = $idea->id;
        
        // 適切な長さのコメントを生成する
        $reviewData = [
            'idea_id' => $idea->id,
            'comment' => $this->faker->text(100), // 最大100文字のランダムなテキストを生成
            'score' => $this->faker->numberBetween(1, 5),
        ];
        $reviews = factory(Review::class, 5)->create($reviewData);
    
        // APIエンドポイントを呼び出す
        $response = $this->get('/api/idea/'.$idea_id.'/reviews');
    
        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);
    
        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'reviewList',
        ]);
    }
    
    // =================================================================
    // テスト： toggleCheck(気になるの状態チェンジ)
    // =================================================================


    public function testToggleCheck()
    {
        // テスト用のユーザーを作成（認証済みの状態をシミュレート）
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // チェック済みのアイデアを作成
        $checkedIdea = factory(Idea::class)->create();
        $check = factory(Check::class)->create([
            'user_id' => $user->id,
            'idea_id' => $checkedIdea->id,
        ]);

        // 未チェックのアイデアを作成
        $uncheckedIdea = factory(Idea::class)->create();

        // 1. チェック済みのアイデアを解除する動作をテスト
        $response = $this->withHeaders(['X-CSRF-TOKEN' => csrf_token()])
            ->post('/api/idea/' . $checkedIdea->id . '/toggleCheck');
        $response->assertStatus(200);
        $this->assertDatabaseMissing('checks', [
            'user_id' => $user->id,
            'idea_id' => $checkedIdea->id,
        ]);

        // 2. 未チェックのアイデアをチェックする動作をテスト
        $response = $this->withHeaders(['X-CSRF-TOKEN' => csrf_token()])
            ->post('/api/idea/' . $uncheckedIdea->id . '/toggleCheck');
        $response->assertStatus(200);
        $this->assertDatabaseHas('checks', [
            'user_id' => $user->id,
            'idea_id' => $uncheckedIdea->id,
        ]);

        // 3. 不正な操作（数値でない引数）をした場合にリダイレクトする動作をテスト
        $response = $this->post('/api/idea/invalid_id/toggleCheck');
        $response->assertRedirect('/');
        $response->assertSessionHas('flash_message', __('不正な操作が行われました'));

    }

    // =================================================================
    // テスト： getAverage（平均点取得）
    // =================================================================

    public function testGetAverage()
    {
        // 1. レビューが存在しない場合
        $idea = factory(Idea::class)->create();
        $response = $this->get('/api/idea/' . $idea->id . '/average');
        $response->assertStatus(200);
        $response->assertJson(['averageScore' => 0]);

        // 2. レビューが存在する場合
        $user = factory(User::class)->create();
        $reviews = factory(Review::class, 5)->create([
            'idea_id' => $idea->id,
            'score' => 4,
            'comment' => substr('Dolorum incidunt at tempora voluptatum consectetur ex. Ipsam modi necessitatibus non architecto praesentium esse. Officia nobis voluptate totam harum itaque incidunt nam. Nostrum id neque quibusdam odit harum dicta blanditiis aut. Architecto similique expedita veritatis asperiores fuga in veniam.', 0, 255),        ]);
        $response = $this->get('/api/idea/' . $idea->id . '/average');
        $response->assertStatus(200);
        $response->assertJson(['averageScore' => 4]);
    }

    // =================================================================
    // テスト： buy(アイデア購入）
    // =================================================================

    public function testBuyIdea()
    {
        // メール送信をモック化
        Mail::fake();

        // テスト用のユーザーを作成（認証済みの状態をシミュレート）
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // 購入するアイデアを作成
        $idea = factory(Idea::class)->create();

        // アイデアを購入する動作をテスト
        $response = $this->get('api/idea/' . $idea->id . '/buy');
        $response->assertRedirect('/');
        $response->assertSessionHasNoErrors();

        // データベースに購入データとチャットデータが保存されていることを確認
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'idea_id' => $idea->id,
        ]);

        $this->assertDatabaseHas('chats', [
            'buyer_id' => $user->id,
            'seller_id' => $idea->user_id,
            'idea_id' => $idea->id,
        ]);

    }


    // =================================================================
    // テスト： message（メッセージ情報取得）
    // =================================================================

    public function testMessage()
    {
        // テスト用のデータをセットアップする
        $seller = factory(User::class)->create();
        $buyer = factory(User::class)->create();
        $idea = factory(Idea::class)->create(['user_id' => $seller->id]);
        $chat = factory(Chat::class)->create([
            'idea_id' => $idea->id,
            'seller_id' => $seller->id,
            'buyer_id' => $buyer->id,
        ]);
        // Purchaseモデルのファクトリーを利用して$purchaseを作成する
        $purchase = factory(Purchase::class)->create([
            'idea_id' => $idea->id,
            'user_id' => $buyer->id,
        ]);
        $messages = factory(Message::class, 3)->create(['chat_id' => $chat->id]);
    
        // テスト用のユーザーを認証済みの状態にする
        $this->actingAs($buyer);
    
        // APIエンドポイントを呼び出す
        $response = $this->get('/api/message/' . $idea->id . '/' . $seller->id . '/' . $buyer->id);
    
        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);
    
        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'seller',
            'buyer',
            'messages',
            'chat_id',
        ]);
    }
    
    // =================================================================
    // テスト： addMessage（メッセージ＆通知追加）
    // =================================================================

    public function testAddMessage()
    {
        // テスト用のデータをセットアップする
        $seller = factory(User::class)->create();
        $buyer = factory(User::class)->create();
        $idea = factory(Idea::class)->create(['user_id' => $seller->id]);
        $chat = factory(Chat::class)->create([
            'idea_id' => $idea->id,
            'seller_id' => $seller->id,
            'buyer_id' => $buyer->id,
        ]);
    
        // テスト用の認証済みユーザーを作成する
        $this->actingAs($seller);
    
        // テスト用のリクエストデータを生成する
        $data = [
            'content' => $this->faker->sentence,
        ];
    
        // APIエンドポイントを呼び出す
        $response = $this->post('/api/message/' . $chat->id . '/' . $buyer->id, $data, ['Accept' => 'application/json']);
    
        // 期待されるレスポンスコードが返ってきたかを確認
        //$response->assertStatus(302);
    
        // メッセージが正しく保存されたかを確認
        $this->assertDatabaseHas('messages', [
            'user_id' => $seller->id,
            'chat_id' => $chat->id,
            'content' => $data['content'],
        ]);
    
        // 通知が正しく保存されたかを確認
        $this->assertDatabaseHas('notifications', [
            'receiver_id' => $buyer->id,
            'sender_id' => $seller->id,
            'chat_id' => $chat->id,
            'content' => $data['content'],
        ]);
    }

    // =================================================================
    // テスト： markAsRead(通知の既読化）
    // =================================================================

    public function testMarkAsRead()
    {
        // テスト用のユーザーを作成して認証済みにする
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // テスト用の通知を作成
        $notification = factory(Notification::class)->create();

        // 通知を未読状態にしておくことを確認
        $this->assertFalse($notification->read);

        // markAsReadメソッドを呼び出す
        $this->post('/api/' . $notification->id . '/markAsRead');

        // データベースに変更が正しく保存されたかをアサート
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'read' => true,
        ]);
    }

    // =================================================================
    // テスト： getNotification(通知情報取得）
    // =================================================================


    public function testGetNotification()
    {
        // テスト用のユーザーを作成
        $user = factory(User::class)->create();

        // テスト用の通知を作成（通知はチャット情報をひも付けるため、先にチャットも作成）
        $chat = factory(Chat::class)->create();
        $notification = factory(Notification::class)->create([
            'receiver_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        // APIエンドポイントを呼び出す
        $response = $this->get('api/'. $user->id. '/notifications');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'notificationList',
        ]);
    }


    // =================================================================
    // テスト： userInfo(ユーザーに紐づくアイデア一覧)
    // =================================================================

    public function testUserIdeas()
    {
        // テスト用のユーザーを作成
        $user = factory(User::class)->create();

        // テスト用のカテゴリを作成
        $category = factory(Category::class)->create();

        // テスト用のアイデアを作成
        $idea = factory(Idea::class)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        // テスト用のレビューを作成
        $review = factory(Review::class)->create([
            'idea_id' => $idea->id,
        ]);

        // APIエンドポイントを呼び出す
        $response = $this->get('api/'. $user->id .'/userInfo');

        // 期待されるレスポンスコードが返ってきたかを確認
        $response->assertStatus(200);

        // 期待されるJSONデータが返ってきたかを確認
        $response->assertJsonStructure([
            'ideaList',
        ]);
    }
}

// phpunitのパス問題
// 「echo "export PATH=\$HOME/.composer/vendor/bin:\$PATH" >> ~/.bash_profile」
// 「source ~/.bash_profile」