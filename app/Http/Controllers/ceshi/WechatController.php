<?php

namespace App\Http\Controllers\ceshi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    //单个用户
    public function info(){
        $openid='oC0jbweAEtwLl5CBZrluOa3VKFrg';
        $access_token=$this->access_token();
        $user=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
        $user_list=json_decode($user,1);
        dd($user_list);

    }
    public function list(){
        //获取关注用户列表
        $access_token=$this->access_token();
//        dd($access_token);
        $user=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
        $user_list=json_decode($user,1);
        dd($user_list);
    }
    public function access_token(){
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $access_token_key='access_token';
        if($redis->exists($access_token_key)){
            $access_token=$redis->get('access_token');
        }else{
//        获取access_token
        $data=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."");
        $access=json_decode($data,1);
        $access_token=$access['access_token'];
        $expires_time=$access['expires_in'];
        $redis->set($access_token_key,$access_token,$expires_time);
        }
        return $access_token;
    }
//    接口配置
    public function event(){
        echo $_GET['echostr'];
        die;
    }
}
