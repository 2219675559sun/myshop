<?php

namespace App\Http\Controllers\ceshi\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class Train12306Controller extends Controller
{
//    添加
    public function add(){

        return view('ceshi/atrain12306/add');
    }
    public function add_do(Request $request){

        $data=$request->all();
//        dd($data);
        $res=DB::connection('mysqls')->table('train')->insert([
            'carnum'=>$data['carnum'],
                'start'=>$data['start'],
                'place'=>$data['place'],
                'degree'=>$data['degree'],
                'number'=>$data['number'],
                'price'=>$data['price'],
                'add_time'=>strtotime($data['add_time']),
            'over_time'=>strtotime($data['over_time']),

            ]);
      if($res){
          return redirect('12306/index');
      }
    }
    public function index(Request $request){
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $num = $redis->incr('num');
        $all=$request->all()??'';
        $start=$all['start']??'';
        $place=$all['place']??'';
        if(!$redis->get($start.'-'.$place.'-')) {
//            echo 222;
            //搜索
            if (!empty($all['place']) || !empty($all['start'])) {
                $data = \DB::connection('mysqls')->table('train')
                    ->where('start', 'like', "%{$start}%")
                    ->where('place', 'like', "%{$place}%")
                    ->get();
                $all=$redis->incr($start.'-'.$place);
                echo $all;
            //如果访问次数大于5条存入redis
                if($all > 5) {
                    $data_info = json_encode($data);
                    $redis->set($start.'-'.$place.'-',$data_info, 3 * 60);
//                    dd($data_info);
                }

            } else {
                $data = \DB::connection('mysqls')->table('train')->get();
            }
        }else{
                $data=json_decode($redis->get($start.'-'.$place.'-'));
//                echo 11;
//                dd($data);
        }

        $number=\DB::connection('mysqls')->table('train')->get('number');
//        dd($data);
        return view('ceshi/atrain12306/index',['data'=>$data,'num'=>$num,'number'=>$number,'place'=>$place,'start'=>$start]);
    }

}
