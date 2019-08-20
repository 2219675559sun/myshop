<?php

namespace App\Http\Controllers\ceshi\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tools\Wechat;
use DB;
//微信留言功能
class LiuyanController extends Controller
{
    public $request;
    public $wechat;
    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request=$request;
        $this->wechat=$wechat;
    }

    //留言登录
    public function log(){
//        登录
        $http="http://www.myshop.com/liuyan/code";
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri={$http}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('location:'.$url);
    }
    //获取code
    public function code(Request $request){
        $code=$request->all()['code'];
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code={$code}&grant_type=authorization_code";
        $re=file_get_contents($url);
        $data=json_decode($re,1);
        $access_token=$data['access_token'];
        $openid=$data['openid'];
        $this->user($access_token,$openid);
    }
    public function user($access_token,$openid){
            $url="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            $list=file_get_contents($url);
            $this->request->session()->put('nickname',json_decode($list,1)['nickname']);
            $this->request->session()->put('openid',json_decode($list,1)['openid']);
            //入库
        $res=DB::connection('mysqls')->table('wechat_user')->where('openid',$openid)->first();
        if(empty($res)){
            DB::connection('mysqls')->beginTransaction();
            $uid=DB::connection('mysqls')->table('weixin_user')->insertGetId([
                'name'=>json_decode($list,1)['nickname'],
                'pwd'=>'',
                'reg_time'=>time(),
            ]);
            $list=DB::connection('mysqls')->table('wechat_user')->insert([
                'uid'=>$uid,
                'openid'=>json_decode($list,1)['openid'],
                'add_time'=>time(),
            ]);
            DB::connection('mysqls')->commit();
        }
//            推送用户信息
        $data=[

                 "touser"=>$openid,
           "template_id"=>"mWSF0Hwdk31PV4lYxH0rTUva9gKDo-8jM-2VtwizxKA",
           "url"=>"http://baidu.com",
           "data"=>[
                 "first"=> [
                     "value"=>"欢迎 ".session('nickname').' 登录',
                       "color"=>"#173177"
                   ],
                   "keyword2"=> [
                     "value"=>date('Y-m-d H:i:s',time()),
                       "color"=>"#173177"
                   ],
                   "remark"=>[
                     "value"=>"祝您生活愉快！",
                       "color"=>"#173177"
                   ]
           ]
        ];
        $info="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->wechat->access_token()}";
        $re=$this->wechat->post($info,json_encode($data));

        header('location:index');
    }
    public function index(){
        $list=DB::connection('mysqls')->table('weixin_user')
            ->join('wechat_user', 'uid', '=', 'weixin_user.id')
            ->select('weixin_user.name', 'wechat_user.openid','wechat_user.uid')
            ->get();
        return view('ceshi.wechat/liuyan/index',['list'=>$list]);
    }
    public function liuyan(Request $request){
        $openid=$request->all()['openid'];

        return view('ceshi.wechat/liuyan/liuyan',['openid'=>$openid]);
    }
    public function liuyan_do(Request $request){
        $arr=$request->all();
        $uid=DB::connection('mysqls')->table('wechat_user')->where('openid',session('openid'))->first();
        $liuyan=DB::connection('mysqls')->table('liuyan')->insert([
            'uid'=>$uid->uid,
            'content'=>$arr['content'],
            'add_time'=>time(),
        ]);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->wechat->access_token()}";
        $data=[

            "touser"=>$arr['openid'],
            "template_id"=>"yRAGXo9BbjNkRLQ7pqAyMxS0BlpZS8KKPVrBpol2QoY",
            "url"=>"http://baidu.com",
            "data"=>[
                "first"=> [
                    "value"=>session('nickname').' 给您留言',
                    "color"=>"#173177"
                ],
                "keyword"=> [
                    "value"=>$arr['content'],
                    "color"=>"#173177"
                ],
                "keyword1"=> [
                    "value"=>date('Y-m-d H:i:s',time()),
                    "color"=>"#173177"
                ],
            ]
        ];
        $re=$this->wechat->post($url,json_encode($data));
        header('location:index');
    }
    public function list(){
        $uid=DB::connection('mysqls')->table('wechat_user')->where('openid',session('openid'))->first();
        $data=DB::connection('mysqls')->table('liuyan')->where('uid',$uid->uid)->get();

        return view('ceshi.wechat/liuyan/list',['data'=>$data]);
    }
}
