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
//        表白
        $data = file_get_contents("php://input");
        //解析XML
        $xml = simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);        //将 xml字符串 转换成对象
        $xml = (array)$xml; //转化成数组
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
//        写入log日志
        file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
        if($xml['MsgType'] == 'event'){//关注事件
            if($xml['Event'] == 'subscribe'){ //关注
                if(isset($xml['EventKey'])){
                    //拉新操作
                    $agent_code = explode('_',$xml['EventKey'])[1];
                    $agent_info = DB::connection('mysqls')->table('wechat_user')->where(['uid'=>$agent_code,'openid'=>$xml['FromUserName']])->first();
                    if(empty($agent_info)){
                        DB::connection('mysqls')->table('wechat_user')->insert([
                            'uid'=>$agent_code,
                            'openid'=>$xml['FromUserName'],
                            'add_time'=>time()
                        ]);
                    }
                }
                $message = '余生还长 请多多指教!';
                $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }else{
                $message = '余生还长 请多多指教!';
                $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }
        }elseif($xml['MsgType'] == 'text'){
//            $message = '你好,有什么需要帮助的!';
//            $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
//            echo $xml_str;
            //全国油价
            //用户输入的查询内容
            $conent=$xml['Content'];
            $name=substr($conent,-6);
            $message='';
            if($name !="油价"){
                $message='请输入正确格式，如:北京油价';
            }else {
                //用户输入的查询的城市
                $local = substr($conent, 0, -6);
                $url = "http://www.vizhiguo.com/qil/call";
                $json = file_get_contents($url);
                $data = json_decode($json, 1);
                $city = $data['result'];
                foreach ($city as $k => $v) {
                    if (strstr($v['city'],$local)!=false) {
                        //记录查询次数
                        $redis=new \Redis;
                        $redis->connect('127.0.0.1',6379);
                        $redis->incr($v['city'].'油价');
                        //如果查询次数大于10次存入redis缓存
                        if($redis->get($v['city'].'油价')>='10'){

                            $redis->set($v['city'], json_encode($v,JSON_UNESCAPED_UNICODE));
                        }
                        //如果redis有缓存记录则从缓存拿数据否则查询
                        if($redis->get($v['city']) == false){
                            $message = $v['city'] . '最新油价' . "\n" . 'b90:' . $v['b90'] . '￥' . "\n" . 'b93:' . $v['b93'] . '￥' . "\n" . 'b97:' . $v['b97'] . '￥' . "\n" . 'b0:' . $v['b0'] . '￥' . "\n" . '92h:' . $v['92h'] . '￥' . "\n" . '95h:' . $v['95h'] . '￥' . "\n" . '98h:' . $v['98h'] . '￥' . "\n" . '0h:' . $v['0h'] . '￥';
                        }else{
                            $val=json_decode($redis->get($v['city']),1);
                            $message = $val['city'] . '最新油价!' . "\n" . 'b90:' . $val['b90'] . '￥' . "\n" . 'b93:' . $val['b93'] . '￥' . "\n" . 'b97:' . $val['b97'] . '￥' . "\n" . 'b0:' . $val['b0'] . '￥' . "\n" . '92h:' . $val['92h'] . '￥' . "\n" . '95h:' . $val['95h'] . '￥' . "\n" . '98h:' . $val['98h'] . '￥' . "\n" . '0h:' . $val['0h'] . '￥';
                        }
                    }
                    if(empty($message)){
                        $message="未查询到当前城市！请重新输入！";
                    }
                }
            }
            $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
            echo $xml_str;

        }

      //积分
       /* $data = file_get_contents("php://input");
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
            }
            if($xml['EventKey']=='CX'){
                $da=DB::connection('mysqls')->table('wechat_openid')->where('openid',$xml['FromUserName'])->first();
                $message = '当前积分：'.$da->integral;
                $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }
            if($xml['EventKey']=='QD'){
                $re=DB::connection('mysqls')->table('wechat_openid')->where('openid',$xml['FromUserName'])->first();

                if( $re->is_isset==1){
                    $message ='已签到';
                }else{
                    $message ='签到成功';
                    $re=DB::connection('mysqls')->table('wechat_openid')->where('openid',$xml['FromUserName'])->update([
                        'is_isset'=>'1',
                        'integral'=>$re->aa==5?$re->integral+5:$re->integral+($re->aa+1)*5,
                        'aa'=>$re->aa==5?'0':$re->aa+1,
                    ]);

                }
                $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }

        }*/

    }

    public function add(){

        $app=app('wechat.official_account');
            $info=$app->user->list($nextOpenId = null);
            $openid=$info['data'];
            foreach($openid['openid'] as $v){
               $moban= $app->template_message->send([
                    'touser' => $v,
                    'template_id' => 'b1Vy0a_WIGRNFqrWW2hFQLS9dgGHvplswhC21osRp5E',
                    'url' => 'https://easywechat.org',
                    'data' => [
                        'keyword' => '尊敬的用户您好，目前公司开展签到送积分兑换活动，详情进入公众号查看。',

        ],
    ]);
            }

dd($moban);

    }

}
