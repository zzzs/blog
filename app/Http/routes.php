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

Route::get('/', 'Home\HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Route::post('comment/store', 'CommentsController@store');

// 认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// 注册路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// 发送密码重置链接路由
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
// 密码重置路由
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::group(['namespace' => 'Home'], function()
{
	Route::get('/', 'HomeController@index');
	Route::get( 'articles/{id}', [ 'as' => '文章详情', 'uses' => 'ArticlesController@show'] );
	Route::post( 'comment/store', [ 'as' => '文章搜索', 'uses' => 'CommentsController@store'] );
});

Route::group(['prefix' => 'admin', 'middleware'=>'auth', 'namespace' => 'Admin'], function()
{
	Route::get('/', 'AdminHomeController@index');

	//文章
	Route::put( 'articles/restore/{id}', [ 'as' => '文章恢复', 'uses' => 'ArticlesController@restore'] );
	Route::get( 'articles/recommends/{id}', [ 'as' => '查看推荐', 'uses' => 'ArticlesController@show_recommends'] );
	Route::get( 'articles/notrecommend/{id}', [ 'as' => '未推荐列表', 'uses' => 'ArticlesController@not_recommends'] );
	Route::get( 'articles/comments/{id}', [ 'as' => '查看评论', 'uses' => 'ArticlesController@show_comments'] );
	Route::resource('articles', 'ArticlesController');

	//评论
	Route::put( 'comments/{id}', [ 'as' => '审核评论', 'uses' => 'CommentsController@check'] );
	Route::resource('comments', 'CommentsController');

	//推荐
	Route::resource('recommends', 'RecommendsController');

	//标签类型
	Route::resource('tagtypes', 'TagtypesController');
	//标签
	Route::resource('tags', 'TagsController');

	//公共
	Route::group(['prefix' => 'common'], function()
	{
		Route::post( 'upload_pic', [ 'as' => '加载图片链接', 'uses' => 'CommonController@upload_pic_link'] );
		Route::post( 'load_md', [ 'as' => '加载MD文件', 'uses' => 'CommonController@load_md_file'] );
		Route::post( 'preview', [ 'as' => '文章预览', 'uses' => 'CommonController@preview'] );
	});
});
