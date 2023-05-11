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
        return view('mypage/mypage', compact('user'));
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
