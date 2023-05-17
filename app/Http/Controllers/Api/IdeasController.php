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


class IdeasController extends Controller
{
    // ========アイデア新規投稿処理========
    public function ideaPost(ValidRequest $request)
    {
        $idea = new Idea;
        $user_id = Auth::user()->id;
        
        // 既存のカテゴリーを取得または作成
        // $category = Category::firstOrCreate(['name' => $request->category]);
        // $category_id = $category->id;
    
        // DBに保存
        $idea->fill([
            'user_id'     => $user_id,
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'summary'     => $request->summary,
            'description' => $request->description,
            'price'       => $request->price,
        ])->save();
    
        return redirect('mypage')->with('flash_message', __('registered!'));
    }

    // ========アイデア編集画面========
    public function ideaEdit($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        // 誰かに購入されている場合は編集・削除できなくなる
        $canEdit = true;
        $purchased = Purchase::where('idea_id', $id)->first();
        if($purchased !== null){
            $canEdit = false;
        }
        $idea = Idea::find($id);

        $data = [
            'idea'      => $idea,
            'canEdit' => $canEdit,
        ];

        return response()->json($data);
    }


    // ========アイデア編集（更新）処理========
    public function ideaUpdate(ValidRequest $request, $id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $idea = Idea::find($id);
        $user_id = $idea->user_id;

        // アイデアの所持者とアクセスしているユーザーが異なる場合、リダイレクトする
        if ($user_id !== Auth::user()->id) {
            return redirect('/')->with('flash_message', '失敗しました');
        }

        // DB情報更新
        $idea->update([
            'user_id'     => $user_id,
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'summary'     => $request->summary,
            'description' => $request->description,
            'price'       => $request->price,
        ]);

        return redirect('/mypage')->with('flash_message', __('updated!') );
    }


    // ========アイデア削除========
    public function ideaDelete($id){
        if(!ctype_digit($id)){
            return redirect('/')->with('flash_message', __('不正な操作が行われました'));
        }

        $idea = Idea::find($id);
        $user_id = $idea->user_id;

        // アイデアの所持者とアクセスしているユーザーが異なる場合、リダイレクトする
        if ($user_id !== Auth::user()->id) {
            return redirect('/')->with('flash_message', '失敗しました');
        }

        $idea->delete();

        return redirect('/mypage')->with('flash_message', __('deleted!') );
    }

    

    // アイデア詳細画面へ
    public function ideaDetail($id){
        // 気になるボタンがある
        // 自分が購入したことがあるアイデアは購入できない（これと次のでフラグをもったらいいかな）
        // 購入してないときは「アイデアの内容」欄は「購入後に表示されます」になる
        // 購入済みの各ユーザーからのレビュー・点数が表示される
        // 点数の平均点が表示される
        //return response->json();
        return view('ideas/idea');
    }


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
