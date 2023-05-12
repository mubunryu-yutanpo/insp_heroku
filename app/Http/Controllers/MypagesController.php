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



class MypagesController extends Controller
{
    // マイページへ
    public function mypage(){
        $user = Auth::user();
        $user_id = $user->id;

        //=========気になるリスト取得=========

        $checklist = null;
        // 気になるのデータを最新5件まで取得
        $checks = Check::where('user_id', $user_id)
                  ->orderBy('created_at', 'desc')
                  ->limit(5)
                  ->get();

        if($checks->isNotEmpty()){
            $checklist = $checks;
        }

        //=========投稿したアイデア取得=========

        $postlist = null;
        // 投稿したアイデアを最新の5件まで取得
        $posts = Idea::where('user_id', $user_id)
                 ->orderBy('created_at', 'desc')
                 ->limit(5)
                 ->get();

        if($posts->isNotEmpty()){
            $postlist = $posts;
        }
        
        //=========レビュー取得=========
        
        $reviewlist = null;

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
            $reviewlist = $reviews;
        }


        //=========購入したアイデア取得=========
        // 購入したアイデア最新5件表示


        return view('mypage/mypage', compact('user','checklist', 'postlist', 'reviewlist'));
    }


    // 気になる一覧へ
    public function checklist($id){
        $user = Auth::user();
        return view('mypage/checklist', compact('user'));
    }

    // プロフィール編集画面へ
    public function edit($id){
        $user = Auth::user();
        return view('mypage/prof', compact('user'));
    }

    // プロフィール編集処理
    public function update(ValidRequest $request, $id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        // アバター画像のパス名を変数に
        if($request->avatar !== null){
            $avatar = $request->file('avatar');
            $filename = $avatar->getClientOriginalName();
            $avatar->move(public_path('updates'), $filename);
        }else{
            $filename = 'default-avatar.png';
        }

        // 情報を更新
        User::where('id', $id)->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'introduction' => $request->introduction,
            'avatar'       => '/updates/'.$filename,
        ]);

        return redirect('/mypage')->with('flash_message', '情報を更新しました');
   
    }

    // 退会ページへ
    public function withdrow($id){
        $user = Auth::user();
        return view('mypage/withdrow', compact('user'));
    }

    // 退会処理
    public function destroy($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }
        // ユーザー情報を削除してリダイレクト
        User::where('id', $id)->delete();
        return redirect('/')->with('flash_message', '退会しました');
    }


}
