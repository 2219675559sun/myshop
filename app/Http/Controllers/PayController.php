<?php

namespace App\Http\Controllers;
use App\Http\Model\Index\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Model\Index\Cart;
use App\Http\Model\Index\Order;
use DB;
use Pay;
class PayController extends Controller
{
    public $app_id;
    public $gate_way;
    public $notify_url;
    public $return_url;
    public $rsaPrivateKeyFilePath = '';  //路径
    public $aliPubKey = '';  //路径
    public $privateKey ='MIIEpQIBAAKCAQEA3kg1k8WtIE2wAzI4yB4xc3tVFN3NIcTOfxa3Kz5mDrASP+dJ8NAt50gbVppDIL8cTic1NY9W+IFK7e+4Yd7yZlzTr87XA7cVu61HAUQGGVgxer6P+NG19gk9UKrgCd4zZvzi4o4dKnWJhz7CiMlAv6Z5kiJzGtpSIoYDI+u+Eec1q3GtyxGa5TZ0matO4+3MjVOoSoRHu5jgAGEhk2H4nPSPTGoNpQw9Vl7EvB9jcpUKNsmUv8EJKOZkGIuNnaazWkiowHccdR01J2hbVHn2ytw8UFE4L6FMDxZ3upoZwZ4Y8jlPSk9m3wQvH5LRIswl9g1YcUZC0STU6uxj+DbZawIDAQABAoIBAQDArCi8wUES2iQycQrk8777kbErGCMiHTy8zozREBJYsufuumXONjVD363KwIZlUSKQ381wcqH5X+D6I6tYMm88qUPYhVq83qsY9daxUyxSNa8V7S5QiD7IWDPsw2DVTOSTZaqopHTFhAJE1/K5rHDSbtO8Bt5tLUa6pBz+uu4TBxBjDLLjHzNGzX2ZXgrrv0kz4CEqNAXXqdpQLoaLjpLL/1W0GrMRrcaWOwmG4LujfDGBVkLiK2rHjlwlqucPAoTryqpBuQDg4wXLTPbAmwDEzouwoa8AIw9SJoY2tsSnt/CqifgK8UyrW3uoHCb1S8h2S+SSXHBlTOI2b+mAS8hBAoGBAO9CdZyrlqiNi2u05wM++uAdiOiBkYN90qGwsmn5dZytH/mpP/o+eRU9xMh/qbpaYXr59wQloSmzNEVsfYOuPnozBOof1GVwkDy5RmDrP8pEsmLRzXYUqw4IyVLu/DbQeruSAhD7iiJsMVA7qHZW8S9XwfEVBKU4aMWm6I1kApVhAoGBAO3Vp1c44OCIZdX4kL1vH1y9+4gdZP8ttct6D+2Hr1uUCF2LCzgWFvTnAmI35dswCp495o8j12UxwoZW1RrnClzKDefJuX4ULNNy0hB8WpeG5q/qoxtkpa2BUMv+dYG3gIMY9NQjyBqMe6N3D+cEpIojSKxk5ARYf3VmNavUVtZLAoGALQVodC6ljtnznjTQM4AqXPmxxW58Hy4R8HL7X42dX/oDxkreywvuZNzWppO/MF3JcgaPQKyEAwDBmT6s75ZeE0h+aD/NC7l+qq6CW8JoonsCxi2MZ+fDuERW/dASjY31Sk5TLTbn60pIjTxsmrgJckslJ2Q5F43hyS97Gv/yrIECgYEA02pV+8na1J1K8R6pA0vRdC6JdqCyk8d9T+gsWnh/4AdCPG0KRwwT0hW737VSxTn6ZloeJmW05gaKpcJwYx637m3KWJ3QHwwuILRzmSYBnarUS9JmtUYNpKNMQFns+Kc3PNIlaKJ6EWeJzHBdGX3eCdF9m4l/y4EjpCd8VEdH/esCgYEA1sjAN0R1R+0MSExHmXne4hfHlTfviq0iKosH3Y6nZWt9Zx7/kM7noo4sMt8tbbbSJQ9j5NUnhnphebVQSHZbLDOtKKpIGJj25tkfTLClVLA9UeIc5QuaFZRy6SF5TGoJKyo18a1Zd3MFVPXmBfWwR4QYYu8BBCMRBRk0Lo5cf98=';
    public $publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3kg1k8WtIE2wAzI4yB4xc3tVFN3NIcTOfxa3Kz5mDrASP+dJ8NAt50gbVppDIL8cTic1NY9W+IFK7e+4Yd7yZlzTr87XA7cVu61HAUQGGVgxer6P+NG19gk9UKrgCd4zZvzi4o4dKnWJhz7CiMlAv6Z5kiJzGtpSIoYDI+u+Eec1q3GtyxGa5TZ0matO4+3MjVOoSoRHu5jgAGEhk2H4nPSPTGoNpQw9Vl7EvB9jcpUKNsmUv8EJKOZkGIuNnaazWkiowHccdR01J2hbVHn2ytw8UFE4L6FMDxZ3upoZwZ4Y8jlPSk9m3wQvH5LRIswl9g1YcUZC0STU6uxj+DbZawIDAQAB';
    public function __construct(Cart $cart,Order $order,OrderDetail $orderDetail)
    {
        $this->cart=$cart;
        $this->order=$order;
        $this->orderDetail=$orderDetail;
        $this->app_id = '2016101100657597';
        $this->gate_way = 'https://openapi.alipaydev.com/gateway.do';
        $this->notify_url = env('APP_URL').'/notify_url';
        $this->return_url = env('APP_URL').'/return_url';
    }
//    订单详情
    public function confirm_pay(){
            if(empty(session('name'))){
                echo '请先登录';die;
            }
        $cart = $this->cart->where(['uid'=>session('id')])->get();
//        dd($cart);
        $total = 0;
        foreach($cart->toArray() as $v){
            $total += $v['goods_price'];
        }
//        dd($total);
        return view('index.order',['cart'=>$cart,'total'=>$total]);
    }


    public function pay_order(Request $request){
        $oid=$request->all();
        if(empty($oid)){
            echo '订单有误';die;
        }
        $this->ali_pay($oid['oid']);
    }
    public function do_pay(){
        DB::connection('mysqls')->beginTransaction(); //开启事务
        $cart = $this->cart->where(['uid'=>session('id')])->get();

        if(empty($cart)){
            echo '购物车没有此商品';
        }
        $total = 0;
        foreach($cart->toArray() as $v){
            $total += $v['goods_price'];
        }
        $oid = time().mt_rand(1000,1111);  //订单编号
        $order=$this->order->insert([
            'oid'=>$oid,
            'uid'=>session('id'),
            'pay_money'=>$total,
            'add_time'=>time(),
        ]);
        $orderdetail='';
        foreach($cart as $k=>$v){
            $orderdetail=$this->orderDetail->insert([
                'oid'=>$oid,
                'goods_id'=>$v['goods_id'],
                'goods_name'=>$v['goods_name'],
                'goods_pic'=>$v['goods_pic'],
                'add_time'=>time(),
            ]);
        }
        $delete=$this->cart->where('uid',session('id'))->delete();
        if(!$order || !$orderdetail ||!$delete){
            DB::connection('mysqls')->rollBack();
            die('操作失败!');
        }

        DB::connection('mysqls')->commit();

        $this->ali_pay($oid);
    }
    
    public function rsaSign($params) {
        return $this->sign($this->getSignContent($params));
    }
    protected function sign($data) {
    	if($this->checkEmpty($this->rsaPrivateKeyFilePath)){
    		$priKey=$this->privateKey;
			$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
				wordwrap($priKey, 64, "\n", true) .
				"\n-----END RSA PRIVATE KEY-----";
    	}else{
    		$priKey = file_get_contents($this->rsaPrivateKeyFilePath);
            $res = openssl_get_privatekey($priKey);
    	}
        
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }
    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }

    

    /**
     * 根据订单号支付
     * [ali_pay description]
     * @param  [type] $oid [description]
     * @return [type]      [description]
     */
    public function ali_pay($oid){
        $order = $this->order->where(['oid'=>$oid,'state'=>1])->first();
        if(empty($order)){
            echo '订单不存在';die;
        }
        $order_info = $order->toArray();
//        dd($order_info['pay_money']);
//        业务参数
        $bizcont = [
            'subject'           => 'Lening-OrderDetail: ' .$oid,
            'out_trade_no'      => $oid,
            'total_amount'      => $order_info['pay_money'],
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
        ];
        //公共参数
        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.page.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,        //异步通知地址
            'return_url'   => $this->return_url,        // 同步通知地址
            'biz_content'   => json_encode($bizcont),
        ];
        //签名
        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;
//        dd($url);
        header("Location:".$url);
    }
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }
    /**
     * 支付宝同步通知回调
     */
    public function aliReturn()
    {
//        dd('222');
        header('Refresh:2;url=index/order_list');
        echo "<h2>订单： ".$_GET['out_trade_no'] . ' 支付成功，正在跳转</h2>';
    }
    /**
     * 支付宝异步通知
     */
    public function aliNotify()
    {

        $data = json_encode($_POST);
        $log_str = '>>>> '.date('Y-m-d H:i:s') . $data . "<<<<\n\n";
        //记录日志
        file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        //验签
        $res = $this->verify($_POST);
        $log_str = '>>>> ' . date('Y-m-d H:i:s');
        if($res){
            //记录日志 验签失败
            $log_str .= " Sign Failed!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        }else{
            $log_str .= " Sign OK!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
            //验证订单交易状态
            if($_POST['trade_status']=='TRADE_SUCCESS'){
                $oid=$_POST['out_trade_no'];
                $info=[
                    'pay_time'=>[strtotime($_POST('timestamp'))],//支付时间
                    'state'=>2,
                ];
                $order=$this->order->where('oid',$oid)->update($info);//修改支付状态

            }
        }
        
        echo 'success';
    }
    //验签
    function verify($params) {
        $sign = $params['sign'];
        if($this->checkEmpty($this->aliPubKey)){
            $pubKey= $this->publicKey;
            $res = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($pubKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        }else {
            //读取公钥文件
            $pubKey = file_get_contents($this->aliPubKey);
            //转换为openssl格式密钥
            $res = openssl_get_publickey($pubKey);
        }
        
        
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($this->getSignContent($params), base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        
        if(!$this->checkEmpty($this->aliPubKey)){
            openssl_free_key($res);
        }
        return $result;
    }
}
