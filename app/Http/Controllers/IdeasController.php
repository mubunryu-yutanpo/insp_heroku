<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Category;
use App\Check;
use App\Idea;
use App\Purchase;
use App\Review;


class IdeasController extends Controller
{
    // アイデア新規投稿へ
    public function new(){
        return view('ideas/new');
    }

    // アイデア詳細画面へ
    public function show($id){
        return view('ideas/idea');
    }

    // アイデア編集画面へ
    public function edit($id){
        return view('ideas/edit');
    }

    // 購入したアイデアへ
    public function bought($id){
        return view('ideas/bought');
    }

    // 投稿したアイデア一覧へ
    public function posted($id){
        return view('ideas/posted');
    }

    // レビュー一覧へ
    public function review($id){
        return view('ideas/review');
    }

}
