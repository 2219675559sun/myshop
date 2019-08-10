<?php

namespace App\Http\Controllers\ceshi\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
//门卫管理系统
class CarController extends Controller
{
    public function index(){

        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $number=$redis->get('number');
        $num=$redis->get('num');
        return view('ceshi.real.index.index',['number'=>$number,'num'=>$num]);
    }
    //车辆入库
    public function enter(){

        return view('ceshi.real.index.enter');
    }
    public function enter_do(Request $request){
    $data=$request->all();
    $one=DB::connection('mysql')->table('vehicle')->where('car',$data['car'])->first();
//如果不存在则添加否则修改
    if($one==null){
        $res=DB::connection('mysql')->table('vehicle')->insert([
            'car'=>$data['car'],
            'add_time'=>time(),
        ]);
    }else{
    if($one->is_exist==1){
        echo '车辆已存在';die;
    }
        if($one->is_exist==2){
            $res=DB::connection('mysql')->table('vehicle')->where('car',$data['car'])->update([
                'is_exist'=>1,
                'add_time'=>time(),
            ]);
        }
    }

    if($res){
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $num=$redis->get('num')-1;
        $redis->set('num',$num);
        return redirect('car/index');
    }else{
        return back();
    }

    }
    //车辆出库
    public function come(){

        return view('ceshi.real.index.come');
    }
    public function come_do(Request $request){
        $data=$request->all();
        $one=DB::connection('mysql')->table('vehicle')->where('car',$data['car'])->first();
//        dd($one);
        if(!$one){
            echo '车辆不存在';die;
        }
        if($one->is_exist==2){
            echo '车辆已离开';die;
        }

        $res=DB::connection('mysql')->table('vehicle')->where('car',$data['car'])->update([
            'is_exist'=>2,
            'over_time'=>time(),
        ]);
//        dd($res);
        if($res){
            $request->session()->put('car',$data['car']);
            $redis=new \Redis;
            $redis->connect('127.0.0.1','6379');
            $num=$redis->get('num')+1;
            $redis->set('num',$num);
            return redirect('car/charge');
        }else{
            return back();
        }
    }
    //收费情况
    public function charge(){
        $car=session('car');
        $data=DB::connection('mysql')->table('vehicle')->where('car',$car)->first();
//        dd($data);
//        dump(date('Y-m-d H:i:s',$data->add_time));
//        dump(date('Y-m-d H:i:s',$data->over_time));
        $time=$data->over_time-$data->add_time;
       //计算天数
        $day=intval($time/86400);
        //计算小时
        $remain = $time%86400;
        $h = intval($remain/3600);
        //计算分钟
        $remain = $time%3600;
        $i = intval($remain/60);
        $a=0;
        $b=0;
        $c=0;
        $d=0;
        $f=0;
        $g=0;
//        dump($h);
//        dump($i);
    if($i<15 && $h==0){
   $price=0;
    }else{
        if($i<30 && $h<6){
            $a=2;
        }else{
            $a=4;
        }
        if($h<6){
            $b=$h*2*2;
        }
        if($h>6){
            $c=$h-6;
            $d=12*2;
            $a=1;
        }
        if($day<0){
            $e=$day*24;
            $f=$e-6;
            $g=12*2;
        }

    }
    $price=$a+$b+$c+$d+$f+$g;
        $res=DB::connection('mysql')->table('vehicle')->where('car',$car)->update([
            'price'=>$price,
        ]);
        return view('ceshi.real.index.charge',['data'=>$data,'day'=>$day,'h'=>$h,'i'=>$i,'price'=>$price]);

    }
}
