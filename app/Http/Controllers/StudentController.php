<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Model\Denglu;
class StudentController extends Controller
{
//登录页面
	public function log(){

		return view('log',[]);
	}
//执行登录表
	public function login(Request $request){
	
		$data=$request->all();
		// dd($data);die;
		$where=[
			['name','=',$data['user']],
			['pwd','=',$data['pwd']],
		];

		// dd($where);die;
		$res=Denglu::where($where)->first();
// dd($res);
			if($res){
				
		$request->session()->put('name', $data['user']);
		return redirect('student/index');
			}else{
		return redirect('student/log');
		// $request->session()->forget('name');
				
			}
		
	}

   public function index(Request $request){
   	// $request->session()->forget('name');
   	$redis=new \Redis;
   	$redis->connect('127.0.0.1','6379');
   $num = $redis->incr('num');
   	// echo '当前共访问'.$num.'次';
   	//搜索条件
   	$name=$request->all();
   // var_dump($name);
   	$search='';
   	if(!empty($name['name'])){
   		$search=$name['name'];
   		$data=DB::table('user')->where('name','like','%'.$name['name'].'%')->paginate(2);
   	}else{
   		$data=DB::table('user')->paginate(2);
   	}
   

   	// dd($data);
   	return view('index',['data' => $data,'name'=>$search,'num'=>$num]);
   }
   /**
    *删除
    * @return [type] [description]
    */
   public function delete(){
   $id=$_GET['id'];
   // dd($id);
   	$delete=DB::table('user')->delete($id);
   	// dd($delete);
   	if($delete){
   		return redirect('/student/index');
  // return success('删除成功','index');
   	}else{
   		echo 'fail';
   	}

   }
   /**
    * 添加视图
    */
   public function add(){

   	return view('add',[]);

   }
   /**
    * 执行添加
    */
   public function do_add(Request $request){
   
	$validatedData = $request->validate([
        'name' => 'required',
        'age' => 'required',
    ],['name.required'=>'姓名不可为空','age.required'=>'年龄不可为空']);
   		$data=$request->all();
   //图片上传
    // dd(storage_path('app\public'));
    $path = $request->file('image')->store('student');
      // dd($path);
    $image = asset('storage').'/'.$path;

   		// dd($data);
   		$res=DB::table('user')->insert([
   			'name'=>$data['name'],
   			'age'=>$data['age'],
   			'sex'=>$data['sex'],
        'image'=>$image,
   			]);
   		// dd($res);
   		if($res){
   			return redirect('student/index');
   		}else{
   			echo 'error';
   		}
   }
   /**
    * 修改视图
    */
   public function update(Request $request){
   		$id=$request->all();
   		// dd($data);
   		$res=DB::table('user')->where('id',$id)->first();
   		// dd($res);
   	return view('update',['res'=>$res]);
   }
   public function do_update(Request $request){
   		$validatedData = $request->validate([
        'name' => 'required',
        'age' => 'required',
    ],['name.required'=>'姓名不可为空','age.required'=>'年龄不可为空']);

   		$data=$request->all();
   		// dd($data);die;
   		$res=DB::table('user')->where('id',$data['id'])->update([
   			'name'=>$data['name'],
   			'age'=>$data['age'],
   			'sex'=>$data['sex'],
   			]);
   		// dd($res);
   		if($res){
   			return redirect('/student/index');
   		}else{
   			echo 'error';
   		}
   }
}
