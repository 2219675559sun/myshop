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
//模板登录视图
	Route::get('/admin/log', 'admin\AdminController@log');
	Route::get('/admin/login_do', 'admin\AdminController@login_do');
// 模板注册视图
Route::get('/admin/logadd', 'admin\AdminController@logadd');
Route::get('/admin/logadd_do', 'admin\AdminController@logadd_do');
//模板展示页面
Route::get('/admin/index', 'admin\AdminController@index');


//登录视图
Route::get('/student/log', 'StudentController@log');
Route::post('/student/login', 'StudentController@login');


Route::group(['middleware' => ['login']], function () {

   //展示
Route::get('/student/index', 'StudentController@index');
// 删除
Route::get('/student/delete', 'StudentController@delete');
// 添加视图
Route::get('/student/add', 'StudentController@add');
// 执行添加
Route::post('/student/do_add', 'StudentController@do_add');
// 修改视图
Route::get('/student/update', 'StudentController@update');
// 执行修改
Route::post('/student/do_update', 'StudentController@do_update');

});