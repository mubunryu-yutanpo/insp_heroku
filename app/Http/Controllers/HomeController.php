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



class HomeController extends Controller
{

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

    // ========マイページへ========
    public function mypage(){
        return view('mypage/mypage');
    }

    // ========プロフ編集画面へ========
    public function profEdit($id){
        $user = User::find($id);
        return view('mypage/prof', compact('user'));
    }

    // ========退会ページへ========
    public function withdrow($id){
        $user = Auth::user();
        return view('mypage/withdrow', compact('user'));
    }

    // ========気になる一覧へ========
    public function checks($id){
        return view('mypage/checklist');
    }

    // ========アイデア一覧へ========
    public function index(){
        return view('ideas/index');
    }

    // ========レビュー一覧へ========
    public function reviews(){
        return view('ideas/reviews');
    }

    // ========購入したアイデア一覧へ========
    public function boughts($id){
        return view('ideas/boughts');
    }

    // ========自分が投稿したアイデア一覧へ========
    public function myposts($id){
        return view('ideas/myposts');
    }

    // ========アイデア作成画面へ========
    public function new(){
        $category = Category::all();

        return view('ideas/new', compact('category'));
    }

    // ========アイデア詳細へ========
    public function show($id){
        $idea_id = $id;
        return view('ideas/detail', compact('idea_id'));
    }





}