<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
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

class MypagesController extends Controller
{

    /* ================================================================
      プロフィール編集処理
    ================================================================*/

     public function update(ValidRequest $request, $id)
    {
        if (!ctype_digit($id)) {
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        // ユーザー情報を取得
        $user = User::find($id);

        // アバター画像のパス名を変数に
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            // 画像がHEIC形式ならJPEG形式に変換して保存
            if ($avatar->getClientOriginalExtension() === 'heic') {
                $filename = $avatar->getClientOriginalName() . '.jpg';
                $image = Image::make($avatar->getRealPath());

                // 変換に成功した場合のみ保存
                if ($image->save(public_path('uploads') . '/' . $filename, 75)) {
                    // 保存に成功した場合
                } else {
                    // 保存に失敗した場合
                    return back()->withErrors(['avatar' => '画像の保存中にエラーが発生しました']);
                }
            } else {
                $filename = $avatar->getClientOriginalName();
                if (!$avatar->move(public_path('uploads'), $filename)) {
                    // 保存に失敗した場合
                    return back()->withErrors(['avatar' => '画像の保存中にエラーが発生しました']);
                }
            }

        } else if ($user->avatar !== 'default-avatar.png') {
            // 画像を変更しない場合、/uploads/を除去して保存
            $filename = $user->avatar;
            $filename = str_replace('/uploads/', '', $filename);

        } else {
            $filename = 'default-avatar.png';
        }

        // DBのパスワードと一致する場合、入力されたパスワードを保存
        if ($request->password && Hash::check($request->password, $user->password)) {
            $password = Hash::make($request->password);
        } else {
            // 入力されたパスワードとDBに保存されているパスワードが異なる場合、バリデーションエラーを返す
            return back()->withErrors(['password' => '現在のパスワードと一致しません']);
        }

        // 情報を更新
        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'introduction' => $request->introduction,
            'avatar' => '/uploads/' . $filename,
        ]);

        return redirect('/mypage')->with('flash_message', '情報を更新しました');
    }


    // public function update(ValidRequest $request, $id){
    //     if(!ctype_digit($id)){
    //         return redirect('/')->with('flash_message', __('不正な操作が行われました'));
    //     }

    //     // ユーザー情報を取得
    //     $user = User::find($id);


    //     // アバター画像のパス名を変数に
    //     if($request->avatar !== null){
    //         $avatar = $request->file('avatar');
    //         $filename = $avatar->getClientOriginalName();
    //         $avatar->move(public_path('uploads'), $filename);

    //     }else if($user->avatar !== 'default-avatar.png'){
    //         // 画像を変更しない場合、/uploads/を除去して保存
    //         $filename = $user->avatar;
    //         $filename = str_replace('/uploads/', '', $filename);

    //     }else{
    //         $filename = 'default-avatar.png';
    //     }


    //     // DBのパスワードと一致する場合、入力されたパスワードを保存
    //     if ($request->password && Hash::check($request->password, $user->password)) {
    //         $password = Hash::make($request->password);
        
    //     }else{
    //       // 入力されたパスワードとDBに保存されているパスワードが異なる場合、バリデーションエラーを返す
    //       return back()->withErrors(['password' => '現在のパスワードと一致しません']);
    //     }

    //     // 情報を更新
    //     User::where('id', $id)->update([
    //         'name'         => $request->name,
    //         'email'        => $request->email,
    //         'password'     => $password,
    //         'introduction' => $request->introduction,
    //         'avatar'       => '/uploads/'.$filename,
    //     ]);

    //     return redirect('/mypage')->with('flash_message', '情報を更新しました');
   
    // }

    
    /* ================================================================
      退会処理
    ================================================================*/

    public function destroy($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }
        // ユーザー情報を削除してリダイレクト
        User::where('id', $id)->delete();
        return redirect('/')->with('flash_message', '退会しました');
    }


}


