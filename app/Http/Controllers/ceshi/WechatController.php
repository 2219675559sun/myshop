<?php

namespace App\Http\Controllers\ceshi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Controllers\Tools\Wechat;
class WechatController extends Controller
{
    public $wechat;
    public $request;
    public function __construct(Wechat $wechat,Request $request)
    {
        $this->wechat=$wechat;
        $this->request=$request;
    }
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
//    自动回复
    public function event(Request $request){
        //    接口配置
//        echo $_GET['echostr'];
//        die;

        //$this->checkSignature();
//        $data = file_get_contents("php://input");
//        //解析XML
//        $xml = simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);        //将 xml字符串 转换成对象
//        $xml = (array)$xml; //转化成数组
//        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
//        file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
//        $message = '你好,有什么需要帮助的!';
//        $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//        echo $xml_str;
//------------------------------------------------------------------------------------------------------------------
        $data = file_get_contents("php://input");
        //解析XML
        $xml = simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);        //将 xml字符串 转换成对象
        $xml = (array)$xml; //转化成数组
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
//        写入log日志
        file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
        $app=app('wechat.official_account');
        if($xml['MsgType'] == 'event'){//关注事件
            if($xml['Event'] == 'subscribe'){ //关注
                    //拉新操作
                $openid=DB::connection('mysqls')->table('wechat_openid')->where('openid',$xml['FromUserName'])->first();
            if(empty($openid)){
                $user = $app->user->get($xml['FromUserName']);
                dd($user);
                $res=DB::connection('mysqls')->table('wechat_openid')->insert([
                    'openid'=>$user['openid'],
                    'nickname'=>$this->wechat->filterEmoji($user['nickname']),
                    'subscribe'=>$user['subscribe'],
                    'sex'=>$user['sex'],
                    'country'=>$user['country'],
                    'province'=>$user['province'],
                    'city'=>$user['city'],
                    'headimgurl'=>$user['headimgurl'],
                    'subscribe_time'=>$user['subscribe_time'],
                ]);
            }
                if(empty($openid)){
                    $request->session()->put('name',$user['nickname']);
                }else{
                    $request->session()->put('name',$openid->nickname);
                }
                $message = '欢迎'.session('name').'登录';
                $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }else{
                $message = '欢迎'.session('name').'登录';
                $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }
        }

    }

}
