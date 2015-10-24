<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['profix' => '/'],function()
{
    Route::get('/', function()
    {
        return view('homepage.index');
    });

    Route::group(['prefix' => 'blog'],function()
    {
        Route::get('/', 'Blog\BlogController@index');
        Route::get('/catalog', 'Blog\BlogController@catalogList');
        Route::get('/content', 'Blog\BlogController@blogContent');
        Route::controller('/article','Blog\Article\ArticleController');
    });
    Route::group(['prefix' => 'user'], function()
    {
        Route::post('/register', 'Blog\User\UserController@postRegister');
    });
}
);
