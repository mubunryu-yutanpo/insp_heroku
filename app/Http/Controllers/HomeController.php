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
        return view('ideas/review');
    }

    // ========購入したアイデア一覧へ========
    public function boughts($id){
        return view('ideas/boughts');
    }




}