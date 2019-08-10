<?php

namespace App\Http\Controllers\ceshi\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class ProbeController extends Controller
{
    //登录
    public function log(){

        return view('ceshi.test.log');
    }
    public function log_do(Request $request){
        $data=$request->all();

        $res=DB::connection('mysqls')->table('denglu')->where(['name'=>$data['name'],'pwd'=>md5($data['pwd'])])->first();
//        dd($res);
        if($res){
            return redirect('probe/index');
        }else{
            return redirect('probe/log');
        }
    }
    public function index(){
        $data=DB::connection('mysqls')->table('probe_theme')->get();
//        dd($data);

        return view('ceshi.probe.index',['data'=>$data]);
    }
    public function theme_add(){

        return view('ceshi.probe.theme_add');
    }
    public function theme_add_do(Request $request){
            $data=$request->all();
           $res=DB::connection('mysqls')->table('probe_theme')->insertGetId([
               'theme'=>$data['theme'],
               'add_time'=>time(),
           ]);
           if($res){
               $request->session()->put('t_id',$res);
               return redirect('probe/question_add');
           }else{
               return redirect('probe/theme_add');
           }
    }
    public function question_add(){

        return view('ceshi.probe.question_add');
    }
    public function question_add_do(Request $request){
        $id=session('t_id');
        $data=$request->all();
//        dd(in_array(1,$data['correct'])?3:0);
//        dd($data);
        if($data['type']==1) {
            DB::connection('mysqls')->beginTransaction();
//            问题
            $res1 = DB::connection('mysqls')->table('probe_question')->insertGetId([
                't_id' => $id,
                'question' => $data['question'],
                'add_time' => time(),
            ]);
//        答案
            $res2 = DB::connection('mysqls')->table('probe_answer')->insert([
                'q_id' => $res1,
                'desc' => $data['descB'],
                'is_correct' => ($data['correct'] == 2) ? 1 : 2,
                'add_time' => time(),
            ]);
//        dd($res2);
            $res3 = DB::connection('mysqls')->table('probe_answer')->insert([
                'q_id' => $res1,
                'desc' => $data['descC'],
                'is_correct' => ($data['correct'] == 3) ? 1 : 2,
                'add_time' => time(),
            ]);
            $res4 = DB::connection('mysqls')->table('probe_answer')->insert([
                'q_id' => $res1,
                'desc' => $data['descD'],
                'is_correct' => ($data['correct'] == 4) ? 1 : 2,
                'add_time' => time(),
            ]);
            $res5 = DB::connection('mysqls')->table('probe_answer')->insert([
                'q_id' => $res1,
                'desc' => $data['descA'],
                'is_correct' => ($data['correct'] == 1) ? 1 : 2,
                'add_time' => time(),
            ]);
            $res = $res1 && $res2 && $res3 && $res4 && $res5;
            if ($res) {
                DB::commit();
                return redirect('probe/question_add');
            } else {
                DB::rollBack();
                return redirect('probe/question_add');
            }
        }elseif($data['type']==2){//多选
            DB::connection('mysqls')->beginTransaction();
//            问题
            $res1 = DB::connection('mysqls')->table('probe_question')->insertGetId([
                't_id' => $id,
                'question' => $data['question'],
                'add_time' => time(),
            ]);
//        答案
            $res2 = DB::connection('mysqls')->table('probe_answer')->insert([
                'q_id' => $res1,
                'desc' => $data['ddescB'],
                'is_correct' =>in_array(1,$data['correct'])? 1 : 2,
                'add_time' => time(),
            ]);
//        dd($res2);
            $res3 = DB::connection('mysqls')->table('probe_answer')->insert([
                'q_id' => $res1,
                'desc' => $data['ddescC'],
                'is_correct' =>in_array(2,$data['correct']) ? 1 : 2,
                'add_time' => time(),
            ]);
            $res4 = DB::connection('mysqls')->table('probe_answer')->insert([
                'q_id' => $res1,
                'desc' => $data['ddescD'],
                'is_correct' =>in_array(3,$data['correct']) ? 1 : 2,
                'add_time' => time(),
            ]);
            $res5 = DB::connection('mysqls')->table('probe_answer')->insert([
                'q_id' => $res1,
                'desc' => $data['ddescA'],
                'is_correct' =>in_array(4,$data['correct']) ? 1 : 2,
                'add_time' => time(),
            ]);
            $res = $res1 && $res2 && $res3 && $res4 && $res5;
            if ($res) {
                DB::commit();
                return redirect('probe/question_add');
            } else {
                DB::rollBack();
                return redirect('probe/question_add');
            }
        }
    }
    //调研详情链接
    public function http(Request $request){
            $id=$request->all();
            $request->session()->put('list_id',$id['id']);
            echo '复制链接到新的页面打开：'.asset('probe/list?='.$id['id']);
//            dd($id);
//        $this->list($id['id']);
    }
    public function list(){
            $id=session('list_id');
//            dd($id);
//        $theme=DB::connection('mysqls')->table('probe_theme')
//            ->where('t_id',$id)
//            ->get();
        $data=DB::connection('mysqls')->table('probe_question')
            ->join('probe_answer', 'probe_question.q_id', '=', 'probe_answer.q_id')
            ->where('t_id',$id)
            ->get()->toArray();
    if(!$data){
        echo '该项目不存在';die;
    }
//        dd($data);

//        die;
        return view('ceshi.probe.list',['data'=>$data]);
    }

}
