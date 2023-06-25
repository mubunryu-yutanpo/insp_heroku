<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidRequest;
use App\User;
use App\Category;
use App\Check;
use App\Idea;
use App\Purchase;
use App\Review;
use App\Chat;
use App\Message;



class HomeController extends Controller
{

    /* ================================================================
      ログイン・ログアウト
    ================================================================*/

    // ========ログアウト========
    public function logout(){
        Auth::logout();
        return redirect('/')->with('flash_message', 'ログアウトしました');
    }

    // ========ログインチェック========
    public function checkAuth(){
        $auth = auth()->check();

        $data = [
            'authenticated' => $auth,
        ];

        return response()->json($data);
    }


    /* ================================================================
      マイページへ
    ================================================================*/

    public function mypage(){
        return view('mypage/mypage');
    }


    /* ================================================================
      プロフ編集ページへ
    ================================================================*/

    public function profEdit($id){
        $user = User::find($id);
        return view('mypage/prof', compact('user'));
    }


    /* ================================================================
      退会ページへ
    ================================================================*/

    public function withdrow($id){
        $user = Auth::user();
        return view('mypage/withdrow', compact('user'));
    }


    /* ================================================================
      気になる一覧へ
    ================================================================*/

    public function checks($id){
        return view('mypage/checklist');
    }


    /* ================================================================
      アイデア一覧へ
    ================================================================*/

    public function index(){
        $category = Category::all();

        return view('ideas/index', compact('category'));
    }


    /* ================================================================
      全レビュー一覧ページへ
    ================================================================*/

    public function reviews(){
        return view('ideas/reviews');
    }


    /* ================================================================
      自分のアイデアに対するレビュー一覧へ
    ================================================================*/

    public function myReviews($id){
        $auth_user = Auth::id();
        $user_id = null;

        if($auth_user === intval($id) ){
            $user_id = $id;
        }

        return view('ideas/myReviews', compact('user_id'));
    }


    /* ================================================================
      指定のアイデアのレビュー一覧へ
    ================================================================*/

    public function ideaReviews($id){
        $idea_id = $id;
        return view('ideas/ideaReviews', compact('idea_id'));
    }


    /* ================================================================
      購入したアイデア一覧へ
    ================================================================*/

    public function boughts($id){
        return view('ideas/boughts');
    }


    /* ================================================================
      自分が投稿したアイデア一覧へ
    ================================================================*/

    public function myposts($id){
        return view('ideas/myposts');
    }


    /* ================================================================
      アイデア作成画面へ
    ================================================================*/

    public function new(){
        $category = Category::all();

        return view('ideas/new', compact('category'));
    }


    /* ================================================================
      アイデア詳細へ
    ================================================================*/

    public function show($id){
        $idea_id = $id;
        return view('ideas/detail', compact('idea_id'));
    }


    /* ================================================================
      アイデア編集の情報取得
    ================================================================*/

    public function edit($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        // 誰かに購入されている場合は編集・削除できなくなる
        $can_edit = true;
        $purchased = Purchase::where('idea_id', $id)->first();
        if($purchased !== null){
            $can_edit = false;
        }
        $idea = Idea::find($id);
        $category = Category::all();

        return view('ideas/edit', compact('idea', 'can_edit', 'category'));
    }


    /* ================================================================
      レビュー投稿へ
    ================================================================*/

    public function evaluation($id){
        $idea = Idea::find($id);
        return view('ideas/evaluation', compact('idea'));
    }


    /* ================================================================
      チャットへ
    ================================================================*/

    public function chat($idea_id, $seller_id, $user_id){

        $chat_id = Chat::where('seller_id', $seller_id)
                         ->where('buyer_id', $user_id)
                         ->where('idea_id', $idea_id)
                         ->value('id');
        
        return view('mypage/chat', compact('idea_id', 'seller_id', 'user_id','chat_id'));
    }


    /* ================================================================
      通知一覧へ
    ================================================================*/

    public function notifications($id){

        return view('mypage/notifications');
    }


}