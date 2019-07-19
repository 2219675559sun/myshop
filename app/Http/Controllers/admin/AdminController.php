<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin\Goods;
use App\Http\Model\Index\User;
use DB;
class AdminController extends Controller
{
    //登录页面
    public function login(){

        return view('admin/login');
    }
    public function login_do(Request $request){
        $data=$request->all();
//        dd($data);
        $where=[
            ['name','=',$data['name']],
            ['password','=',$data['password']],
            ['user','=',0,'|',2],

        ];
        $res=DB::table('user')->where($where)->first();
//        dd($res);die;
        if($res){
            $request->session()->put('name', $data['name']);
            return redirect('admin/index');
        }else{
            return redirect('admin/login');
        }

    }



    //商品展示列表
    public function index(Request $request){
        //访问次数
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $num=$redis->incr('num');
    //搜索
        $name=$request->all();
        $goods_name='';
        if(!empty($name['goods_name'])){
            $goods_name=$name['goods_name'];
            $data=Goods::where('goods_name','like','%'.$name['goods_name'].'%')->paginate(3);
        }else{
            $data=Goods::paginate(3);
        }
//      dd($data);
        return view('admin.index',['data'=>$data,'num'=>$num,'name'=>$goods_name]);
    }
//    添加
    public function add(){
        return view('admin.add',[]);
    }
    public function add_do(Request $request){
        $file = $request->file('goods_pic');
//        var_dump($file);
//        dd($file);die;

        if(empty($file)){
         return  '没有文件上传' ;die;
        }else{
            $path=$file->store('goods');
//            dd($path);
            $data=$request->all();
            $res=Goods::insert([
                'goods_name'=>$data['goods_name'],
                'goods_pic'=>$path,
                'goods_price'=>$data['goods_price'],
                'is_up'=>$data['is_up'],
                'add_time'=>time(),
                'goods_centent'=>$data['goods_centent'],
                'is_new'=>$data['is_new'],
            ]);
        }
        if($res){
          return  redirect('admin/index');
        }else{
           return redirect('admin/add');
        }
    }
    public function delete(Request $request){
        $id=$request->all();
//        dd($id);
        $res=Goods::where('id',$id)->delete();
//        dd($res);
        if($res){
            return redirect('admin/index');
        }else{
            return redirect('admin/index');
        }
    }
    public function update(Request $request){
        $id=$request->all();
        $data=Goods::where('id',$id)->first();
//        dd($data);

        return view('admin/update',['data'=>$data]);
    }
    public function update_do(Request $request){
        $file = $request->file('goods_pic');
        $id= $data=$request->all('id');
//            dd($file);
        if(empty($file)){
            $data=$request->all();
            $res=Goods::where('id',$id)->update([
                'goods_name'=>$data['goods_name'],
                'is_up'=>$data['is_up'],
                'is_new'=>$data['is_new'],
                'goods_price'=>$data['goods_price'],
                'goods_centent'=>$data['goods_centent'],
                ]);
        }else{
            $path=$file->store('goods');
            $data=$request->all();
            $res=Goods::where('id',$id)->update([
                'goods_name'=>$data['goods_name'],
                'is_up'=>$data['is_up'],
                'is_new'=>$data['is_new'],
                'goods_price'=>$data['goods_price'],
                'goods_centent'=>$data['goods_centent'],
                'goods_pic'=>$path,
            ]);
        }
//        dd($res);die;
    if($res==0){
        return redirect('admin/index');
        echo '修改失败';
    }else{
        return redirect('admin/index');
    }

    }
//    管理员添加
    public function userAdd(){

    }
//    管理员列表
    public function userList(Request $request){
        $name=$request->all();
        $user='';
        if(empty($name['user'])){
            $data=User::paginate(3);
        }else{
            $user=$name['user'];
            $data=User::where('name','like','%'.$name['user'].'%')->paginate(3);
        }
        $value = $request->session()->get('name');
        $userid=User::where('name',['name'=>$value])->first();
        return view('admin/userList',['data'=>$data,'user'=>$user,'userid'=>$userid]);
    }
    //管理员删除
    public function user_delete(Request $request){
        $id=$request->all();
//        dd($id);
        $res=User::where('id',$id)->delete();
//        dd($res);
        if($res){
            return redirect('admin/userList');
        }else{
            return redirect('admin/userList');
        }
    }
//    管理员修改视图
    public function user_update(Request $request){
        $value = $request->session()->get('name');
        $user=User::where('name',['name'=>$value])->first();
//        dd($user);
        $id=$request->all();
        $data=User::where('id',$id)->first();
//        dd($data);
     return view('admin/userUpdate',['data'=>$data,'user'=>$user]);
    }
    public function userUpdate_do(Request $request){
        $id=$request->all('id');
        $data=$request->all();
//        dd($data);
        $res=User::where('id',$id)->update([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'user'=>$data['user'],
            'is_user'=>$data['user'],
        ]);
//        dd($res);
        if($res){
            return redirect('admin/userList');
        }else{
            return redirect('admin/userList');
        }
    }

//    退出sessionout
public function sessionout(Request $request){
    $request->session()->forget('name');
    return redirect('admin/login');
}
}
