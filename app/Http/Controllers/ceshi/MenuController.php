<?php

namespace App\Http\Controllers\ceshi;

use App\Http\Controllers\Tools\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class MenuController extends Controller
{
    public $wechat;
    public function __construct(Wechat $wechat)
    {
        $this->wechat=$wechat;
    }
    public function add_menu(){
        $data=DB::connection('mysqls')->table('menu')->get();
        $info=[];
        foreach($data as $k=>$v){
            if($v->one_name!=''){
                //一级菜单
               $info[]=$v;
               if($v->two_name!=''){
               foreach($data as $val){
                   if($v->id==$val->menu){
                       $info[]=$val;
                   }
               }
               }
            }
        }
        return view('ceshi.weixin.menu.add_menu',['data'=>$data,'info'=>$info]);
    }
    public function add_menu_do(Request $request){
        $arr=$request->all();
        if($arr['one_name']==null && $arr['two_name']==null){
            echo '内容不可为空'; die;
        }
        $where=[
            ['one_name','!=',''],
        ];
        $count=DB::connection('mysqls')->table('menu')->where($where)->count();
        $munu_count=0;
        if(!empty($arr['menu'])){
            $munu_count = DB::connection('mysqls')->table('menu')->where('menu', $arr['menu'])->count();
        }
        if($arr['men']!=2){
            if($count>=3){
                echo '菜单栏已超限';die;
            }
        }
        if($munu_count>=5){
            echo '菜单栏已超限';die;
        }
        //全部类型
        if($arr['men']==0){
            DB::connection('mysqls')->beginTransaction();
        $res=DB::connection('mysqls')->table('menu')->insertGetId([
            'one_name'=>$arr['one_name'],
            'add_time'=>time(),
        ]);
        $res=DB::connection('mysqls')->table('menu')->where('id',$res)->update([
            'two_name'=>$arr['two_name'],
            'menu'=>$res,
            'type'=>'view',
            'url'=>$arr['url'],
        ]);
        }else{
            //一级菜单二级菜单
            $res=DB::connection('mysqls')->table('menu')->insert([
                'one_name'=>$arr['men']==2?'':$arr['one_name'],
                'two_name'=>$arr['men']==1?'':$arr['two_name'],
                'menu'=>$arr['men']==1?'0':$arr['menu'],
                'type'=>$arr['type'],
                'url'=>$arr['url'],
                'add_time'=>time(),
            ]);
        };
        DB::rollBack();
        DB::connection('mysqls')->commit();

        $this->menu();

    }
    //刷新菜单
    public function menu(){
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$this->wechat->access_token()}";
        $info=DB::connection('mysqls')->table('menu')->get()->toArray();
        $data=[];
        foreach ($info as $k => $v) {
            if($v->menu==0 && $v->type=='click'){
                //一级菜单
                 $data["button"][] = [
                            "type" => $v->type,
                            "name" => $v->one_name,
                            "key" => $v->url,
                        ];
            }else{
                $sub_button=[];
//                二级菜单
           $list = DB::connection('mysqls')->table('menu')->where('menu', $v->id)->get()->toArray();
           foreach($list as $val){
               if($val->type=='click'){
               $sub_button[] = [
                   "type" => $val->type,
                   "name" => $val->two_name,
                   "key" => $val->url,
               ];
                }else{
                   $sub_button[] = [
                       "type" => $val->type,
                       "name" => $val->two_name,
                       "url" => $val->url,
                   ];
               }
           }

           if(!empty($sub_button)){
           $data['button'][]=['name'=>$v->one_name,'sub_button'=>$sub_button];
           }
        }
        }
        ;
        dd('请到：   '.'http://www.myshop.com/confession/add_menu'.'    添加菜单');
        $res=$this->wechat->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        dd($res);

    }
    public function menu_list(){
        $url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$this->wechat->access_token()}";
        dd(file_get_contents($url));
    }
    //删除菜单
    public function delete_menu(Request $request){
        $id=$request->all()['id'];
        $data=DB::connection('mysqls')->table('menu')->where(['menu'=>$id])->select('id')->get()->toArray();
        if(!empty($data)){
            foreach($data as $v){
                DB::connection('mysqls')->beginTransaction();
                $res=DB::connection('mysqls')->table('menu')->where('id',$id)->delete();
                $res=DB::connection('mysqls')->table('menu')->where('id',$v->id)->delete();
                DB::rollBack();
                DB::connection('mysqls')->commit();
            }
        }else{
            $res=DB::connection('mysqls')->table('menu')->where('id',$id)->delete();
        }
        dd($res);
            if($res){
                return redirect('menu/add_menu');
            }

    }
//老师接口
    public function reload_menu()
    {

        //-------------------------------------------------------------------------------------------
       /* $menu_info = DB::connection('mysql_cart')->table('menu')->groupBy('menu_name')->select(['menu_name'])->orderBy('menu_name')->get()->toArray();
        foreach($menu_info as $v){
            $menu_list = DB::connection('mysql_cart')->table('menu')->where(['menu_name'=>$v->menu_name])->get()->toArray();
            $sub_button = [];
            foreach($menu_list as $k=>$vo){
                if($vo->menu_type == 1){ //一级菜单
                    if($vo->event_type == 'view'){
                        $data['button'][] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->menu_name,
                            'url'=>$vo->menu_tag
                        ];
                    }else{
                        $data['button'][] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->menu_name,
                            'key'=>$vo->menu_tag
                        ];
                    }
                }
                if($vo->menu_type == 2){ //二级菜单
                    //echo "<pre>";print_r($vo);
                    if($vo->event_type == 'view'){
                        $sub_button[] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->second_menu_name,
                            'url'=>$vo->menu_tag
                        ];
                    }elseif($vo->event_type == 'media_id'){
                    }else{
                        $sub_button[] = [
                            'type'=>$vo->event_type,
                            'name'=>$vo->second_menu_name,
                            'key'=>$vo->menu_tag
                        ];
                    }
                }
            }
            if(!empty($sub_button)){
                $data['button'][] = ['name'=>$v->menu_name,'sub_button'=>$sub_button];
            }
        }
        echo "<pre>";print_r($data);
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->wechat->get_access_token();*/
        //---------------------------------------------------------------------------------------------
        /*$data = [
            'button' => [
                [
                    'type'=>'click',
                    'name'=>'今日歌曲',
                    'key'=>'V1001_TODAY_MUSIC'
                ],
                [
                    'name'=>'菜单',
                    'sub_button' =>[
                        [
                            'type'=>'view',
                            'name'=>'搜索',
                            'url'=>'http://www.soso.com/'
                        ],
                        [
                            "type"=>"click",
                            "name"=>"赞一下我们",
                            "key"=>"V1001_GOOD"
                        ]
                    ]
                ],
                [
                    'type'=>'click',
                    'name'=>'明日歌曲',
                    'key'=>'V1001_TODAY_MUSIC111'
                ]
            ],
        ];*/
       /* $re = $this->wechat->post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        echo json_encode($data,JSON_UNESCAPED_UNICODE).'<br/>';
        echo "<pre>"; print_r(json_decode($re,1));*/
    }
}
