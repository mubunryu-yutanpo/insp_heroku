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

    // Route::get('/mypage', function () {
    //     return view('mypage');
    // })->where('any', '.*');

    Route::get('/mypage', 'HomeController@mypage')->name('mypage');

    // // ======================ログアウト============================
    Route::get('/logout', 'HomeController@logout')->name('logout');

    

    // =================マイページ関連=====================
    // Route::get('/mypage', 'HomeController@mypage')->name('mypage');
    // // プロフ編集
    // Route::get('/{id}/profEdit', 'HomeController@prof')->name('prof.edit');
    // Route::post('/{id}/profEdit', 'HomeController@update')->name('prof.update');
    // // 気になるリスト一覧(気になるボタン押下時のルートに関して)
    // Route::get('/{id}/checklist', 'HomeController@checklist')->name('checklist');
    // // 退会
    // Route::get('/{id}/withdrow', 'HomeController@withdrow')->name('withdrow');
    // Route::post('/{id}/withdrow', 'HomeController@destroy')->name('destroy');

    // // =================アイデア関連=======================
    // // アイデア新規投稿
    // Route::get('/new', 'IdeasController@new')->name('ideas.new');
    // Route::post('/new/create', 'IdeasController@create')->name('ideas.create');
    // // アイデア詳細
    // Route::get('/{id}/idea', 'IdeasController@show')->name('ideas.show');
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

    Route::middleware('api')->group(function() {
        Route::get('/api/mypage', 'Api\ApiController@mypage');
        Route::get('/api/{id}/checks', 'Api\ApiController@checks');
        Route::get('/api/{id}/boughts', 'Api\ApiController@boughts');
        Route::get('/api/{id}/myPosts', 'Api\ApiController@myPosts');
        Route::get('/api/reviews', 'Api\ApiController@reviews');
        Route::get('/api/ideas', 'Api\ApiController@ideas');
    });
    
