<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function() {
    Route::get('/mypage', 'Api\MypagesController@mypage')->name('mypage.api');
    Route::get('/{id}/profEdit', 'Api\MypagesController@edit')->name('prof.edit.api');
    Route::post('/{id}/profEdit', 'Api\MypagesController@update')->name('prof.update.api');
    Route::get('/{id}/checklist', 'Api\MypagesController@checklist')->name('checklist.api');
    Route::get('/{id}/withdrow', 'Api\MypagesController@withdrow')->name('withdrow.api');
    Route::post('/{id}/withdrow', 'Api\MypagesController@destroy')->name('destroy.api');
});
