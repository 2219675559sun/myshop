<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
class Wechat
{
    public $request;
    public $client;

    public function __construct(Request $request,Client $client)
    {
        $this->request=$request;
        $this->client=$client;
    }

//post请求页面
    public function post($url, $data=[] ){
        //初使化init方法
        $ch = curl_init();
        //指定URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //声明使用POST方式来进行发送
        curl_setopt($ch, CURLOPT_POST, 1);
        //发送什么数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //忽略证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //忽略header头信息
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //发送请求
        $output = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        //返回数据
        return $output;
    }
    //素材添加
    public function source($name,$source,$access_token,$title='',$desc=''){
        $img_file=$this->request->file($name);
        $file_ext=$img_file->getClientOriginalExtension(); //获取文件扩展名
        //重命名
        $new_file_ext=time().rand(1000,9999).'.'.$file_ext;
        //保存
        $save_file_path=$img_file->storeAs('weixin/'.$name.'',$new_file_ext);//返回保存成功的文件路径
        $path='./storage/'.$save_file_path;
        if($source==1){
            //临时素材
            $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$name}";
        }elseif($source==2){
            //永久素材
            $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$access_token}&type={$name}";
        }
        $multipart=[
            [
                'name'=>'media',
                'contents'=>fopen(realpath($path),'r')
            ],
        ];
        if($name=='video' && $source==2){
            $multipart[] = [
                'name'     => 'description',
                'contents' => json_encode(['title'=>$title,'introduction'=>$desc]),
            ];
        }
        $response=$this->client->request('POST',$url,[
            'multipart' => $multipart
        ]);
        $body=$response->getBody();
        unlink($path);
        return $body;

    }

    //获取token
    public function access_token(){
        $redis=new \Redis;
        $redis->connect('127.0.0.1','6379');
        $access_token_key="access_token";
        $access_token='';
        if($redis->exists($access_token_key)){
            $access_token=$redis->get($access_token_key);
        }else{
            $data=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."");
            $access=json_decode($data,1);
            $access_token=$access['access_token'];
            $expires_time=$access['expires_in'];
            $redis->set($access_token_key,$access_token,$expires_time);
        }

        return $access_token;
    }

}
