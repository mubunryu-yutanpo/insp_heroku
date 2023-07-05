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

//全ユーザーのアイデア一覧画面
Route::get('/index', 'HomeController@index')->name('ideas.index');
// アイデア詳細へ
Route::get('/{id}/idea', 'HomeController@show')->name('ideas.show');
// 全レビュー表示ページへ
Route::get('/reviews', 'HomeController@reviews')->name('reviews');
// アイデアレビュー一覧へ
Route::get('/idea/{id}/reviews', 'HomeController@ideaReviews')->name('idea.reviews');


Route::group(['middleware' => 'auth'], function(){
 
  // ======================Viewを返すルート============================
    // マイページへ
    Route::get('/mypage', 'HomeController@mypage')->name('mypage');
    // マイレビュー一覧へ
    Route::get('/{id}/reviews', 'HomeController@myReviews')->name('user.reviews');
    // 気になる一覧へ
    Route::get('/{id}/checkList', 'HomeController@checks')->name('checks');
    // 購入済み一覧へ
    Route::get('/{id}/boughtList', 'HomeController@boughts')->name('boughts');
    // 投稿済み一覧へ
    Route::get('/{id}/mypostList', 'HomeController@myposts')->name('myposts');
    // プロフ編集へ
    Route::get('/{id}/profEdit', 'HomeController@profEdit')->name('prof.edit');
    // 退会へ
    Route::get('/{id}/withdrow', 'HomeController@withdrow')->name('withdrow');
    // アイデア新規投稿へ
    Route::get('/new', 'HomeController@new')->name('new');
    // // アイデア詳細へ
    // Route::get('/{id}/idea', 'HomeController@show')->name('ideas.show');
    // アイデア編集へ
    Route::get('/{id}/idea/edit', 'HomeController@edit')->name('idea.edit');
    // レビュー投稿へ
    Route::get('/{id}/review/create', 'HomeController@evaluation')->name('evaluation');
    // チャットルームへ
    Route::get('/chat/{idea_id}/{seller_id}/{user_id}', 'HomeController@chat')->name('chat');
    // 通知一覧へ
    Route::get('/{id}/notifications', 'HomeController@notifications')->name('notifications');

  // =====================処理関連ルート===========================
    // アイデア投稿
    Route::post('/new', 'IdeasController@ideaCreate')->name('create');
    // アイデア編集
    Route::post('/{id}/idea/edit', 'IdeasController@ideaUpdate')->name('idea.update');
    // アイデア削除
    Route::post('/idea/{id}/delete', 'IdeasController@ideaDelete')->name('idea.delete');
    // プロフ更新
    Route::post('/{id}/profEdit', 'MypagesController@update')->name('prof.update');
    // 退会
    Route::post('/{id}/withdrow', 'MypagesController@destroy')->name('destroy');
    // レビュー投稿
    Route::post('/{id}/review/create', 'IdeasController@postReview')->name('post.review');


  // ======================ログアウト============================
    Route::get('/logout', 'HomeController@logout')->name('logout');

});

// =================API関連=====================
Route::middleware('api')->group(function() {

    // Authの認証
    Route::get('/api/checkAuth', 'HomeController@checkAuth');
    // トップページのアイデア一覧取得
    Route::get('/api/home/ideas', 'Api\ApiController@topIdeas');
    //アバター情報取得（画像プレビュー用）
    Route::get('/api/{id}/avatar', 'Api\ApiController@avatar');
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
    // 全てのレビュー取得
    Route::get('api/idea/reviews', 'Api\ApiController@reviews');
    // 自分のアイデアへのレビュー一覧取得
    Route::get('/api/{id}/reviews', 'Api\ApiController@myReviews');
    // 指定アイデアのレビュー一覧取得
    Route::get('/api/idea/{id}/reviews', 'Api\ApiController@ideaReviews');
    // 気になる切り替え
    Route::post('/api/idea/{id}/toggleCheck', 'Api\ApiController@toggleCheck');
    // アイデア購入
    Route::get('api/idea/{id}/buy', 'Api\ApiController@buy');
    // 平均点の取得
    Route::get('api/idea/{id}/average', 'Api\ApiController@getAverage');
    // チャットメッセージ取得
    Route::get('api/message/{idea_id}/{seller_id}/{user_id}', 'Api\ApiController@message');
    // チャットメッセージ追加
    Route::post('api/message/{chat_id}/{user_id}', 'Api\ApiController@addMessage');
    // メッセージの既読化
    Route::post('api/{id}/markAsRead', 'Api\ApiController@markAsRead');
    // 通知情報の取得
    Route::get('api/{id}/notifications', 'Api\ApiController@getNotification');
});
    
