<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $app=app('wechat.official_account');
            $info=$app->user->list($nextOpenId = null);
            $openid=$info['data'];
            foreach($openid['openid'] as $v){
                $moban= $app->template_message->send([
                    'touser' => $v,
                    'template_id' => 'b1Vy0a_WIGRNFqrWW2hFQLS9dgGHvplswhC21osRp5E',
                    'url' => 'https://easywechat.org',
                    'data' => [
                        'keyword' => '您还没签到',
                    ],
                ]);
            }
            //断签的话为0
            $res=DB::connection('mysqls')->table('wechat_openid')->get()->toArray();
            foreach($res as $v){
                $res=DB::connection('mysqls')->table('wechat_openid')->where('openid',$v->openid)->first();
                if($res->is_isset==0){
                    $re=DB::connection('mysqls')->table('wechat_openid')->where('openid',$v->openid)->update([
                        'aa'=>0,
                    ]);

                }
            }
            /* $redis=new \Redis;
             $redis->connect('127.0.0.1','6379');
             $app=app('wechat.official_account');

             $url="http://www.vizhiguo.com/qil/call";
             $data=file_get_contents($url);
             $data=json_decode($data,1);
             $city = $data['result'];
             foreach ($city as $k => $v) {
 //            查询存入redis里的数据
                 if($redis->exists($v['city'])){
                     $city_info=json_decode($redis->get($v['city']),1);
 //                dump($city_info);
 //                如果数据更新查出来
                     foreach($v as $k=>$val){
                         if($val != $city_info[$k]){
 //                       模板推送
                             //查询用户
                             $openid_list=$app->user->list($nextOpenId = null);
                             $openid=$openid_list['data'];
                             //循环展示用户的openid
                             foreach($openid['openid'] as $k=>$va){
                                 $moban=$app->template_message->send([
                                     'touser' =>$va,
                                     'template_id' => 'MOtuco--HJATnyPCuegGKQR27e2u2NNycf4pyMpuX58',
                                     'url' => 'http://www.vizhiguo.com/confession/add_confession',
                                     'data' => [
                                         'keyword' => $v['city'] . '最新油价' . "\n" . 'b90:' . $v['b90'] . '￥' . "\n" . 'b93:' . $v['b93'] . '￥' . "\n" . 'b97:' . $v['b97'] . '￥' . "\n" . 'b0:' . $v['b0'] . '￥' . "\n" . '92h:' . $v['92h'] . '￥' . "\n" . '95h:' . $v['95h'] . '￥' . "\n" . '98h:' . $v['98h'] . '￥' . "\n" . '0h:' . $v['0h'] . '￥',
                                         'keyword1'=>date('Y-m-d H:i:s',time()),
                                         'remark'=>'如有打扰 尽情谅解',
                                     ],
                                 ]);
                             }
                         }
                     }
                 }
             }*/
//        dd($moban);
        })->daily();
//        })->everyMinute();
//    })->everyFiveMinutes();
        $schedule->command('report:generate')
            ->timezone('China:Beijing')
            ->at('15:15');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
