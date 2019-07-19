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
//后台
//展示
Route::get('/admin/index', 'admin\AdminController@index');
//添加
Route::get('/admin/add', 'admin\AdminController@add');
Route::post('/admin/add_do', 'admin\AdminController@add_do');
//删除
Route::get('/admin/delete', 'admin\AdminController@delete');
//修改
Route::get('/admin/update', 'admin\AdminController@update');
Route::post('/admin/update_do', 'admin\AdminController@update_do');
//登录页面
Route::get('/admin/login', 'admin\AdminController@login');
Route::post('/admin/login_do', 'admin\AdminController@login_do');
//管理员列表
Route::get('/admin/userList', 'admin\AdminController@userList');
//管理员删除
Route::get('/admin/user_delete', 'admin\AdminController@user_delete');
//管理员修改
Route::get('/admin/user_update', 'admin\AdminController@user_update');
Route::get('/admin/userUpdate', 'admin\AdminController@userUpdate');
Route::post('/admin/userUpdate_do', 'admin\AdminController@userUpdate_do');

Route::get('/admin/sessionout', 'admin\AdminController@sessionout');


//测试货物管理
Route::get('/goods/index', 'admin\GoodsController@index');
Route::get('/goods/add', 'admin\GoodsController@add');
Route::post('/goods/add_do', 'admin\GoodsController@add_do');
Route::get('/goods/delete', 'admin\GoodsController@delete');
Route::post('/goods/update_do', 'admin\GoodsController@update_do');
Route::group(['middleware' => ['cgoods']], function () {

    Route::get('/goods/update', 'admin\GoodsController@update');


});




//前台
//模板登录视图
	Route::get('/index/log', 'index\IndexController@log');
	Route::get('/index/login_do', 'index\IndexController@login_do');
// 模板注册视图
Route::get('/index/logadd', 'index\IndexController@logadd');
Route::get('/index/logadd_do', 'index\IndexController@logadd_do');
//模板展示页面
Route::get('/index', 'index\IndexController@index');
//模板退出登录
Route::get('/index/sessionout', 'index\IndexController@sessionout');
//模板详情页
Route::get('/index/detail', 'index\IndexController@detail');
//购物车
Route::get('/index/cart', 'index\IndexController@cart');
//购物车视图
Route::get('/index/cart_list', 'index\IndexController@cart_list');
//购物车删除
Route::get('/index/cartdelete', 'index\IndexController@cartdelete');
//订单详情
//Route::get('/index/order', 'index\IndexController@order');

//支付宝
Route::get('/do_pay', 'PayController@do_pay');
//订单详情
Route::get('confirm_pay', 'PayController@confirm_pay');
//支付订单详情
Route::get('index/order_list', 'index\IndexController@order_list');
Route::get('pay_order', 'PayController@pay_order');

//同步
Route::get('return_url', 'PayController@aliReturn');
//异步
Route::post('notify_url', 'PayController@aliNotify');


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
