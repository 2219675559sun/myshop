<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Admin\Model\Cgoods;
class GoodsController extends Controller
{
    public function index(Request $request){

        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $num=$redis->incr('num');
//        echo $num;
        $name=$request->all();
//        var_dump($name);
        $na='';
        if(!empty($name['name'])){
            $na=$name['name'];
            $res=Cgoods::where('name','like','%'.$name['name'].'%')->paginate(2);
        }else{
            $res=Cgoods::paginate(2);
        }
//        dd($res);
        return view('admin/goods/index',['res'=>$res,'num'=>$num,'name'=>$na]);
    }
    public function add(){

        return view('admin/goods/add');
    }
    public function add_do(Request $request){
            $data=$request->all();
        $file = $request->file('image');
//        dd($file);
        if(empty($file)){
           echo '请上传文件';
        }else{
            $path=$file->store('cgoods');
//            dd($path);
            $res=Cgoods::insert([
                'name'=>$data['name'],
                'number'=>$data['number'],
                'add_time'=>time(),
                'image'=>$path,
            ]);
        }
        if($res){
            return redirect('goods/index');
        }else{
            return redirect('goods/add');
        }
    }
    public function delete(Request $request){
        $id=$request->all();
//        dd($id);
        $res=Cgoods::where('id',$id)->delete();
        if($res){
            return redirect('goods/index');
        }else{
            return redirect('goods/index');

        }
    }
    public function update(Request $request){
//        echo 111;die;
        $id=$request->all();

        $data=Cgoods::where('id',$id)->first();
//        dd($data);
        return view('admin/goods/update',['data'=>$data]);
    }
    public function update_do(Request $request){
        $file = $request->file('image');
        $id = $request->all('id');
//        dd($file);
        if($file==null){
           $data=$request->all();
            $res=Cgoods::where('id',$id)->update([
                'name'=>$data['name'],
                'number'=>$data['number'],
            ]);
        }else{
            $data=$request->all();
            $path=$file->store('cgoods');
//            dd($path);
            $res=Cgoods::where('id',$id)->update([
                'name'=>$data['name'],
                'number'=>$data['number'],
                'image'=>$path,
            ]);
        }
        if($res==1){
            return redirect('goods/index');
        }else{
            return redirect('goods/index');
        }


//        dd($data);

    }


}
