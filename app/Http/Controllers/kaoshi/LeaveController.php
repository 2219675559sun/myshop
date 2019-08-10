<?php

namespace App\Http\Controllers\kaoshi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class LeaveController extends Controller
{
    //接口
    public function info(Request $request){
        if($request->all()['access_token']!=12345 || empty($request->all()['access_token'])){
            echo 'access_token出错';
        }else{
            $data=DB::connection('mysql')->table('leave')->get()->toArray();
           return json_encode($data);
        }
//       dd($request->all());
    }
//    登录页面
    public function log(){

        return view('school.log');
    }
    public function log_do(Request $request){
        $data=$request->all();
//        dd($data);
        $res=DB::connection('mysql')->table('denglu')->where(['name'=>$data['name'],'pwd'=>md5($data['pwd'])])->first();
//        dd($res);
        if($res){
            $request->session()->put('name',$data['name']);
            return redirect('leave/index');
        }else{
            return redirect('leave/log');
        }
    }
    //留言页面
    public function index(Request $request){
//        $request->session()->forget('name');
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $num=$redis->incr('num');

    //搜索
        $name=$request->all()??'';
        $user_name='';

            if(empty($name['name'])){
                if($redis->get('data')){
                   echo 'redis';
                   $data=json_decode($redis->get('data'));
                }else{
                    echo '数据库';
                $data=DB::connection('mysql')->table('leave')->get();
                }
            }else{
                $user_name=$name['name'];
               if($redis->get($name['name'])){
                   echo 1;
                   $data=json_decode($redis->get($name['name']));
               }else{
                   echo 2;
                $data=DB::connection('mysql')->table('leave')->where('user_name','like',"%{$name['name']}%")->get();
             $redis->set($name['name'],json_encode($data));
            }
            }
//    dd($redis->get($name['name']));
        return view('school.index',['data'=>$data,'num'=>$num,'user_name'=>$user_name]);
    }

    public function add_do(Request $request){
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');

        $data=$request->all();
        if(empty($data['test'])){
            echo '留言内容不可为空';die;
        }else{
            $res=DB::connection('mysql')->table('leave')->insert([
                'test'=>$data['test'],
                'user_name'=>session('name'),
                'add_time'=>time(),
            ]);
        }
       if($res){
           $data=DB::connection('mysql')->table('leave')->get();
           $redis->set('data',json_encode($data));
           return redirect('leave/index');
       }else{
           echo '留言失败';die;
        }
    }
    //删除
    public function delete(Request $request){
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $id=$request->all();
        $res=DB::connection('mysql')->table('leave')->where('id',$id['id'])->delete();
//        dd($res);
        if($res){
            $data=DB::connection('mysql')->table('leave')->get();
            $redis->set('data',json_encode($data));
           return redirect('leave/index');
        }else{
            return '删除失败';
        }
    }
}
