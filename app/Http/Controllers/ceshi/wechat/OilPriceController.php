<?php

namespace App\Http\Controllers\ceshi\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tools\Wechat;
class OilPriceController extends Controller
{
    public function __construct(Wechat $wechat)
    {
        $this->wechat=$wechat;
    }

    public function qil_peice(){
//        压缩
        $str="aavvjjjd";
        $num=strlen($str);
        $a='';
        $b=0;
        for($i=0;$i<=$num-1;$i++){
            $c=substr($str,$i,1);
            $d=substr($str,$i+1,1);
            if($c==$d){
                $b+=1;
            }else{
                if($b!=0){
                    $a.=$b.$c;
                }else{
                    $a.=$c;
                }
                $b=0;
            }
        }
        echo $a;
        die;
        //字符串翻转
        $string='abcd';
            $str_new='';
            $count=strlen($string)-1;
            for($m=$count;$m>=0;$m--){
                $str_new.=$string{$m};
            }
        echo $str_new;

        die;
//        $redis=new \Redis;
//        $redis->connect('127.0.0.1','6379');
//        $a="天津";
////        $redis->set('ceshi',$a);
//        dd($redis->del($a));
//        die;
        $url="http://www.vizhiguo.com/qil/call";
        $data=file_get_contents($url);
        $data=json_decode($data,1);
        $city = $data['result'];
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');

//        dd($redis->del($a));
        foreach ($city as $k => $v) {
//            查询存入redis里的数据
            if($redis->exists($v['city'])){
                $city_info=json_decode($redis->get($v['city']),1);
//                如果数据更新查出来
               foreach($v as $k=>$val){
                   if($val != $city_info[$k]){
//                    模板推送
                       $app=app('wechat.official_account');
                       //查询用户
                       $openid_list=$app->user->list($nextOpenId = null);
                       $openid=$openid_list['data'];
                       //循环展示用户的openid

                       foreach($openid['openid']  as $va){
                          dump($va);
                     $moban=$app->template_message->send([
                           'touser' =>'oC0jbwb7N0sRXXHi-O_EJUcahS94',
                           'template_id' => 'MOtuco--HJATnyPCuegGKQR27e2u2NNycf4pyMpuX58',
                           'url' => 'http://www.vizhiguo.com/confession/add_confession',
                           'data' => [
                               'keyword' => $v['city'] . '最新油价' . "\n" . 'b90:' . $v['b90'] . '￥' . "\n" . 'b93:' . $v['b93'] . '￥' . "\n" . 'b97:' . $v['b97'] . '￥' . "\n" . 'b0:' . $v['b0'] . '￥' . "\n" . '92h:' . $v['92h'] . '￥' . "\n" . '95h:' . $v['95h'] . '￥' . "\n" . '98h:' . $v['98h'] . '￥' . "\n" . '0h:' . $v['0h'] . '￥',
                                'keyword1'=>date('Y-m-d H:i:s',time()),
                               'remark'=>'如有打扰 尽情谅解',
                        ],
                    ]);
                       }
                   }
               }
            }
        }

//        dd($moban);
    }
    //调用全国油价数据
    public function call(){
     $info='{"resultcode":"200","reason":"查询成功!","result":[{"city":"北京","b90":"-","b93":"6.44","b97":"6.87","b0":"6.21","92h":"6.54","95h":"6.97","98h":"7.95","0h":"6.21"},{"city":"上海","b90":"-","b93":"6.51","b97":"6.93","b0":"6.15","92h":"6.51","95h":"6.93","98h":"7.63","0h":"6.15"},{"city":"江苏","b90":"-","b93":"6.52","b97":"6.94","b0":"6.14","92h":"6.52","95h":"6.94","98h":"7.82","0h":"6.14"},{"city":"天津","b90":"-","b93":"6.63","b97":"6.90","b0":"6.17","92h":"6.53","95h":"6.90","98h":"7.82","0h":"6.17"},{"city":"重庆","b90":"-","b93":"6.62","b97":"6.99","b0":"6.25","92h":"6.62","95h":"6.99","98h":"7.88","0h":"6.25"},{"city":"江西","b90":"-","b93":"6.51","b97":"6.99","b0":"6.21","92h":"6.51","95h":"6.99","98h":"7.99","0h":"6.21"},{"city":"辽宁","b90":"-","b93":"6.52","b97":"6.95","b0":"6.09","92h":"6.52","95h":"6.95","98h":"7.57","0h":"6.09"},{"city":"安徽","b90":"-","b93":"6.51","b97":"6.99","b0":"6.20","92h":"6.51","95h":"6.99","98h":"7.82","0h":"6.20"},{"city":"内蒙古","b90":"-","b93":"6.49","b97":"6.92","b0":"6.06","92h":"6.49","95h":"6.92","98h":"7.60","0h":"6.06"},{"city":"福建","b90":"-","b93":"6.52","b97":"6.96","b0":"6.17","92h":"6.52","95h":"6.96","98h":"7.62","0h":"6.17"},{"city":"宁夏","b90":"-","b93":"6.46","b97":"6.82","b0":"6.07","92h":"6.46","95h":"6.82","98h":"8.01","0h":"6.07"},{"city":"甘肃","b90":"-","b93":"6.44","b97":"6.88","b0":"6.08","92h":"6.44","95h":"6.88","98h":"7.32","0h":"6.08"},{"city":"青海","b90":"-","b93":"6.50","b97":"6.97","b0":"6.11","92h":"6.50","95h":"6.97","98h":"0","0h":"6.11"},{"city":"广东","b90":"-","b93":"6.57","b97":"7.11","b0":"6.18","92h":"6.57","95h":"7.11","98h":"7.99","0h":"6.18"},{"city":"山东","b90":"-","b93":"6.62","b97":"7.00","b0":"6.16","92h":"6.52","95h":"7.00","98h":"7.72","0h":"6.16"},{"city":"广西","b90":"-","b93":"6.61","b97":"7.14","b0":"6.23","92h":"6.61","95h":"7.14","98h":"7.92","0h":"6.23"},{"city":"山西","b90":"-","b93":"6.50","b97":"7.02","b0":"6.23","92h":"6.50","95h":"7.02","98h":"7.72","0h":"6.23"},{"city":"贵州","b90":"-","b93":"6.67","b97":"7.05","b0":"6.28","92h":"6.67","95h":"7.05","98h":"7.95","0h":"6.28"},{"city":"陕西","b90":"-","b93":"6.44","b97":"6.80","b0":"6.08","92h":"6.44","95h":"6.80","98h":"7.60","0h":"6.08"},{"city":"海南","b90":"-","b93":"7.66","b97":"8.13","b0":"6.26","92h":"7.66","95h":"8.13","98h":"9.18","0h":"6.26"},{"city":"四川","b90":"-","b93":"6.58","b97":"7.09","b0":"6.27","92h":"6.58","95h":"7.09","98h":"7.72","0h":"6.27"},{"city":"河北","b90":"-","b93":"6.53","b97":"6.90","b0":"6.17","92h":"6.53","95h":"6.90","98h":"7.73","0h":"6.17"},{"city":"西藏","b90":"-","b93":"7.43","b97":"7.86","b0":"6.73","92h":"7.43","95h":"7.86","98h":"0","0h":"6.73"},{"city":"河南","b90":"-","b93":"6.55","b97":"6.99","b0":"6.16","92h":"6.55","95h":"6.99","98h":"7.64","0h":"6.16"},{"city":"新疆","b90":"-","b93":"6.42","b97":"6.92","b0":"6.06","92h":"6.42","95h":"6.92","98h":"7.73","0h":"6.06"},{"city":"黑龙江","b90":"-","b93":"6.48","b97":"6.87","b0":"5.95","92h":"6.48","95h":"6.87","98h":"7.84","0h":"5.95"},{"city":"吉林","b90":"-","b93":"6.51","b97":"7.02","b0":"6.10","92h":"6.51","95h":"7.02","98h":"7.65","0h":"6.10"},{"city":"云南","b90":"-","b93":"6.69","b97":"7.18","b0":"6.25","92h":"6.69","95h":"7.18","98h":"7.86","0h":"6.25"},{"city":"湖北","b90":"-","b93":"6.55","b97":"7.01","b0":"6.16","92h":"6.55","95h":"7.01","98h":"7.58","0h":"6.16"},{"city":"浙江","b90":"-","b93":"6.52","b97":"6.94","b0":"6.16","92h":"6.52","95h":"6.94","98h":"7.60","0h":"6.16"},{"city":"湖南","b90":"-","b93":"6.50","b97":"6.90","b0":"6.23","92h":"6.50","95h":"6.90","98h":"7.71","0h":"6.23"}],"error_code":0}';
    echo $info;
    }
}
