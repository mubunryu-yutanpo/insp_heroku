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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('welcome');
})->where('any', '.*');

Auth::routes();

//全ユーザーのアイデア一覧画面
Route::get('/index', 'HomeController@index')->name('index');

// API
// Route::middleware('auth:api')->group(function() {
//     Route::get('/mypage', 'Api\MypagesController@mypage')->name('mypage.api');
//     Route::get('/{id}/profEdit', 'Api\MypagesController@edit')->name('prof.edit.api');
//     Route::post('/{id}/profEdit', 'Api\MypagesController@update')->name('prof.update.api');
//     Route::get('/{id}/checklist', 'Api\MypagesController@checklist')->name('checklist.api');
//     Route::get('/{id}/withdrow', 'Api\MypagesController@withdrow')->name('withdrow.api');
//     Route::post('/{id}/withdrow', 'Api\MypagesController@destroy')->name('destroy.api');
// });



Route::group(['middleware' => 'auth'], function(){
    // =================マイページ関連=====================
    //Route::get('/mypage', 'MypagesController@mypage')->name('mypage');
    Route::get('/mypage', function(){
        return view('/mypage/mypage');
    });
    // プロフ編集
    Route::get('/{id}/profEdit', 'MypagesController@edit')->name('prof.edit');
    Route::post('/{id}/profEdit', 'MypagesController@update')->name('prof.update');
    // 気になるリスト一覧(気になるボタン押下時のルートに関して)
    Route::get('/{id}/checklist', 'MypagesController@checklist')->name('checklist');
    // 退会
    Route::get('/{id}/withdrow', 'MypagesController@withdrow')->name('withdrow');
    Route::post('/{id}/withdrow', 'MypagesController@destroy')->name('destroy');

    // =================アイデア関連=======================
    // アイデア新規投稿
    Route::get('/new', 'IdeasController@new')->name('ideas.new');
    Route::post('/new/create', 'IdeasController@create')->name('ideas.create');
    // アイデア詳細
    Route::get('/{id}/idea', 'IdeasController@show')->name('ideas.show');
    // アイデア編集
    Route::get('/{id}/ideaEdit', 'IdeasController@edit')->name('ideas.edit');
    Route::post('/{id}/ideaEdit', 'IdeasController@update')->name('ideas.update');
    // 自分が投稿したアイデア一覧
    Route::get('/{id}/posted', 'IdeasController@posted')->name('ideas.mypost');
    // 購入したアイデア一覧
    Route::get('/{id}/bought', 'IdeasController@bought')->name('ideas.bought');
    // レビュー一覧
    Route::get('/{id}/review', 'IdeasController@review')->name('ideas.review');

    // =================JSONデータ用=======================
    Route::get('/ideas/json', 'IdeasController@json')->name('ideas.json');

    // ======================ログアウト============================
    Route::get('/logout', 'HomeController@logout')->name('logout');

    });
