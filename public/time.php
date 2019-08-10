<?php  /**
   * 时间搜索插件封装
   * anthor qinpeizhou
   * @param $timeset  时间格式
   * @param $time     sql语句中所需要搜索的time字段名称
   * @param $stime    开始时间  2017-01-01  格式
   * @param $etime    结束时间  2017-01-01  格式
   * @return string   返回的搜索时间段的sql语句--时间戳搜索
   */
 function get_time_search_sql($timeset='',$time,$stime,$etime){
     // 把Y-m-d格式转化成时间戳
     $stime = strtotime($stime." 0:0:0");
     $etime = strtotime($etime." 23:59:59");
 
     $sqlwhere = "";
     if(!empty($timeset) && $timeset<>'customize' && $timeset <> 'search_for_month' ) {
         if($timeset=='yesterday'){
             //昨天的时间戳
             $yesterday_start = strtotime('-1 day'.' 0:0:0');
             $yesterday_end = strtotime('-1 day'.' 23:59:59');
             $sqlwhere .= " and $time between $yesterday_start and $yesterday_end ";
        }elseif($timeset=='today'){
             //今天的时间搓
             $today_start = strtotime(date('Y-m-d',time()).' 0:0:0');
             $today_end  = strtotime(date('Y-m-d',time()).' 23:59:59');
             $sqlwhere .= " and $time between $today_start and $today_end ";
         }elseif($timeset=='lastweek'){
             //获取上周起始时间戳和结束时间戳
             $beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
             $endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
             $sqlwhere .= " and $time between $beginLastweek and $endLastweek ";
         }elseif($timeset=='lastmonth'){
             //上个月的起始时间:
             $begin_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));
             $end_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));
             $sqlwhere .= " and $time between $begin_time and $end_time ";
         }elseif($timeset=='thismonth'){
             //获取本月起始时间戳和结束时间戳
             $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
             $endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
             $sqlwhere .= " and $time between $beginThismonth and $endThismonth ";
         }
     }else if(  $timeset=='customize' && !empty($timeset) ) {
         $sqlwhere .= " and $time between $stime and $etime ";
     }else if($timeset == 'search_for_month') {  // 根据月份查找
         $sqlwhere .= " and $time between $stime and $etime ";
     }
     return $sqlwhere;
 }