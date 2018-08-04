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

Route::group(['middleware' => ['web']], function () {
    Route::get('/','Home\IndexController@index');
    Route::get('/cate/{cate_id}','Home\IndexController@cate');
    Route::get('/a/{art_id}','Home\IndexController@art');

    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
});

Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('logout', 'LoginController@logout');
    Route::any('pass', 'IndexController@pass');
    Route::post('cate/changeorder','CategoryController@changeorder');
    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');
    Route::get('art/showpath','ArticleController@showPath');
    Route::get('upload', 'CommonController@upload');
    Route::post('lin/changeorder','LinkController@changeorder');
    Route::resource('link','LinkController');
    Route::post('na/changeorder','NavController@changeorder');
    Route::resource('nav','NavController');
    Route::post('conf/changeorder','ConfigController@changeorder');
    Route::post('conf/changecontent','ConfigController@changecontent');
    route::get('conf/putconfigfile','ConfigController@putConfigFile');
    Route::resource('config','ConfigController');
});