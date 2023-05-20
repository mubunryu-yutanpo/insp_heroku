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

    // // マイページへ
    // public function mypage(){
    //     return view('/mypage/mypage');
    // }

    // // 気になる一覧へ
    // public function checklist($id){
    //     // $user = Auth::user();
    //     // $user_id = $user->id;

    //     // $list = null;
    //     // // 気になるアイデアがある場合はそのデータを変数に
    //     // $checks = Check::where('user_id', $user_id)->get();
    //     // if($checks->isNotEmpty()){
    //     //     $list = $checks;
    //     // }
    //     // return view('mypage/checklist', compact('user', 'list'));
    //     return view('/mypage/checklist');
    // }

    // // プロフィール編集画面へ
    // public function prof($id){
    //     // $user = Auth::user();
    //     // return view('mypage/prof', compact('user'));
    //     return view('/mypage/prof');
    // }

    // // プロフィール編集処理
    // public function update(ValidRequest $request, $id){
    //     if(!ctype_digit($id)){
    //         return redirect('/')->with('flash_message', __('不正な操作が行われました'));
    //     }

    //     // アバター画像のパス名を変数に
    //     if($request->avatar !== null){
    //         $avatar = $request->file('avatar');
    //         $filename = $avatar->getClientOriginalName();
    //         $avatar->move(public_path('updates'), $filename);
    //     }else{
    //         $filename = 'default-avatar.png';
    //     }

    //     // 情報を更新
    //     User::where('id', $id)->update([
    //         'name'         => $request->name,
    //         'email'        => $request->email,
    //         'password'     => Hash::make($request->password),
    //         'introduction' => $request->introduction,
    //         'avatar'       => '/updates/'.$filename,
    //     ]);

    //     return redirect('/mypage')->with('flash_message', '情報を更新しました');
   
    // }

    // // 退会ページへ
    // public function withdrow($id){
    //     // $user = Auth::user();
    //     // return view('mypage/withdrow', compact('user'));
    //     return view('/mypage/withdrow');
    // }

    // // 退会処理
    // public function destroy($id){
    //     if(!ctype_digit($id)){
    //         return redirect('/')->with('flash_message', __('不正な操作が行われました'));
    //     }
    //     // ユーザー情報を削除してリダイレクト
    //     User::where('id', $id)->delete();
    //     return redirect('/')->with('flash_message', '退会しました');
    // }

    // // アイデア一覧ページへ
    // public function index()
    // {
    //     return view('welcome');
    // }

    // // アイデア新規投稿へ
    // public function new(){
    //     return view('ideas/new');
    // }

    // // アイデア詳細画面へ
    // public function show($id){
    //     return view('ideas/idea');
    // }

    // // アイデア編集画面へ
    // public function edit($id){
    //     return view('ideas/edit');
    // }

    // // 購入したアイデアへ
    // public function bought($id){
    //     return view('ideas/bought');
    // }

    // // 投稿したアイデア一覧へ
    // public function posted($id){
    //     return view('ideas/posted');
    // }

    // // レビュー一覧へ
    // public function review($id){
    //     return view('ideas/review');
    // }
    
}
