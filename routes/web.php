<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
// Authの認証
Route::get('/api/checkLogin', 'HomeController@checkAuth');
//全ユーザーのアイデア一覧画面
Route::get('/index', 'HomeController@index')->name('ideas.index');


Route::group(['middleware' => 'auth'], function(){
 
  // ======================Viewを返すルート============================
    // マイページへ
    Route::get('/mypage', 'HomeController@mypage')->name('mypage');
    // マイレビュー一覧へ
    Route::get('/{id}/reviews', 'HomeController@myReviews')->name('reviews');
    // アイデアレビュー一覧へ
    Route::get('/idea/{id}/reviews', 'HomeController@ideaReviews')->name('idea.reviews');
    // 気になる一覧へ
    Route::get('/{id}/checkList', 'HomeController@checks')->name('checks');
    // 購入済み一覧へ
    Route::get('/{id}/boughtList', 'HomeController@boughts')->name('boughts');
    // 投稿済み一覧へ
    Route::get('/{id}/mypostList', 'HomeController@myposts')->name('myposts');
    // プロフ編集へ
    Route::get('/{id}/profEdit', 'HomeController@profEdit')->name('prof.edit');
    // 退会へ
    // Route::get('/{id}/withdrow', 'HomeController@withdrow')->name('withdrow');
    // アイデア新規投稿へ
    Route::get('/new', 'HomeController@new')->name('new');
    // アイデア詳細へ
    Route::get('/{id}/idea', 'HomeController@show')->name('ideas.show');
    // レビュー投稿へ
    Route::get('/{id}/review/create', 'HomeController@evaluation')->name('evaluation');
    // チャットルームへ
    Route::get('/chat/{idea_id}/{sell_user}/{user_id}', 'HomeController@chat')->name('chat');

  // =====================処理関連ルート===========================
    // アイデア投稿
    Route::post('/new', 'IdeasController@ideaCreate')->name('create');
    // プロフ更新
    Route::post('/{id}/profEdit', 'MypagesController@update')->name('prof.update');
    // 退会
    // Route::post('/{id}/withdrow', 'MypagesController@destroy')->name('destroy');
    // レビュー投稿
    Route::post('/{id}/review/create', 'IdeasController@postReview')->name('post.review');


  // ======================ログアウト============================
    Route::get('/logout', 'HomeController@logout')->name('logout');

    

    // =================マイページ関連=====================
    // Route::get('/mypage', 'HomeController@mypage')->name('mypage');
    // // 気になるリスト一覧(気になるボタン押下時のルートに関して)
    // Route::get('/{id}/checklist', 'HomeController@checklist')->name('checklist');

    // // =================アイデア関連=======================
    // // アイデア新規投稿
    // Route::get('/new', 'IdeasController@new')->name('ideas.new');
    // Route::post('/new/create', 'IdeasController@create')->name('ideas.create');
    // // アイデア編集
    // Route::get('/{id}/ideaEdit', 'IdeasController@edit')->name('ideas.edit');
    // Route::post('/{id}/ideaEdit', 'IdeasController@update')->name('ideas.update');
    // // 自分が投稿したアイデア一覧
    // Route::get('/{id}/posted', 'IdeasController@posted')->name('ideas.mypost');
    // // 購入したアイデア一覧
    // Route::get('/{id}/bought', 'IdeasController@bought')->name('ideas.bought');
    // // レビュー一覧
    // Route::get('/{id}/review', 'IdeasController@review')->name('ideas.review');

    // // =================JSONデータ用=======================
    // Route::get('/ideas/json', 'IdeasController@json')->name('ideas.json');


    });

    // =================API関連=====================
    Route::middleware('api')->group(function() {

        // マイページ情報取得
        Route::get('/api/mypage', 'Api\ApiController@mypage');
        // アイデア詳細情報取得
        Route::get('/api/idea/{id}/detail', 'Api\ApiController@ideaDetail');
        // アイデア一覧情報取得
        Route::get('/api/ideas', 'Api\ApiController@ideas');
        // 投稿一覧取得
        Route::get('/api/{id}/myPosts', 'Api\ApiController@myPosts');
        // 気になる一覧取得
        Route::get('/api/{id}/checks', 'Api\ApiController@checks');
        // 購入したアイデア一覧取得
        Route::get('/api/{id}/boughts', 'Api\ApiController@boughts');
        // マイレビュー一覧取得
        Route::get('/api/{id}/reviews', 'Api\ApiController@myReviews');
        // アイデアレビュー一覧取得
        Route::get('/api/idea/{id}/reviews', 'Api\ApiController@ideaReviews');
        // 気になる切り替え
        Route::post('/api/idea/{id}/toggleCheck', 'Api\ApiController@toggleCheck');
        // アイデア購入
        Route::get('api/idea/{id}/buy', 'Api\ApiController@buy');
        // メッセージ取得
        Route::get('api/message/{idea_id}/{sell_user}/{user_id]', 'Api\ApiController@message');
    });
    
