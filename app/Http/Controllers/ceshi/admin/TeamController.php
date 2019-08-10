<?php

namespace App\Http\Controllers\ceshi\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class TeamController extends Controller
{
    //后台竞赛添加
    public function queueadd(){

        return view('ceshi.team.queueadd');
    }
    public function queueadd_do(Request $request){

        $validatedData = $request->validate([
            'one' => 'required',
            'two' => 'required',
            'over_time'=>'required',
        ],['one.required'=>'不可为空','two.required'=>'不可为空','over_time.required'=>'结束时间不可为空']);

        $data=$request->all();
//        dd($data);
        if($data['one']==$data['two']){
            echo '两队不可相同';die;
        }
        $res=DB::connection('mysqls')->table('team_queue')->insert([
            'one'=>$data['one'],
            'two'=>$data['two'],
            'over_time'=>strtotime($data['over_time']),
        ]);
       if($res){
//           echo 11;
           return redirect('team/index');
       }
    }
    //前台展示
    public function index(){
        $data=DB::connection('mysqls')->table('team_queue')->get();

        return view('ceshi.team.index',['data'=>$data]);
    }
    //后台比赛结果
    public function queue(){
        $where=[
            ['over_time','>=',time()],
        ];
//        dd($where);
        $data=DB::connection('mysqls')->table('team_queue')->where($where)->get();
        if(empty($data)){
            echo '当前没有竞赛';
        }
//        dd($data);
        return view('ceshi.team.queue',['data'=>$data]);
    }
//    比赛结果添加
    public function update_resule(Request $request){
        $id=$request->all('id');
//        dd($id);
        $data=DB::connection('mysqls')->table('team_queue')->where('id',$id)->get();
//        dd($data);
        return view('ceshi.team.update_resule',['data'=>$data]);
    }
    //处理比赛结果
    public function update_resule_do(Request $request){
        $data=$request->all();
//dd($data);
        $res=DB::connection('mysqls')->table('team_queue')->where('id',$data['id'])->update([
            'result'=>$data['result'],
        ]);
//        dd($res);
        if($res){
            return redirect('team/index');
        }else{
            echo '出错';
        }
    }
    //前台比赛结果
    public function list(Request $request){
        $id=$request->all();
        $data=DB::connection('mysqls')->table('team_queue')->where('id',$id)->first();
        $join=DB::connection('mysqls')->table('team_join')->where('q_id',$id)->first();
//        dd($join);
        return view('ceshi.team.list',['data'=>$data,'join'=>$join]);
    }
//    前台参加比赛
    public function list_queue(Request $request){
        $id=$request->all();
        $data=DB::connection('mysqls')->table('team_queue')->where('id',$id)->first();
//        dd($data);
        $join=DB::connection('mysqls')->table('team_join')->where('q_id',$id['id'])->first();
//        dd($join);
        return view('ceshi.team.list_queue',['data'=>$data,'join'=>$join]);
    }
//    前台参加竞赛处理
    public function list_queue_do(Request $request){
        $data=$request->all();
//        dd($data);
        if(empty($data['result'])){
            echo '请选择您要竞猜的结果';die;
        }
        $queue=DB::connection('mysqls')->table('team_queue')->where('id',$data['id'])->first();
//        dd($queue->over_time);
        if($queue->over_time<=time()){
            echo '竞猜已结束';die;
        }
        $join=DB::connection('mysqls')->table('team_join')->insert([
            'q_id'=>$data['id'],
            'j_result'=>$data['result'],
            'add_time'=>time(),
        ]);
//        dd($join);
        if($join){
            return redirect('team/index');
        }else{
            echo '请重新填写';
        }
    }
}
