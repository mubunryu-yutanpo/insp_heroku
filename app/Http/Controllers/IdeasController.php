<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ValidRequest;
use App\User;
use App\Category;
use App\Check;
use App\Idea;
use App\Purchase;
use App\Review;
use Image;

class IdeasController extends Controller
{

    /* ================================================================
      アイデア新規投稿処理
    ================================================================*/

    public function ideaCreate(ValidRequest $request)
    {        
        $user_id = Auth::id();
        $idea = new Idea;

        // サムネ画像のパス名を変数に
        if ($request->hasFile('thumbnail')) {
            $avatar = $request->file('thumbnail');
            $filename = $avatar->getClientOriginalName();

            // 画像を圧縮して保存 
            $compressedImage = Image::make($avatar)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $path = '/uploads/'.$filename;
            Storage::put($path, (string)$compressedImage->encode());
        
        } else {
            $filename = 'thumbnail-default.png';
        }

        try{

            // DBに保存
            $saved = $idea->fill([
                'user_id'     => $user_id,
                'category_id' => $request->category,
                'title'       => $request->title,
                'thumbnail'    => '/uploads/'.$filename,
                'summary'     => $request->summary,
                'description' => $request->description,
                'price'       => $request->price,
            ])->save();
        
            // DBの更新を確認
            if ($saved) {

                // 更新が成功した場合
                return redirect('mypage')->with('flash_message', 'アイデアを投稿しました！');

            }else{
                // 更新が行われなかった場合の処理
                return redirect('mypage')->with('flash_message', __('データの保存に失敗しました'));
            }


        }catch(QueryException $e){
            // ログを出力
            Log::error('アイデア新規投稿SQLエラー：' . $e->getMessage());
            return redirect()->back()->with('flash_message', 'データの保存中にエラーが発生しました。');
        }
    }


    /* ================================================================
      アイデア編集（更新）処理
    ================================================================*/

    public function ideaUpdate(ValidRequest $request, $id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $user_id = Auth::id();
        $idea = Idea::find($id);

        // サムネ画像のパス名を変数に
        if ($request->hasFile('thumbnail')) {
            $avatar = $request->file('thumbnail');
            $filename = $avatar->getClientOriginalName();

            // 画像を圧縮して保存
            $compressedImage = Image::make($avatar)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $path = 'uploads/'.$filename;
            Storage::put($path, (string)$compressedImage->encode());
        
        } else {
            $filename = 'thumbnail-default.png';
        }

        // アイデアの所持者とアクセスしているユーザーが異なる場合、リダイレクトする
        if ($user_id !== Auth::user()->id) {
            return redirect('/')->with('flash_message', '失敗しました');
        }

        try{

            // DB情報更新
            $idea->update([
                'user_id'     => $user_id,
                'category_id' => $request->category,
                'title'       => $request->title,
                'thumbnail'    => '/uploads/'.$filename,
                'summary'     => $request->summary,
                'description' => $request->description,
                'price'       => $request->price,
            ]);

            if($idea->wasChanged()){
                // 成功した場合
                return redirect('/mypage')->with('flash_message', '更新しました！' );

            }else{
                // 失敗
                return redirect()->back()->with('flash_message', 'データの更新に失敗しました');
            }


        }catch(QueryException $e){
            // エラー時
            Log::error('アイデア編集SQLエラー：'. $e->getMessage());
            return redirect()->back()->with('flash_message', 'エラーが発生しました。');

        }
    }

    /* ================================================================
      アイデア削除処理
    ================================================================*/

    public function ideaDelete($id){

        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $user_id = Auth::id();
        $idea = Idea::find($id);
        $owner_id = $idea->user_id;

        // アイデアが存在しない場合
        if (!$idea) {
            return redirect('/')->with('flash_message', 'アイデアが存在しません');
        }

        // アイデアの所持者とアクセスしているユーザーが異なる場合
        if ($owner_id !== $user_id) {
            return redirect('/')->with('flash_message', '権限がありません');
        }

        try{

            $deleted = $idea->delete();

            if($deleted){
                // 成功時
                return redirect('/mypage')->with('flash_message', '削除しました！' );

            }else{
                // 失敗時
                return redirect()->back()->with('flash_message', 'データ更新時にエラーが発生しました。');
            }

        }catch(QueryException $e){
            // エラー時
            Log::error('アイデア削除SQLエラー：'. $e->getMessage());
            return redirect()->back()->with('flash_message', 'エラーが発生しました');
        }
    }


    /* ================================================================
      レビュー投稿
    ================================================================*/

    public function postReview(ValidRequest $request, $id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $user_id = Auth::id();
        $review = new Review;


        try{
            // 投稿を保存
            $saved = $review->fill([
                'user_id' => $user_id,
                'idea_id' => $id,
                'comment' => $request->comment,
                'score'   => $request->score,
            ])->save();

            if($saved){
                // 成功時
                return redirect('mypage')->with('flash_message', 'レビューを投稿しました！');

            }else{
                // 失敗時
                return redirect()->back()->with('flash_message', 'データの保存中にエラーが発生しました');
            }
    

        }catch(QueryException $e){
            // エラー時
            Log::error('レビュー投稿SQLエラー：'. $e->getMessage());
            return redirect()->back()->with('flash_message', 'エラーが発生しました');
        }


    }

}
