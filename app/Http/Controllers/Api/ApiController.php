<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidRequest;
use App\User;
use App\Category;
use App\Check;
use App\Idea;
use App\Purchase;
use App\Review;
use App\Chat;
use App\Message;
use App\Notification;


class ApiController extends Controller
{

    /* ================================================================
      マイページ情報取得
    ================================================================*/

    public function mypage(){
        $user = Auth::user();
        $user_id = $user->id;

        // -- 気になるリスト取得 --

        $checkList = [];
        // 気になるのデータを最新5件まで取得
        $checks = Check::where('user_id', $user_id)
                  ->orderBy('created_at', 'desc')
                  ->limit(5)
                  ->get();

        if($checks->isNotEmpty()){
            $idea_id = $checks->pluck('idea_id')->toArray();
            $checkList = Idea::whereIn('id', $idea_id)->with('category','review')->get();
        }

        // -- 投稿したアイデア取得 --

        $postList = [];
        // 投稿したアイデアを最新の5件まで取得
        $posts = Idea::where('user_id', $user_id)
                 ->orderBy('created_at', 'desc')
                 ->limit(5)
                 ->get();

        if($posts->isNotEmpty()){
            $postList = $posts->load('category','review');
        }
        
        // -- 購入したアイデア取得 --
        
        $boughtList = [];
        $purchases = Purchase::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        if ($purchases->isNotEmpty()) {
            $ideaIds = $purchases->pluck('idea_id')->toArray();
            $boughtList = Idea::whereIn('id', $ideaIds)
                ->with('category','review')
                ->get();
        }        
        // -- レビュー取得 --
        
        $reviewList = [];

        $reviews = Review::whereHas('idea', function ($query) use ($user) {
                $query->where('user_id', $user->id); // ユーザーが所有するアイデアに関連するレビューを取得
            })
            ->with(['idea', 'user'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        if ($reviews->isNotEmpty()) {
            $reviewList = $reviews;
        }


        // 通知情報を取得        
        $notifications = Notification::where('receiver_id', $user_id)
                        ->where('read', false)
                        ->get();

        if ($notifications->isNotEmpty()) {
            $senderIds = $notifications->pluck('sender_id')->toArray();
            $senders = User::whereIn('id', $senderIds)->get();

            // メッセージ送信者のnameを取得し、sender_nameとして追加
            $notificationList = $notifications->map(function ($notification) use ($senders) {
                $sender = $senders->firstWhere('id', $notification->sender_id);
                if ($sender) {
                    $notification->sender_name = $sender->name; 
                }
                return $notification;
            });
        }


        $data = [
            'user'             => $user,
            'checkList'        => $checkList,
            'postList'         => $postList,
            'boughtList'       => $boughtList,
            'reviewList'       => $reviewList,
            'notificationList' => $notificationList,
        ];
        
        return response()->json($data);
    }
    

    /* ================================================================
      アバター情報取得
    ================================================================*/

    public function avatar($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $avatar = User::where('id', $id)->value('avatar');

        $data = [
            'avatar' => $avatar,
        ];

        return response()->json($data);
    }

    
    /* ================================================================
      アイデア一覧取得
    ================================================================*/

    public function ideas(Request $request)
    {
        $query = Idea::query();
    
        // カテゴリ絞り込み
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
    
        // 価格絞り込み
        if ($request->has('price')) {
            $priceOrder = $request->input('price');
    
            if ($priceOrder === 'low') {
                $query->orderBy('price', 'asc');
            } elseif ($priceOrder === 'high') {
                $query->orderBy('price', 'desc');
            }
        }
    
        // 投稿日絞り込み
        if ($request->has('date')) {
            $dateOrder = $request->input('date');
    
            if ($dateOrder === 'new') {
                $query->orderBy('created_at', 'desc');
            } elseif ($dateOrder === 'old') {
                $query->orderBy('created_at', 'asc');
            }
        }
    
        $ideas = $query->get();

        // User 情報の取得
        $userIds = $ideas->pluck('user_id')->unique();
        $users = User::whereIn('id', $userIds)->get();
    
        // カテゴリ情報の取得
        $categoryIds = $ideas->pluck('category_id')->unique();
        $categories = Category::whereIn('id', $categoryIds)->get();
    
        // レビュー情報の取得
        $ideaIds = $ideas->pluck('id')->unique();
        $reviews = Review::whereIn('idea_id', $ideaIds)->get();
    
        // User 情報をアイデアに結合
        $ideasWithUser = $ideas->map(function ($idea) use ($users) {
            $user = $users->firstWhere('id', $idea->user_id);
            $idea->user = $user;
            return $idea;
        });

        if(Auth::check()){
            $checkRecords = Check::where('user_id', auth()->id())
            ->whereIn('idea_id', $ideaIds)
            ->get();

            $ideasWithCheck = $ideasWithUser->map(function ($idea) use ($checkRecords) {
                $check = $checkRecords->where('idea_id', $idea->id)->first();
                $idea->isChecked = $check ? true : false;
                return $idea;
            });
        }

    
        // カテゴリ情報をアイデアに結合
        $ideasWithCategory = $ideasWithUser->map(function ($idea) use ($categories) {
            $category = $categories->firstWhere('id', $idea->category_id);
            $idea->category = $category;
            return $idea;
        });
    
        // レビュー情報をアイデアに結合
        $ideasWithReview = $ideasWithCategory->map(function ($idea) use ($reviews) {
            $review = $reviews->where('idea_id', $idea->id);
            $idea->review = $review;
            return $idea;
        });

    
        $data = [
            'ideas' => $ideasWithReview,
        ];
    
        return response()->json($data);
    }


    /* ================================================================
      アイデア詳細情報取得
    ================================================================*/

    public function ideaDetail($id){
        
        $user_id = Auth::id();
        $canBuy = true;
        $isChecked = false;
        $idea = Idea::find($id);
        $seller_id = $idea->user_id;
        $seller = User::find($seller_id);

        // 購入状態を取得
        $boughtIdea = Purchase::where('user_id', $user_id)->where('idea_id', $id)->first();
        // 自分のアイデアかの判定用
        $myIdea = Idea::where('id', $id)->value('user_id');        

        // 購入可能かのフラグ
        if($boughtIdea !== null || $myIdea === $user_id || $seller === null){
            $canBuy = false;
        }

        // レビュー取得
        $reviews = Review::with('user')->where('idea_id', $id)->get()->sortByDesc('created_at')->take(5);
        if($reviews->isNotEmpty()){
            $reviewData = $reviews;
        }else{
            $reviewData = null;
        }

        // 平均点を算出
        $averageScore = $reviews->avg('score');
        // 気になるの状態を取得
        $checkRecord = Check::where('user_id', $user_id)->where('idea_id', $id)->first();
        if($checkRecord){
            $isChecked = true;
        }

        $data = [
            'idea'         => $idea,
            'canBuy'       => $canBuy,
            'reviews'      => $reviewData,
            'averageScore' => $averageScore,
            'isChecked'    => $isChecked,
            'user_id'      => $user_id,
            'seller_id'    => $seller_id,
            'bought'       => $boughtIdea,
        ];
        
        return response()->json($data);
    }


    /* ================================================================
      気になるリスト取得
    ================================================================*/

    public function checks($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $checkIdeas = null;
        $checks = Check::where('user_id', $id)->get();
        
        if ($checks->isNotEmpty()) {
            $idea_ids = $checks->pluck('idea_id')->toArray();
            // 気になるアイデアが10件以上の場合は1ページ10件まで表示
            if($checks->count() > 10){
                $ideas = Idea::whereIn('id', $idea_ids)->with('category', 'review')->paginate(10);
            }else{
                $ideas = Idea::whereIn('id', $idea_ids)->with('category', 'review')->get();
            }
            $checkIdeas = $ideas;
        }

        $data = [
            'checkIdeas' => $checkIdeas,
        ];

        return response()->json($data);
    }


    /* ================================================================
      購入したアイデア取得
    ================================================================*/

    public function boughts($id)
    {
        if (!ctype_digit($id)) {
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }
    
        $boughtList = null;
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['error' => 'ユーザーが見つかりません'], 404);
        }
    
        $boughts = $user->purchase()
            ->with('idea.category', 'idea.review')
            ->get();
    
        if ($boughts->isNotEmpty()) {
            $boughtList = $boughts->count() > 10 ? $boughts->paginate(10) : $boughts;
        }
    
        $data = [
            'boughtList' => $boughtList,
        ];
    
        return response()->json($data);
    }
    

    /* ================================================================
      投稿したアイデア一覧取得
    ================================================================*/

    public function myPosts($id)
    {
        if (!ctype_digit($id)) {
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $postsList = null;
    
        $posts = Idea::with('category','review')->where('user_id', $id);
    
        if ($posts->count() >= 10) {
            $posts = $posts->paginate(10);
        } else {
            $posts = $posts->get();
        }
    
        if ($posts->isNotEmpty()) {
            $postsList = $posts;
        }
    
        $data = [
            'postsList' => $postsList,
        ];
    
        return response()->json($data);
    }
    

    /* ================================================================
      レビュー一覧取得
    ================================================================*/

    public function reviews(){
        $reviewList = null;

        $reviews = Review::with('idea', 'user')->paginate(20);

        if($reviews->isNotEmpty()){
            $reviewList = $reviews;
        }

        $data = [
            'reviewList' => $reviewList
        ];

        return response()->json($data);
    }


    /* ================================================================
      自分のアイデアに対するレビュー一覧取得
    ================================================================*/

    public function myReviews($id)
    {
        if (!ctype_digit($id)) {
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $reviewList = null;

        $reviews = Review::whereHas('idea', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->with('idea','user')
            ->paginate(20);

        if($reviews->isNotEmpty()){
            $reviewList = $reviews;
        }

        $data = [
            'reviewList' => $reviewList
        ];

        return response()->json($data);
    }


    /* ================================================================
      指定のアイデアに対するレビュー一覧取得
    ================================================================*/

    public function ideaReviews($id){
        if (!ctype_digit($id)) {
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $reviewList = null;
        $reviews = Review::whereHas('idea', function ($query) use ($id) {
            $query->where('id', $id);
        })
        ->with('idea', 'user')
        ->get();

        $data = [
            'reviewList' => $reviews
        ];

        return response()->json($data);
    }


    /* ================================================================
      気になる登録・削除処理
    ================================================================*/

    public function toggleCheck($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $user_id = Auth::id();
        // 既にチェックされているかを判別し登録or解除
        $checked = Check::where('user_id', $user_id)->where('idea_id', $id)->first();

        if($checked !== null){
            $checked->delete();
        }else{
            $check = new Check;
            $check->fill([
                'user_id' => $user_id,
                'idea_id' => $id,
            ])->save();
        }
    }


    /* ================================================================
      アイデア購入処理
    ================================================================*/

    public function buy($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $user_id = Auth::id();
        $bought = Purchase::where('user_id', $user_id)->where('idea_id', $id)->first();
        // 同じユーザーが同じアイデアを購入できないように
        if(!empty($bought)){
            return redirect('/')->with('flash_message', 'エラーが発生しました');
        }

        $purchase = new Purchase;
        $sell_user = Idea::where('id', $id)->value('user_id');

        $purchase->fill([
            'user_id'  => $user_id,
            'idea_id'  => $id,
        ])->save();

        // チャットのデータを作成
        $chat = new Chat;
        $chat->fill([
            'buyer_id'  => $user_id,
            'seller_id' => $sell_user,
            'idea_id'   => $id,
        ])->save();

        return redirect()->back()->with('flash_message', '購入しました！');

        // 購入者・販売者にメール送る処理まだ。

    }


    /* ================================================================
      平均点取得処理
    ================================================================*/

    public function getAverage($id){
        $reviews = Review::where('idea_id', $id)->get();
        $averageScore = $reviews->count() === 0 ? 0 : $reviews->avg('score');

        return response()->json(['averageScore' => $averageScore]);
    }


    /* ================================================================
      メッセージ・チャット情報取得
    ================================================================*/

    public function message($idea_id, $sell_user, $user_id){
        if(!ctype_digit($idea_id) || !ctype_digit($sell_user) || !ctype_digit($user_id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        // 販売者のID取得
        $seller_id = Idea::where('id', $idea_id)->value('user_id');

        // 購入者のID取得
        $purchase = Purchase::where('idea_id', $idea_id)
        ->where('user_id', $user_id)
        ->first();
        $buyer_id = $purchase ? $purchase->user_id : null;

        // アイデアの販売者・購入者のIDとパラメーターが違う場合にはリダイレクト
        if($sell_user !== strval($seller_id) || $user_id !== strval($buyer_id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        // ユーザー情報の取得
        $seller = User::find($seller_id);
        $buyer =  User::find($buyer_id);

        // チャットデータを検索・取得
        $chat = Chat::where('idea_id', $idea_id)
                      ->where('seller_id', $sell_user)
                      ->where('buyer_id', $user_id)
                      ->first();


        if (!$chat) {
        return redirect('/')->with('flash_message', __('チャットが見つかりません'));
        }

        // メッセージ情報を取得
        $messages = Message::where('chat_id', $chat->id)->orderBy('created_at')->get();
        
        // 送信者ごとにソート
        // $buyerMessages = $messages->where('user_id', $buyer_id)->sortBy('timestamp')->values();
        // $sellerMessages = $messages->where('user_id', $seller_id)->sortBy('timestamp')->values();

        $data = [
            'seller'   => $seller,
            'buyer'    => $buyer,
            'messages' => $messages,
            'chat_id'  => $chat->id,
        ];

        return response()->json($data);
    }


    /* ================================================================
      メッセージと通知を追加
    ================================================================*/

    public function addMessage(ValidRequest $request, $chat_id, $user_id){
        
        // メッセージの追加
        $msg = new Message;
        $msg->fill([
            'user_id' => $user_id,
            'chat_id' => $chat_id,
            'content' => $request->content,
        ])
        ->save();

        // 通知の追加
        $notification = new Notification;
        $chat = Chat::where('id', $chat_id)->first();
        $reciever_id = ($user_id === $chat->seller_id) ? $chat->buyer_id : $chat->seller_id;
        $idea_id = $chat->idea_id;

        $notification->fill([
            'receiver_id' => $reciever_id,
            'sender_id'   => $user_id,
            'chat_id'     => $chat_id,
            'idea_id'     => $idea_id,
            'read'        => false,
            'content'     => $request->content,
        ])
        ->save();


        return redirect()->back()->with('flash_message', 'メッセージを送信しました!');
    }


}
