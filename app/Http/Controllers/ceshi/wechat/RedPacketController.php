<?php

namespace App\Http\Controllers\ceshi\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tools\Wechat;
use DB;
class RedPacketController extends Controller
{
    public $request;
    public $wechat;
    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request=$request;
        $this->wechat=$wechat;
    }

    //微信红包系统
    public function log(){
        return view('ceshi.wechat.redPacket.log');
    }
    public function login(){
        $http="http://www.myshop.com/redPacket/code";
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlencode($http)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('location:'.$url);
    }
    public function code(Request $request){
            $code=$request->all()['code'];
            $url=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code={$code}&grant_type=authorization_code");
            $access_token=json_decode($url,1)['access_token'];
            $openid=json_decode($url,1)['openid'];
            $this->user($access_token,$openid);
    }
    public function user($access_token,$openid){
        $url="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $user=file_get_contents($url);
        $data=json_decode($user,1);
        $this->request->session()->put('name',$data['nickname']);
        $this->request->session()->put('openid',$openid);
        $res=DB::connection('mysqls')->table('wechat_user')->where('openid',$openid)->first();
        if(empty($res)){
            DB::connection('mysqls')->beginTransaction();
            $uid=DB::connection('mysqls')->table('weixin_user')->insertGetId([
                'name'=>$this->wechat->filterEmoji($data['nickname']),
                'pwd'=>'',
                'reg_time'=>time(),
            ]);
            $list=DB::connection('mysqls')->table('wechat_user')->insert([
                'uid'=>$uid,
                'openid'=>$data['openid'],
                'add_time'=>time(),
            ]);
            DB::connection('mysqls')->commit();
        }
//        return redirect('confession/add_confession');
        header('location:red_packet_list');
    }
    public function red_packet_list(){

        return view('ceshi.wechat.redPacket.red_packet_list');
    }
}
