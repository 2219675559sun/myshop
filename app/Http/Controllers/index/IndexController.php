<?php

namespace App\Http\Controllers\index;

use App\Http\Controllers\PayController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Index\Model\User;
use App\Http\Admin\Model\Goods;
use App\Http\Index\Model\Cart;
use App\Http\Index\Model\Order;

use DB;
class IndexController extends Controller
{
    public function log(){
    	
    	return view('index.log',[]);
    }
    public function login_do(Request $request){
    		$data=$request->all();
//    		dump($data);die;
    		$where=[
    			['name','=',$data['name']],
    			['password','=',$data['password']],
    		];
    		$res=User::where($where)->first();
    		if($res){
    			$request->session()->put('name',$data['name']);
                $request->session()->put('id',$res['id']);

                return redirect('index');
    		}else{
    			return redirect('index/log');
    		}

    		// dd($res);
    }
    // 注册视图
    public function logadd(){

    	return view('index.logadd',[]);
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
    		
    		return redirect('index/log');
    	}else{
    		return redirect('index/logadd');
    	}
    }
    public function index(Request $request){
        //新品
        $where=[
            ['is_up','=',1],
            ['is_new','=',1],
        ];
        $new=Goods::where($where)->limit(6)->get();
//        全部商品
        $data=Goods::where('is_up',1)->paginate(6);
        $goodsdata=$data->toArray();

        foreach($data as $k=>$v){

            $car=Cart::where(['goods_id'=>$v['id'],'uid'=>session('id')])->count();
//            dump($car);
        }
//        dump($car);die;
//        dd($new);
        //读取session
        $value = $request->session()->get('name');

//        dd($value);die;
    	return view('index.index',['new'=>$new,'data'=>$data,'value'=>$value,'car'=>$car]);
    }
    //商品详情页
    public function detail(Request $request){
        $id=$request->all();
        $data=Goods::where('id',$id)->first();

        $car=Cart::where(['goods_id'=>$id,'uid'=>session('id')])->count();
//        dd($id);
        return view('index/detail',['data'=>$data,'car'=>$car]);
    }
    //加入购物车
    public function cart(Request $request){
        $value = $request->session()->get('name');
        if(empty($value)){
            return redirect('index/log');die;
        }
        $id=$request->all();
        $car=Cart::where('goods_id',$id)->count();
//        dd($car);
        if($car>=1){
            echo '该商品已加入购物车';die;
        }
        $goods=Goods::where('id',$id)->first();
        $uid=DB::table('user')->where('name',['name'=>$value])->first('id');
        $uid=$uid->id;

//        dd($goods['id']);
        $cart=Cart::insert([
            'uid'=>$uid,
            'goods_id'=>$goods['id'],
            'goods_name'=>$goods['goods_name'],
            'goods_pic'=>$goods['goods_pic'],
            'add_time'=>time(),
            'goods_price'=>$goods['goods_price'],
        ]);
//        dd($cart);
        if($cart){
            return redirect('index/cart_list');
        }else{
            return redirect('index/detail');
        }
    }
//    购物车视图
    public function cart_list(){
        $data=Cart::orderby('add_time','desc')->get();
//        dd($data);
        $table=0;
            foreach($data as $k=>$v){
                $table+=$v['goods_price'];
            }
            $goods_id=[];
            foreach($data as $k=>$v){
                $goods_id[]=$v['goods_id'];
            }
            $goods_id=array_unique($goods_id);
            $goods_id=implode(',',$goods_id);
//              var_dump($goods_id);
        return view('index/cart_list',['data'=>$data,'table'=>$table,'goods_id'=>$goods_id]);
    }
    //购物车删除
    public function cartdelete(Request $request){
        $id=$request->all();
//        dd($id);
        $res=Cart::where('id',$id)->delete();
        if($res){
            return redirect('index/cart_list');
        }else{
            return redirect('index/cart_list');
        }
    }
//    订单视图
    public function order_list()
    {
        $order=Order::where('uid',session('id'))->orderBy('add_time','desc')->limit(6)->get();
//        dd($order);
//        $order['state']=['1'=>'未支付','2'=>'已支付','3'=>'过期','4'=>'已取消'];
        $order=$order->toArray();
        $state_list = [1=>'待支付',2=>'已支付',3=>'已过期',4=>'用户删除'];
        //十分钟取消订单
        foreach($order as $k=>$v){
            $order[$k]['end_time'] =date('Y-m-d H:i:s', $v['add_time'] + 10 * 60);
            $order[$k]['order_state'] = $state_list[$v['state']];
        }
        return view('index/order_list', ['order'=>$order]);
    }

//    退出session
    public function sessionout(Request $request){
        $request->session()->forget('name');
            return redirect('index');
    }
    public function uid(){
        $value = $request->session()->get('name');
        if(empty($value)){
            return redirect('index/log');die;
        }
        $uid=DB::table('user')->where('name',['name'=>$value])->first('id');
        return $uid;
    }
}
