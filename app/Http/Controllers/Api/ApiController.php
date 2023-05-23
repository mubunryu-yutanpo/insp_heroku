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
    // ========マイページ情報取得========

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
            $checkList = $checks;
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
                  ->with('review')
                  ->has('review')
                  ->get()
                  ->flatMap(function ($idea) {
                     return $idea->review;
                    })
                  ->sortByDesc('created_at')
                  ->take(5);

        if($reviews->isNotEmpty()){
            $reviewList = $reviews;
        }

        $data = [
            'user'       => $user,
            'checkList'  => $checkList,
            'postList'   => $postList,
            'boughtList' => $boughtList,
            'reviewList' => $reviewList,
        ];

        return response()->json($data);
        //return view('mypage', $data);
    }


    // ========気になるリスト取得========
    public function checks($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $checkIdeas = null;
        $checks = Check::where('user_id', $id)->get();

        if ($checks->isNotEmpty()) {
            $idea_ids = $checks->pluck('idea_id')->toArray();
            $ideas = Idea::whereIn('id', $ideaI_ids)->paginate(10);
            $checkIdeas = $ideas;
        }

        $data = [
            'checkIdeas' => $checkIdeas,
        ];

        return response()->json($data);
    }


    // ========購入したアイデア取得========
    public function boughts($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $boughtList = null;
        // 自分が購入したアイデアを1ページ10件表示するように取得
        $boughts = $this->user
                   ->purchase()
                   ->with('idea')
                   ->paginate(10);
        
        if($boughts->isNotEmpty()){
            $boughtList = $boughts;
        }

        $data = [
            'boughtList' => $boughtList,
        ];

        return response()->json($data);
    }

    // ========投稿したアイデア一取得========
    public function myPosts($id)
    {
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
    
    // ========レビュー一覧取得========
    public function reviews(){
        $reviewList = null;
        $reviews = Review::paginate(10);
        $ideaIds = $reviews->pluck('idea_id');
        $ideas = Idea::whereIn('id', $ideaIds)->get();
    
        if($reviews->isNotEmpty()){
            $reviewList = $reviews;
        }
    
        $data = [
            'reviewList' => $reviewList,
            'theIdea'    => $ideas,
        ];
    
        return response()->json($data);
    }

    // ========アイデア一覧取得========
    public function ideas(){
        $ideas = Idea::all();

        $data = [
            'ideas' => $ideas,
        ];

        return response()->json($data);
    }



}
