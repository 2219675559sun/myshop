<?php

namespace App\Http\Controllers\ceshi\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntegralController extends Controller
{
    public function event(){
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
    }
}
