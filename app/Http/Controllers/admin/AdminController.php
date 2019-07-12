<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Admin\Model\User;

class AdminController extends Controller
{
    public function log(){
    	
    	return view('admin.log',[]);
    }
    public function login_do(Request $request){
    		$data=$request->all();
    		$where=[
    			['name','=',$data['name']],
    			['password','=',$data['password']],
    		];
    		$res=User::where($where)->first();
    		if($res){
    			$request->session()->put('name',$data['name']);
    			return redirect('admin/index');
    		}else{
    			return redirect('admin/log');
    		}

    		// dd($res);
    }
    // 注册视图
    public function logadd(){

    	return view('admin.logadd',[]);
    }
    public function logadd_do(Request $request){
    	 $validatedData = $request->validate([
        'name' => 'required|unique:user|max:15',
        'email' => 'required',
        'password' => 'required',
    ],['name.required'=>'用户名不可为空',
    	'name.max'=>'用户名长度不可超过15位',
    	'name.unique'=>'用户名已存在',
    	'email.required'=>'邮箱不可为空',
    	'email.required'=>'密码不可为空',
    ]);

    	$data=$request->all();
    	$pwd=$request->all('password');
    	// var_dump($pwd);die;
    	$res=User::insert(['name'=>$data['name'],'email'=>$data['email'],'password'=>$pwd['password']]);
    
    	if($res){
    		
    		return redirect('admin/log');
    	}else{
    		return redirect('admin/logadd');
    	}
    }
    public function index(){

    	return view('admin.index',[]);
    }
}
