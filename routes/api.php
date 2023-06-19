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

// Route::middleware('api')->group(function () {
//     Route::get('/test', 'Api\MypagesController@test');
// });

Route::get('/user',function (Request $request) {
	
	$users = App\User::all();
	
	return response()->json(['users' => $users]);

});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


