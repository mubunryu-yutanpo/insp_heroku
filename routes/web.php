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

Route::get('/home', 'HomeController@index')->name('home');
//全ユーザーのアイデア一覧画面


Route::group(['middleware' => 'auth'], function(){
    // =================マイページ関連=====================
    Route::get('/mypage', 'MypageController@mypage')->name('mypage');
    // プロフ編集
    Route::get('/{id}/profEdit', 'MypageController@edit')->name('prof_edit');
    Route::post('/{id}/profEdit', 'MypageController@update')->name('prof_update');
    // 気になるリスト一覧(気になるボタン押下時のルートに関して)
    Route::get('/{id}/checklist', 'MypageController@checklist')->name('check_list');

    // =================アイデア関連=======================
    // アイデア新規投稿
    Route::get('/new', 'IdeaController@new')->name('ideas.new');
    Route::post('/new/create', 'IdeaController@create')->name('ideas.create');
    // アイデア詳細
    Route::get('/{id}/idea', 'IdeaController@show')->name('ideas.show');
    // アイデア編集
    Route::get('/{id}/ideaEdit', 'IdeaController@edit')->name('ideas.edit');
    Route::post('/{id}/ideaEdit', 'IdeaController@update')->name('ideas.update');
    // 自分が投稿したアイデア一覧
    Route::get('/{id}/posted', 'IdeaController@posted')->name('ideas.mypost');
    // 購入したアイデア一覧
    Route::get('/{id}/bought', 'IdeaController@bought')->name('ideas.bought');
    // レビュー一覧
    Route::get('/{id}/review', 'IdeaController@review')->name('ideas.review');

    // =================JSONデータ用=======================
    Route::get('/ideas/json', 'IdeaController@json')->name('ideas.json');

    });
