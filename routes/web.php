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


//登录页面
Route::get('/admin/login', 'admin\AdminController@login');
Route::post('/admin/login_do', 'admin\AdminController@login_do');
Route::group(['middleware' => ['admin']], function () {
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
//周测
//12306添加
Route::get('/12306/add', 'ceshi\admin\Train12306Controller@add');
Route::post('/12306/add_do', 'ceshi\admin\Train12306Controller@add_do');
Route::get('/12306/index', 'ceshi\admin\Train12306Controller@index');
//考试系统
Route::get('/test/log', 'ceshi\admin\TestController@log');
Route::post('/test/log_do', 'ceshi\admin\TestController@log_do');
Route::get('/test/index', 'ceshi\admin\TestController@index');
Route::get('/test/add', 'ceshi\admin\TestController@add');
Route::post('/test/radio', 'ceshi\admin\TestController@radio');
Route::post('/test/checkbox', 'ceshi\admin\TestController@checkbox');
Route::post('/test/exists', 'ceshi\admin\TestController@exists');
//调研系统
Route::get('/probe/log', 'ceshi\admin\ProbeController@log');
Route::post('/probe/log_do', 'ceshi\admin\ProbeController@log_do');
Route::get('/probe/index', 'ceshi\admin\ProbeController@index');
Route::get('/probe/theme_add', 'ceshi\admin\ProbeController@theme_add');
Route::post('/probe/theme_add_do', 'ceshi\admin\ProbeController@theme_add_do');
Route::get('/probe/question_add', 'ceshi\admin\ProbeController@question_add');
Route::post('/probe/question_add_do', 'ceshi\admin\ProbeController@question_add_do');
Route::get('/probe/http', 'ceshi\admin\ProbeController@http');
Route::get('/probe/list', 'ceshi\admin\ProbeController@list');
//球队竞猜
Route::get('/team/queueadd', 'ceshi\admin\TeamController@queueadd');
Route::post('/team/queueadd_do', 'ceshi\admin\TeamController@queueadd_do');
Route::get('/team/index', 'ceshi\admin\TeamController@index');
Route::get('/team/queue', 'ceshi\admin\TeamController@queue');
Route::get('/team/update_resule', 'ceshi\admin\TeamController@update_resule');
Route::post('/team/update_resule_do', 'ceshi\admin\TeamController@update_resule_do');
Route::get('/team/list', 'ceshi\admin\TeamController@list');
Route::get('/team/list_queue', 'ceshi\admin\TeamController@list_queue');
Route::post('/team/list_queue_do', 'ceshi\admin\TeamController@list_queue_do');
//小区物业管理
Route::get('/real/log', 'ceshi\admin\RealController@log');
Route::post('/real/log_do', 'ceshi\admin\RealController@log_do');

Route::group(['middleware' => ['real']], function () {
    //
Route::get('/real/index', 'ceshi\admin\RealController@index');
Route::get('/real/add_carport', 'ceshi\admin\RealController@add_carport');
Route::get('/real/add_carport_do', 'ceshi\admin\RealController@add_carport_do');
Route::get('/real/count', 'ceshi\admin\RealController@count');
Route::get('/real/add_doorkeeper', 'ceshi\admin\RealController@add_doorkeeper');
Route::post('/real/add_doorkeeper_do', 'ceshi\admin\RealController@add_doorkeeper_do');
});
//门卫管理
Route::get('/car/index', 'ceshi\index\CarController@index');
Route::get('/car/enter', 'ceshi\index\CarController@enter');
Route::post('/car/enter_do', 'ceshi\index\CarController@enter_do');
Route::get('/car/come', 'ceshi\index\CarController@come');
Route::post('/car/come_do', 'ceshi\index\CarController@come_do');
Route::get('/car/charge', 'ceshi\index\CarController@charge');


//考试
//留言
Route::get('/leave/log', 'kaoshi\LeaveController@log');
Route::post('/leave/log_do', 'kaoshi\LeaveController@log_do');
Route::group(['middleware' => ['leave']], function () {

    Route::get('/leave/index', 'kaoshi\LeaveController@index');
    Route::post('/leave/add_do', 'kaoshi\LeaveController@add_do');
    Route::get('/leave/delete', 'kaoshi\LeaveController@delete');

});
//接口
Route::post('/leave/info', 'kaoshi\LeaveController@info');
/////////////////////////////////////////////////////////////////////////////
/// 接口测试
Route::get('/wechat/list', 'ceshi\WechatController@list');
Route::get('/wechat/info', 'ceshi\WechatController@info');
/// ///////////////////////////////////////////////////////////////////////
/// 微信登录
Route::get('/weixin/log', 'ceshi\WeixinController@log');
Route::get('/weixin/log_do', 'ceshi\WeixinController@log_do');
Route::get('/weixin/code', 'ceshi\WeixinController@code');
//打印用户的详细信息
Route::get('/weixin/user_info', 'ceshi\WeixinController@user_info');
//用户列表
//中间件
Route::group(['middleware' => ['admin']], function () {

Route::get('/weixin/index', 'ceshi\WeixinController@index');
Route::get('/weixin/user_list', 'ceshi\WeixinController@user_list');
Route::get('/weixin/index_list', 'ceshi\WeixinController@index_list');
//微信模板列表
Route::get('/weixin/moban', 'ceshi\WeixinController@moban');
//新增临时素材
Route::get('/weixin/uploadSource', 'ceshi\WeixinController@upload_source');
Route::post('/weixin/do_upload', 'ceshi\WeixinController@do_upload');
//获取临时素材
Route::get('/weixin/get_image_source', 'ceshi\WeixinController@get_image_source');
//获取语音
Route::get('/weixin/get_voice_source', 'ceshi\WeixinController@get_voice_source');
//视屏
Route::get('/weixin/get_video_source', 'ceshi\WeixinController@get_video_source');
//获取单条永久素材
Route::get('/weixin/one_source_list', 'ceshi\WeixinController@one_source_list');
//获取素材列表
Route::get('/weixin/source_list', 'ceshi\WeixinController@source_list');
//获取素材总数
Route::get('/weixin/source_count', 'ceshi\WeixinController@source_count');
//删除永久素材
Route::get('/weixin/source_delete', 'ceshi\WeixinController@source_delete');
//清除接口调用次数
Route::get('/weixin/out', 'ceshi\WeixinController@out');


//用户标签管理
//创建标签
Route::get('/weixin/add_tag', 'ceshi\WeixinController@add_tag');
Route::post('/weixin/add_tag_do', 'ceshi\WeixinController@add_tag_do');
//获取标签
Route::get('/weixin/tag_index', 'ceshi\WeixinController@tag_index');
//修改标签
Route::get('/weixin/tagUpdate', 'ceshi\WeixinController@tagUpdate');
Route::post('/weixin/tagUpdate_do', 'ceshi\WeixinController@tagUpdate_do');
//删除标签
Route::get('/weixin/tagDelete', 'ceshi\WeixinController@tagDelete');
//标签下的粉丝列表
Route::get('/weixin/tagList', 'ceshi\WeixinController@tagList');
//添加粉丝到该标签
Route::get('/weixin/addFansTag', 'ceshi\WeixinController@addFansTag');
Route::post('/weixin/addFansTag_do', 'ceshi\WeixinController@addFansTag_do');
//取消该标签下的粉丝
Route::post('/weixin/out_fans_tag', 'ceshi\WeixinController@out_fans_tag');
//查看用户下的标签
Route::get('/weixin/get_tag', 'ceshi\WeixinController@get_tag');
//根据标签推送消息
Route::get('/weixin/tag_push', 'ceshi\WeixinController@tag_push');
Route::post('/weixin/tag_push_do', 'ceshi\WeixinController@tag_push_do');
});
//公众号自动回复消息
Route::post('/wechat/event', 'ceshi\WechatController@event');
//获取永久二维码
Route::get('/weixin/qrCode', 'ceshi\WeixinController@qrCode');
//个人信息
Route::get('/weixin/one_list', 'ceshi\WeixinController@one_list');
//图片下载
Route::get('/weixin/download', 'ceshi\WeixinController@download');
//自定义菜单创建
Route::get('/menu/add_menu', 'ceshi\MenuController@add_menu');
Route::post('/menu/add_menu_do', 'ceshi\MenuController@add_menu_do');
//执行接口
Route::get('/menu/menu', 'ceshi\MenuController@menu');
//菜单查询
Route::get('/menu/menu_list', 'ceshi\MenuController@menu_list');
//删除菜单
Route::get('/menu/delete_menu', 'ceshi\MenuController@delete_menu');


//公众号 表白小功能
//登录
Route::get('/confession/log', 'ceshi\wechat\ConfessionController@log');
Route::get('/confession/login', 'ceshi\wechat\ConfessionController@login');
Route::group(['middleware' => ['confession']], function () {
    //
Route::get('/confession/add_menu', 'ceshi\wechat\ConfessionController@add_menu');
Route::post('/confession/add_menu_do', 'ceshi\wechat\ConfessionController@add_menu_do');
//刷新列表
Route::get('/confession/menu', 'ceshi\wechat\ConfessionController@menu');
//获取code
Route::get('/confession/code', 'ceshi\wechat\ConfessionController@code');
//添加表白消息
Route::get('/confession/add_confession', 'ceshi\wechat\ConfessionController@add_confession');
Route::post('/confession/confession_do', 'ceshi\wechat\ConfessionController@confession_do');
//成功提示信息
Route::get('/confession/confession_index', 'ceshi\wechat\ConfessionController@confession_index');
//我的表白
Route::get('/confession/list', 'ceshi\wechat\ConfessionController@list');
});
//-----------------------------------------------------------------------------------------------------------
//微信留言
Route::get('/liuyan/log', 'ceshi\wechat\LiuyanController@log');
//获取code
Route::get('/liuyan/code', 'ceshi\wechat\LiuyanController@code');
//粉丝列表页
Route::get('/liuyan/index', 'ceshi\wechat\LiuyanController@index');
//留言列表
Route::get('/liuyan/liuyan', 'ceshi\wechat\LiuyanController@liuyan');
Route::post('/liuyan/liuyan_do', 'ceshi\wechat\LiuyanController@liuyan_do');

Route::get('/liuyan/list', 'ceshi\wechat\LiuyanController@list');
//------------------------------------------------------------------------------------------------------
//油价管理
Route::get('/qil/qil_peice', 'ceshi\wechat\OilPriceController@qil_peice');
//油价调用链接
Route::get('/qil/call', 'ceshi\wechat\OilPriceController@call');

//---------------------------------------------------------------------------------------------------------
//微信红包
//微信授权登录
Route::get('/redPacket/log', 'ceshi\wechat\RedPacketController@log');
Route::get('/redPacket/login', 'ceshi\wechat\RedPacketController@login');
Route::get('/redPacket/login_do', 'ceshi\wechat\RedPacketController@login_do');
//获取code
Route::get('/redPacket/code', 'ceshi\wechat\RedPacketController@code');
//红包算法
Route::get('/redPacket/red_packet_list', 'ceshi\wechat\RedPacketController@red_packet_list');

//----------------------------------------------------------------------------------------
//积分
Route::post('/integral/event', 'ceshi\wechat\IntegralController@event');


