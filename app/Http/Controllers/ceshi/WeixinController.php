<?php

namespace App\Http\Controllers\ceshi;

use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tools\Wechat;
use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class WeixinController extends Controller
{
    public $request;
    public $wechat;
    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request=$request;
        $this->wechat=$wechat;

    }
//登录
    public function log(){
        $redirect_uri='http://www.myshop.com/weixin/code';
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
   header('location:'.$url);
    }
    //获取code
    public function code(Request $request){
        $data=$request->all();
        $code=$data['code'];
        //获取用户的openid
        $http="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code=".$code."&grant_type=authorization_code";
        $re=file_get_contents($http);
        $info=json_decode($re,1);
        $access_token=$info['access_token'];
        $openid=$info['openid'];
       $this->user($openid,$access_token);

    }
    public function user($openid,$access_token){
        $url="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $data=file_get_contents($url);
        $arr=json_decode($data,1);
        $res=DB::connection('mysqls')->table('wechat_user')->where('openid',$openid)->first();
        if(!empty($res)){
            $res=DB::connection('mysqls')->table('weixin_user')->where('id',$res->uid)->first();
            $this->request->session()->put('name',$arr['nickname']);
            $this->request->session()->put('openid',$openid);
            $this->template($openid);
            header('location:moban');
//            return redirect('admin/index');
        }else{
            DB::connection('mysqls')->beginTransaction();
            $user=DB::connection('mysqls')->table('weixin_user')->insertGetId([
                'name'=>$arr['nickname'],
                'pwd'=>'',
                'reg_time'=>0,
            ]);
            $weixin=DB::connection('mysqls')->table('wechat_user')->insert([
                'uid'=>$user,
                'openid'=>$openid,
                'add_time'=>time(),
            ]);
            DB::connection('mysqls')->commit();
            $res=DB::connection('mysqls')->table('weixin_user')->where('id',$res['uid'])->first();
            $this->request->session()->put('name',$arr['nickname']);
            $this->request->session()->put('openid',$openid);
            $this->template($openid);
            header('location:moban');
//            return redirect('admin/index');
        }

    }
    //模板推送
    public function template($openid){
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->access_token()}";

        $data=[
                 "touser"=>$openid,
           "template_id"=>"mWSF0Hwdk31PV4lYxH0rTUva9gKDo-8jM-2VtwizxKA",
           "url"=>"http://vizhiguo.com/index",

           "data"=>[
                 "first"=>[
                     "value"=>"恭喜 ".session('name')."登录成功！",
                       "color"=>"#173177"
                   ],
                   "keyword1"=>[
                     "value"=>"新的一天新的开始",
                       "color"=>"#173177"
                   ],
                   "keyword2"=>[
                     "value"=>date('Y-m-d H:i:s',time()),
                       "color"=>"#173177"
                   ],
                   "keyword3"=>[
                     "value"=>"",
                       "color"=>""
                   ],
                   "remark"=>[
                     "value"=>"欢迎再次使用",
                       "color"=>""
                   ]
           ]

        ];
//        dd($data);
        $this->wechat->post($url,json_encode($data));
    }

    //模板列表
    public function moban(){
        $url="https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token={$this->access_token()}";
        $data=file_get_contents($url);
        $arr=json_decode($data,1);
        $arr=$arr['template_list'];
//        dd($arr);
        return view('ceshi.weixin.moban_index',['data'=>$arr]);
    }

    //我的素材
    public function upload_source(){

        return view('ceshi.weixin.uploadSource');
    }
    //接收上传素材
    public function do_upload(Request $request){

        $source=$this->request['source'];
        $access_token=$this->access_token();
        $body='';
            //图片
            if($request->hasFile('image')){
                $body=$this->wechat->source('image',$source,$access_token);
                //语音
            }elseif($request->hasFile('voice')){
                $body=$this->wechat->source('voice',$source,$access_token);
                //视屏
            }elseif($request->hasFile('video')){
                $body=$this->wechat->source('video',$source,$access_token,'视频标题','视频描述');
                //缩略图
            }elseif($request->hasFile('thumb')){
                $body=$this->wechat->source('thumb',$source,$access_token);
            }
            echo $body;
            dd();
    }
    //获取临时素材
    //图片
    public function get_image_source(){
        $media_id="xU3f2vWWvcLLd0vTyPpZCj3jZn1R5IfgeKykPyzYIc-ccdfn_Xu-NMyTiIwxtyaB";
        $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token={$this->access_token()}&media_id={$media_id}";
        //保存图片
        $client = new Client();
        $response = $client->get($url);
//        $h = $response->getHeaders();
//        dd($h);
        //echo '<pre>';print_r($h);echo '</pre>';die;
        //获取文件名
        $file_info = $response->getHeader('Content-disposition');
        $file_name = substr(rtrim($file_info[0],'"'),-20);
        //$wx_image_path = 'wx/images/'.$file_name;
        //保存图片
        $path = 'weixin/image/'.$file_name;
        $re = Storage::disk('local')->put($path, $response->getBody());
        echo env('APP_URL').'/storage/'.$path;
        dd($re);

    }
    //语音
    public function get_voice_source(){
        $media_id = 'atuC-jKVjehzKUmZA_P338JERZ90fjtWVEHbz4rk8c43_deXWlfBIQa-jeGHVdNJ';
        $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token={$this->access_token()}&media_id={$media_id}";
        //echo $url;echo '</br>';
        //保存图片
        $client = new Client();
        $response = $client->get($url);
        //$h = $response->getHeaders();
        //echo '<pre>';print_r($h);echo '</pre>';die;
        //获取文件名
        $file_info = $response->getHeader('Content-disposition');
        $file_name = substr(rtrim($file_info[0],'"'),-20);
        //$wx_image_path = 'wx/images/'.$file_name;
        //保存图片
        $path = 'weixin/voice/'.$file_name;
        $re = Storage::put($path, $response->getBody());
        echo env('APP_URL').'/storage/'.$path;
        dd($re);
    }
    //视屏
    public function get_video_source(){
        $media_id = 'LkN0usE7pMMUknstPH8WvfVWxX8upFIr5ol6A2by1h2WXsdCoBammjFOzWiJUjgo'; //视频
        $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token={$this->access_token()}&media_id={$media_id}";
        $client = new Client();
        $response = $client->get($url);
        $video_url = json_decode($response->getBody(),1)['video_url'];
        $file_name = explode('/',parse_url($video_url)['path'])[2];
        //设置超时参数
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>5  //单位秒
            ),
        );
        //创建数据流上下文
        $context = stream_context_create($opts);
        //$url请求的地址，例如：
        $read = file_get_contents($video_url,false, $context);
//        dd($read);
        $re = file_put_contents('./storage/weixin/video/'.$file_name,$read);
        dd($re);
        die();
    }
    //获取单条永久素材//报错
    public function one_source_list(){
        $url="https://api.weixin.qq.com/cgi-bin/material/get_material?access_token={$this->access_token()}";
        $data=[
            "media_id"=>"1myZbC5D5IZkTnEtI_R1oDpCYCap4wVYBAi5Lu7mXu8",
        ];
//        $data=json_encode($data);
        $client = new Client();
        $response = $client->get($url,$data);
        $h = $response->getHeaders();
        dd($h);
        //echo '<pre>';print_r($h);echo '</pre>';die;
        //获取文件名
        $file_info = $response->getHeader('Content-disposition');
//        dd($file_info);
        $file_name = substr(rtrim($file_info[0],'"'),-20);
        //$wx_image_path = 'wx/images/'.$file_name;
        //保存图片
        $path = 'weixin/image/'.$file_name;
        $re = Storage::disk('local')->put($path, $response->getBody());
        echo env('APP_URL').'/storage/'.$path;
        dd($re);

    }//报错
    //获取永久素材列表
    public function source_list(){
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token={$this->access_token()}";
        $data = ['type'=>'image','offset'=>0,'count'=>20];
        $res = $this->wechat->post($url,json_encode($data));
        $arr=json_decode($res,1);
        if(!empty($arr['errcode'])){
            echo "接口调用频繁，请稍后调用";die;
        }
        $count=$this->source_count();
        return view('ceshi.weixin.source_list',['arr'=>$arr['item'],'count'=>$count]);
    }
    //清除接口调用次数
    public function out()
    {
        $url ="https://api.weixin.qq.com/cgi-bin/clear_quota?access_token={$this->access_token()}";
        $data = [
            'appid' => env('WECHAT_APPID'),
        ];
        $datas = $this->wechat->post($url,json_encode($data));
        dd(json_decode($datas));

    }
    //获取素材总数
    public function source_count(){
        $url="https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token={$this->access_token()}";
        $res=file_get_contents($url);
        $data=json_decode($res,1);
        return $data;
    }
    //删除永久素材
    public function source_delete(Request $request){
        $media_id=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/material/del_material?access_token={$this->access_token()}";
        $data=[
                "media_id"=>$media_id['media_id'],
        ];
        $res=$this->wechat->post($url,json_encode($data));
        return redirect('weixin/source_list');
    }
//创建标签
    public function add_tag(){
        return view('ceshi.weixin.add_tag');
    }
    public function add_tag_do(Request $request){
        $tag=$request->all('tag');
        $url="https://api.weixin.qq.com/cgi-bin/tags/create?access_token={$this->access_token()}";
        $data=[
           'tag'=>['name'=>$tag['tag']],
        ];
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
       $res=$this->wechat->post($url,$data);
        if($res){
            return redirect('weixin/tag_index');
        }else{
            return redirect('weixin/add_tag');
        }
    }
    //获取标签
    public function tag_index(){
        $url="https://api.weixin.qq.com/cgi-bin/tags/get?access_token={$this->access_token()}";
        $tag=file_get_contents($url);
        $data=json_decode($tag,1)['tags'];
        return view('ceshi.weixin.tagIndex',['data'=>$data]);
    }
    //修改标签
    public function tagUpdate(Request $request){
        $id=$request->all();
        return view('ceshi.weixin.tagUpdate',['id'=>$id['id']]);
    }
    public function tagUpdate_do(Request $request){
        $data=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/tags/update?access_token={$this->access_token()}";
        $data=[
            'tag'=>['id'=>$data['id'],'name'=>$data['tag']],
        ];
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
        $res=$this->wechat->post($url,$data);
        return redirect('weixin/tag_index');
    }
    //删除标签
    public function tagDelete(Request $request){
        $id=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/tags/delete?access_token={$this->access_token()}";
        $data=[
            'tag'=>['id'=>$id['id']],
        ];
        $data=json_encode($data);
        $res=$this->wechat->post($url,$data);
        return redirect('weixin/tag_index');
    }
    //标签下的粉丝列表
    public function tagList(Request $request){
        $id=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token={$this->access_token()}";
        $data=[
            'tagid'=>$id['id'],
            "next_openid"=>'',
        ];
        $data=json_encode($data);
       $res=$this->wechat->post($url,$data);
       $arr=json_decode($res,1);
        if($arr['count']==0){
            echo '该标签下没有用户';die;
        }
       $openid=$arr['data']['openid'];
       $list=[];
        foreach($openid as $k=>$v){
            $url_list=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$this->access_token()}&openid={$v}&lang=zh_CN");
            $list[]=json_decode($url_list,1);
        }
        return view('ceshi.weixin.tagList',['list'=>$list,'id'=>$id['id']]);
    }
    //查看用户标签
    public function get_tag(Request $request){
        //接收 openid
        $arr=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token={$this->access_token()}";
        $data=[
            'openid'=>$arr['openid'],
        ];
        $data=json_encode($data);
        //获取该用户的标签id
        $res=$this->wechat->post($url,$data);
        $res=json_decode($res,1);
        // 获取标签下粉丝列表
        $tag_url="https://api.weixin.qq.com/cgi-bin/tags/get?access_token={$this->access_token()}";
        $tag_res=json_decode(file_get_contents($tag_url),1);
        foreach($res['tagid_list'] as $k=>$v){
          foreach($tag_res['tags'] as $key=>$val){
              if($v==$val['id']){
                 echo $val['name'].'&nbsp&nbsp&nbsp';
              }
          }
        }
    }
    //根据标签推送消息
    public function tag_push(Request $request){
        $tagid=$request->all();
        return view('ceshi.weixin.tag_push',['tagid'=>$tagid['id']]);
    }
    public function tag_push_do(Request $request){
            $arr=$request->all();
            if($arr['text']==null){
                echo "请输入内容";die;
            }
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token={$this->access_token()}";
            $data=[
                    "filter"=>[
                "is_to_all"=>false,
                  "tag_id"=>$arr['tagid'],
               ],
               "text"=>[
                        "content"=>$arr['text']
               ],
                "msgtype"=>"text"
            ];
            $data=json_encode($data,JSON_UNESCAPED_UNICODE);
            $res=$this->wechat->post($url,$data);
            dd($res);
}
    //取消该标签下的粉丝
    public function out_fans_tag(Request $request){
        $arr=$request->all();
        if(empty($arr['openid'])){
            echo "请选择需要取消的用户 "; die;
        }
        $url="https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token={$this->access_token()}";
        $data=[
            "openid_list"=>$arr['openid'],
            'tagid'=>$arr['id']
        ];
        $data=json_encode($data);
        $res=$this->wechat->post($url,$data);
        if($res){
            return redirect('weixin/tag_index');
        }else{
            echo "操作失败，请重新取消";
        }
    }
//添加粉丝到该标签
    public function addFansTag(Request $request){
        $id=$request->all();
       $url="https://api.weixin.qq.com/cgi-bin/user/get?access_token={$this->access_token()}&next_openid=";
       $data=json_decode(file_get_contents($url),1);
       $data=$data['data']['openid'];
       $list=[];
        foreach($data as $k=>$v){
            $url_list=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$this->access_token()}&openid={$v}&lang=zh_CN");
            $list[]=json_decode($url_list,1);
        }
       return view('ceshi.weixin.addFansTag',['list'=>$list,'id'=>$id['id']]);
    }
    public function addFansTag_do(Request $request){
            $data=$request->all();
            if(empty($data['openid'])){
                echo '请选择需要添加的粉丝';die;
            }
            $url="https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token={$this->access_token()}";
            $data=[
                "openid_list"=>
                    $data['openid'],
                'tagid'=>$data['id'],
            ];
            $data=json_encode($data);
            $res=$this->wechat->post($url,$data);
            if($res){
                return redirect('weixin/tag_index');
            }else{
                echo '添加失败，请重新添加';
            }
    }
//    粉丝列表
    public function index(){
        $data=DB::connection('mysqls')->table('wechat_openid')->get();
//        dd($data);

        return view('ceshi.weixin.index',['data'=>$data]);
    }
//    粉丝详细信息
    public function index_list(Request $request){
        $id=$request->all();
        $data=DB::connection('mysqls')->table('wechat_openid')->where('id',$id)->first();
        return view('ceshi.weixin.index_list',['data'=>$data]);
    }
    public function user_info(){
    $access_token=$this->access_token();
    $openid="oC0jbweAEtwLl5CBZrluOa3VKFrg";
    $user_info=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
    $user=json_decode($user_info,1);
    dd($user);
    }
    //粉丝信息添加到数据库中
    public function user_list(){
        $access_token=$this->access_token();
    $user_list=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}&next_openid=");
    $list=json_decode($user_list,1);
    $data=$list['data'];
    $openid=$data['openid'];
        foreach($openid as $k=>$v){
            $user_info=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$v}&lang=zh_CN");
            $user=json_decode($user_info,1);
            $data=DB::connection('mysqls')->table('wechat_openid')->where('openid',$user['openid'])->first();
            if(empty($data)){
                DB::connection('mysqls')->table('wechat_openid')->insert([
                    'openid'=>$user['openid'],
                    'nickname'=>$user['nickname'],
                    'subscribe'=>$user['subscribe'],
                    'sex'=>$user['sex'],
                    'country'=>$user['country'],
                    'province'=>$user['province'],
                    'city'=>$user['city'],
                    'headimgurl'=>$user['headimgurl'],
                    'subscribe_time'=>$user['subscribe_time'],
                ]);
            }

        }
           return redirect('weixin/index');


    }
//个人信息
    public function one_list(){
        $res=DB::connection('mysqls')->table('weixin_user')
//            ->join('wechat_user', 'wechat_user.uid', '=', 'weixin_user.id')
//            ->select('weixin_user.*', 'wechat_user.openid', 'wechat_user.add_time','wechat_user.uid')
            ->get();
        $arr=json_decode($res,1);
        return view('ceshi.weixin.one_list',['arr'=>$arr]);
    }
    //获取永久二维码
    public function qrCode(Request $request){
        $id=$request->all();
//        查询数据库
        $weixin_user= DB::connection('mysqls')->table('weixin_user')->where('id',$id['id'])->first();

        if($weixin_user->qrcode_url == '0'){

        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$this->access_token()}";
        $data=[
            "action_name"=> "QR_LIMIT_SCENE",
                            "action_info"=> ["scene"=> ["scene_id"=> $id['id']]],
        ];
        $res=$this->wechat->post($url,json_encode($data));
       $arr=json_decode($res,1);
       $code="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$arr['ticket']."";
       if($code){
           $user= DB::connection('mysqls')->table('weixin_user')->where('id',$id['id'])->update([
               'qrcode_url'=>$code,
               'agent_code'=>$id['id'],
               'reg_time'=>time(),
           ]);
       }
        }else{
            $code=$weixin_user->qrcode_url;
        }
       header('location:'.$code);
    }
    //二维码下载
    public function download(Request $request){
        $id=$request->all()['id'];
        $res=DB::connection('mysqls')->table('weixin_user')->where('id',$id)->first();
        if($res->qrcode_url == '0'){
            echo '请先生成二维码'; die;
        }else{
            $client=new Client();
            $url=$client->get($res->qrcode_url);
            $h = $url->getHeaders();
            $ext = explode('/',$h['Content-Type'][0])[1];
            $file_name = time().rand(1000,9999).'.'.$ext;
            //存入数据库
            if($res->agent_code == '0'){
                //保存图片
                $path = 'weixin/qrcode/'.$file_name;
                $re = Storage::disk('local')->put($path, $url->getBody());
                $agent_code = env('APP_URL').'/storage/'.$path;

                $res=DB::connection('mysqls')->table('weixin_user')->where('id',$id)->update([
                    'agent_code'=>$agent_code,
                ]);
            }
            return redirect('weixin/one_list');
        }

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
