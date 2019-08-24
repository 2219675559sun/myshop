<?php

namespace App\Http\Controllers\ceshi\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tools\Wechat;
use GuzzleHttp\Client;
use DB;
//公众号表白小功能
class ConfessionController extends Controller
{
    public $wechat;
    public $request;
    public function __construct(Wechat $wechat,Request $request)
    {
        $this->wechat=$wechat;
        $this->request=$request;
    }

    //添加表白功能按钮
    public function add_menu(){
        $data=DB::connection('mysqls')->table('menu')->get();
        $info=[];
            foreach($data as $v){
                if($v->one_name!=''){
                    $info[]=$v;
                }
                foreach($data as $val){
                    if($v->id==$val->menu){
                        $info[]=$val;
                    }
                }
            }
        return view('ceshi.wechat.confession.add_menu',['data'=>$data,'info'=>$info]);
    }
    public function add_menu_do(Request $request){
        $arr=$request->all();
//            一级分类
            $res=DB::connection('mysqls')->table('menu')->insert([
                $arr['men']==1?'one_name':'two_name'=>$arr['name'],
                'menu'=>$arr['men']==1?'0':$arr['menu'],
                'type'=>$arr['type'],
                'url'=>$arr['url'],
                'add_time'=>time(),
            ]);
            $this->menu();
    }
    //刷新菜单
    public function menu(){
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$this->wechat->access_token()}";
        $info=DB::connection('mysqls')->table('menu')->get()->toArray();
        $data=[];
        foreach ($info as $k => $v) {
            if($v->menu==0){
                //一级菜单
                $data["button"][] = [
                    "type" => $v->type,
                    "name" => $v->one_name,
                    $v->type=='click'?"key":"url" => $v->url,
                ];
            }else{
                $sub_button=[];
//                二级菜单
                $list = DB::connection('mysqls')->table('menu')->where('menu', $v->id)->get()->toArray();
                foreach($list as $val){
                    if($val->type=='click'){
                        $sub_button[] = [
                            "type" => $val->type,
                            "name" => $val->two_name,
                            "key" => $val->url,
                        ];
                    }else{
                        $sub_button[] = [
                            "type" => $val->type,
                            "name" => $val->two_name,
                            "url" => $val->url,
                        ];
                    }
                }
                if(!empty($sub_button)){
                    $data['button'][]=['name'=>$v->one_name,'sub_button'=>$sub_button];
                }
            }
        }
        $res=$this->wechat->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        dd($res);
    }
    //添加表白内容
    public function log(){
        return view('ceshi.wechat.confession.log');
    }
    public function login(){
        //执行登录
        $redirect_uri=env('redirect_uri').'/confession/code';
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
//        header('location:'.$url);
        return redirect($url);
    }
    public function code(Request $request){
            $code=$request->all()['code'];
            $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code={$code}&grant_type=authorization_code";
            $re=file_get_contents($url);
            $access_token=json_decode($re,1)['access_token'];
            $openid=json_decode($re,1)['openid'];

            $this->user($access_token,$openid);
    }
    //登录成功存入数据库
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
        header('location:add_confession');
    }
    public function add_confession(){
            $url="https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->wechat->access_token()."&next_openid=";
            $data=file_get_contents($url);
            $data=json_decode($data,1);
            $openid=$data['data']['openid'];
            foreach($openid as $k=>$v){
                $list=DB::connection('mysqls')->table('wechat_openid')->where('openid',$v)->first();
               if(empty($list)){
                   $http="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$this->wechat->access_token()}&openid={$v}&lang=zh_CN";
                    $user=json_decode(file_get_contents($http),1);
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
               };
            }
        $data=DB::connection('mysqls')->table('wechat_openid')->get();
        return view('ceshi.wechat.confession.add_confession',['data'=>$data]);
    }
    public function confession_do(Request $request){
        $arr=$request->all();
        //表白内容入库
        $list=DB::connection('mysqls')->table('confession_list')->insert([
            'openid'=>$arr['openid'],
            'center'=>$this->wechat->filterEmoji($arr['conect']),
            'add_time'=>time(),
        ]);
        //推送表白内容
       $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->wechat->access_token()}";
            $data=[
                    "touser"=>$arr['openid'],
           "template_id"=>"mWSF0Hwdk31PV4lYxH0rTUva9gKDo-8jM-2VtwizxKA",
           "url"=>"http://vizhiguo.com/confession/confession_index",
           "data"=>[
                    "first"=> [
                        "value"=>$arr['type']==1?'有人匿名向你表白':session('name').' 向你表白',
                       "color"=>"#173177"
                   ],
                   "keyword1"=>[
                        "value"=>$arr['conect'],
                       "color"=>"#173177"
                   ],
               "keyword2"=>[
                   "value"=>date('Y-m-d H:i:s',time()),
                   "color"=>"#173177"
               ],
                   "remark"=>[
                        "value"=>"有情人终成眷属",
                       "color"=>"#173177"
                   ]
           ]
            ];
        $this->wechat->post($url,json_encode($data));
        header('location:confession_index');
    }
    public function confession_index(){

        return view('ceshi.wechat.confession.confession_index');
    }
    //我的表白
    public function list(){
        $data=DB::connection('mysqls')->table('confession_list')->where('openid',session('openid'))->get();
        return view('ceshi.wechat.confession.list',['data'=>$data]);
    }
}
