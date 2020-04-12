<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'auth'],function(){
    Route::post('/login','AuthController@login');
    Route::post('/signup', 'AuthController@signup');
    // Route::get('/logout','AuthController@logout')->middleware('auth:api');
    // Route::get('/user','AuthController@user')->middleware('auth:api');
});



Route::group(['middleware'=>'auth:api'],function(){

    Route::get('/logout','AuthController@logout');
    Route::get('/users','API\UserController@index');
    Route::get('/users/{username}','API\UserController@show');
// where to store the method and what should be method name
    Route::get('/users/{username}/articles','API\UserController@articles');
    //Route::get('/users/{user}/articles' ,'API\UserController@');


    Route::get('/articles','API\ArticleController@index');
    //Route::get('/articles?type=mu','API\ArticleController@mostUpvoted');
    Route::post('/articles','API\ArticleController@store');
    Route::get('/articles/{article}','API\ArticleController@show');
    Route::put('/articles/{article}','API\ArticleController@update');
    Route::delete('/articles/{article}','API\ArticleController@destroy');

    Route::get('/articles/{article}/comments','API\CommentController@index');
    Route::post('/articles/{article}/comments','API\CommentController@store');

//To be organized
    Route::post('/article/upvote','API\UpvoteController@upvote');

});
