<?php

namespace App\Http\Controllers\ceshi\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

//物业系统
class RealController extends Controller
{
    public function log(){

        return view('ceshi.real.log');
    }
    public function log_do(Request $request){

    $data=$request->all();
//    dd($data);
        $res=DB::connection('mysqls')->table('denglu')->where(['name'=>$data['name'],'pwd'=>md5($data['pwd']),'right'=>0])->first();
        if($res){
            $request->session()->put('name',$data['name']);
            return redirect('real/index');
        }else{
            return back();
        }
    }
        public function index(){

            return view('ceshi.real.index');

    }
//    车位管理
        public function add_carport(){

            return view('ceshi.real.add_carport');

    }
    public function add_carport_do(Request $request){
        $data=$request->all();
//        dd($data);
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $num=$redis->set('number',$data['number']);
        $redis->set('num',$num);
        if($num){
            return redirect('real/index');
        }else{
            return back();
        }


    }
    //数据统计
    public function count(){

        $add=strtotime('00:00:00');
        $over=strtotime('24:00:00');
//        dd(date('Y-m-d H:i:s',$add));
        $where=[
            ['add_time','>',$add],
            ['over_time','<',$over],
        ];
        $data=DB::connection('mysqls')->table('vehicle')->where($where)->count();
//       dd($res);
        $res=DB::connection('mysqls')->table('vehicle')->where($where)->select('price')->get();
        $price=0;
        foreach($res as $k=>$v){
            $price+=$v->price;

        }
//        dd($price);
        return view('ceshi.real.count',['data'=>$data,'price'=>$price]);
    }
    //门卫管理
    public function add_doorkeeper(){

        return view('ceshi.real.add_doorkeeper');
    }
    public function add_doorkeeper_do(Request $request){
        $data=$request->all();
        $res=DB::connection('mysqls')->table('denglu')->insert([
            'name'=>$data['name'],
            'pwd'=>md5($data['pwd']),
        ]);
        if($res){
            return redirect('real/index');
        }else{
            return back();
        }
    }
}
