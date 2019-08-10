<?php

namespace App\Http\Controllers\ceshi\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
//考试系统
class TestController extends Controller
{
    public function log(){

        return view('ceshi.test.log');
    }
 public function log_do(Request $request){
        $data=$request->all();

        $res=DB::connection('mysqls')->table('denglu')->where(['name'=>$data['name'],'pwd'=>md5($data['pwd'])])->first();
//        dd($res);
     if($res){
         return redirect('test/index');
     }
    }
    public function index(){
        $data3=DB::connection('mysqls')
            ->table('radio')
            ->select('radio.a_test')
            ->get()->toArray();
        $data1=DB::connection('mysqls')
            ->table('exists')
            ->select('exists.e_test')
            ->get()->toArray();
        $data2=DB::connection('mysqls')
            ->table('checkbox')
            ->select('checkbox.c_test')
            ->get()->toArray();
        foreach($data3 as $k=>$v){
            dump($v);
        }
       $data[]=$data3;
        $data[]=$data2;
        $data[]=$data1;

    dd($data);
        return view('ceshi.test.index',['data'=>$data]);
    }
    public function add(Request $request){
        $value=$request->all('value');


        return view('ceshi.test.add');
    }
    //        单选
    public function radio(Request $request){
        $data=$request->all();
        DB::connection('mysqls')->beginTransaction();
//        $correct=$data['a_correct'];
//        $option=$data[$correct];
        $res4=DB::connection('mysqls')->table('question_problem')->insertGetId([
            'type_id'=>$data['type_id'],
            'problem'=>$data['problem'],
            'add_time'=>time(),
        ]);
//        a_optionA
        $res1=DB::connection('mysqls')->table('question_answer')->insert([
            'problem_id'=>$res4,
            'desc'=>$data['a_optionA'],
            'is_answer'=>($data['is_answer']==1)?1:0,
            'add_time'=>time(),
        ]);
        $res2=DB::connection('mysqls')->table('question_answer')->insert([
            'problem_id'=>$res4,
            'desc'=>$data['a_optionB'],
            'is_answer'=>($data['is_answer']==2)?1:0,
            'add_time'=>time(),
        ]);
        $res3=DB::connection('mysqls')->table('question_answer')->insert([
            'problem_id'=>$res4,
            'desc'=>$data['a_optionC'],
            'is_answer'=>($data['is_answer']==3)?1:0,
            'add_time'=>time(),
        ]);
        $res4=DB::connection('mysqls')->table('question_answer')->insert([
            'problem_id'=>$res4,
            'desc'=>$data['a_optionD'],
            'is_answer'=>($data['is_answer']==4)?1:0,
            'add_time'=>time(),
        ]);
        $res=$res4 && $res1 && $res2 && $res3;
        if($res){
            DB::connection('mysqls')->commit();
            return redirect('test/add');
        }else{
            DB::connection('mysqls')->rollBack();
            return redirect('test/add');
        }

    }
    public function checkbox(Request $request){
        $data=$request->all();
        $correct=$data['c_correct'];
        $a=implode(',',$correct);
        $data['c_correct']=$a;
//       dd($data);
        $res=DB::connection('mysqls')->table('checkbox')->insert([
            'c_test'=>$data['c_test'],
            'c_optionA'=>$data['c_optionA'],
            'c_optionB'=>$data['c_optionB'],
            'c_optionC'=>$data['c_optionC'],
            'c_optionD'=>$data['c_optionD'],
            'c_correct'=>$data['c_correct'],
        ]);
//        dd($res);
        if($res){
            return redirect('test/add');
        }
    }
    public function exists(Request $request){
        $data=$request->all();
//        dd($data);
        $res=DB::connection('mysqls')->table('exists')->insert([
            'e_test'=>$data['e_test'],
            'e_crooect'=>$data['e_crooect'],
        ]);
        if($res){
            return redirect('test/add');
        }
    }
}
