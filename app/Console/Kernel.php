<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
            \Log::info(1231232123);
            die;
            $url="http://www.vizhiguo.com/qil/call";
            $data=file_get_contents($url);
            $data=json_decode($data,1);
            $city = $data['result'];
            $redis=new \Redis;
            $redis->connect('127.0.0.1','6379');
            foreach ($city as $k => $v) {
//            查询存入redis里的数据
                if($redis->exists($v['city'])){
                    $city_info=json_decode($redis->get($v['city']),1);
//                dump($city_info);
//                如果数据更新查出来
                    foreach($v as $k=>$val){
                        if($val != $city_info[$k]){
//                       模板推送
                            $app=app('wechat.official_account');
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
            }
//        dd($moban);
//        })->daily();
        })->everyMinute();

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
