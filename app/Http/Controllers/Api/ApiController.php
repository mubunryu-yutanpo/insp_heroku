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


class ApiController extends Controller
{

    /* ================================================================
      マイページ情報取得
    ================================================================*/
    
    public function mypage(){
        $user = Auth::user();
        $user_id = $user->id;

        // -- 気になるリスト取得 --

        $checkList = null;
        // 気になるのデータを最新5件まで取得
        $checks = Check::where('user_id', $user_id)
                  ->orderBy('created_at', 'desc')
                  ->limit(5)
                  ->get();

        if($checks->isNotEmpty()){
            $idea_id = $checks->pluck('idea_id');
            $checkList = Idea::whereIn('id', $idea_id)->get();
        }

        // -- 投稿したアイデア取得 --

        $postList = null;
        // 投稿したアイデアを最新の5件まで取得
        $posts = Idea::where('user_id', $user_id)
                 ->orderBy('created_at', 'desc')
                 ->limit(5)
                 ->get();

        if($posts->isNotEmpty()){
            $postList = $posts;
        }
        
        // -- 購入したアイデア取得 --
        
        $boughtList = null;
        // 購入したアイデア最新5件表示
        $boughts = $user->purchase()
                   ->with('idea')
                   ->get()
                   ->sortByDesc('created_at')
                   ->take(5);
        
        if($boughts->isNotEmpty()){
        $boughtList = $boughts;
        }
        
        // -- レビュー取得 --
        
        $reviewList = null;
        // 投稿に対するレビューのデータを最新5件まで取得
        $reviews = $user->idea()
        ->with('review.user') // レビューに紐づくユーザー情報をロード
        ->has('review')
        ->get()
        ->flatMap(function ($idea) {
            return $idea->review;
        })
        ->sortByDesc('created_at')
        ->take(5);

        if ($reviews->isNotEmpty()) {
            $reviewList = $reviews->map(function ($review) {
                $review->user = $review->user->select('name', 'avatar')->first(); // ユーザー名とアバターを取得
                return $review;
            });        
        }
        
    $data = [
        'user'       => $user,
        'checkList'  => $checkList,
        'postList'   => $postList,
        'boughtList' => $boughtList,
        'reviewList' => $reviewList,
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

        // 購入状態を取得
        $boughtIdea = Purchase::where('user_id', $user_id)->where('idea_id', $id)->first();
        // 自分のアイデアかの判定用
        $myIdea = Idea::where('id', $id)->value('user_id');
        
        if($boughtIdea !== null || $myIdea === $user_id){
            $canBuy = false;
        }

        // レビュー取得
        $reviews = Review::where('idea_id', $id)->get();
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
            'reviews'      => $reviews,
            'averageScore' => $averageScore,
            'isChecked'    => $isChecked,
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
                $ideas = Idea::whereIn('id', $idea_ids)->paginate(10);
            }else{
                $ideas = Idea::whereIn('id', $idea_ids)->get();
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
            ->with('idea')
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
    
        $posts = Idea::where('user_id', $id);
    
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
      自分のアイデアに対するレビュー一覧取得
    ================================================================*/

    public function myReviews($id)
    {
        if (!ctype_digit($id)) {
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $reviewList = null;
        $reviews = Review::whereIn('idea_id', function ($query) use ($id) {
            $query->select('id')
                  ->from('ideas')
                  ->where('user_id', $id);
        })->get();
    
        $ideaIds = $reviews->pluck('idea_id');
        $ideas = Idea::whereIn('id', $ideaIds)->get();

        if ($reviews->isNotEmpty()) {
            $reviewList = $reviews->count() > 10 ? $reviews->paginate(10) : $reviews;
        }
    
        $data = [
            'reviewList' => $reviewList,
            'theIdea'    => $ideas,
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
        $reviews = Review::where('idea_id', $id)->get();
        $ideaIds = $reviews->pluck('idea_id');
        $ideas = Idea::whereIn('id', $ideaIds)->get();
    
        if($reviews->isNotEmpty()){
            $reviewList = $reviews->count() > 10 ? $reviews->paginate(10) : $reviews;
        }
    
        $data = [
            'reviewList' => $reviewList,
            'theIdea'    => $ideas,
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
    
        $data = [
            'ideas' => $ideas,
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

        $purchase = new Purchase;
        $user_id = Auth::id();

        $purchase->fill([
            'user_id'  => $user_id,
            'idea_id'  => $id,
        ])->save();

        return redirect()->back()->with('flash_message', '購入しました！');

    }


}
