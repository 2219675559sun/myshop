<?php  /**
   * ʱ�����������װ
   * anthor qinpeizhou
   * @param $timeset  ʱ���ʽ
   * @param $time     sql���������Ҫ������time�ֶ�����
   * @param $stime    ��ʼʱ��  2017-01-01  ��ʽ
   * @param $etime    ����ʱ��  2017-01-01  ��ʽ
   * @return string   ���ص�����ʱ��ε�sql���--ʱ�������
   */
 function get_time_search_sql($timeset='',$time,$stime,$etime){
     // ��Y-m-d��ʽת����ʱ���
     $stime = strtotime($stime." 0:0:0");
     $etime = strtotime($etime." 23:59:59");
 
     $sqlwhere = "";
     if(!empty($timeset) && $timeset<>'customize' && $timeset <> 'search_for_month' ) {
         if($timeset=='yesterday'){
             //�����ʱ���
             $yesterday_start = strtotime('-1 day'.' 0:0:0');
             $yesterday_end = strtotime('-1 day'.' 23:59:59');
             $sqlwhere .= " and $time between $yesterday_start and $yesterday_end ";
        }elseif($timeset=='today'){
             //�����ʱ���
             $today_start = strtotime(date('Y-m-d',time()).' 0:0:0');
             $today_end  = strtotime(date('Y-m-d',time()).' 23:59:59');
             $sqlwhere .= " and $time between $today_start and $today_end ";
         }elseif($timeset=='lastweek'){
             //��ȡ������ʼʱ����ͽ���ʱ���
             $beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
             $endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
             $sqlwhere .= " and $time between $beginLastweek and $endLastweek ";
         }elseif($timeset=='lastmonth'){
             //�ϸ��µ���ʼʱ��:
             $begin_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));
             $end_time = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));
             $sqlwhere .= " and $time between $begin_time and $end_time ";
         }elseif($timeset=='thismonth'){
             //��ȡ������ʼʱ����ͽ���ʱ���
             $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
             $endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
             $sqlwhere .= " and $time between $beginThismonth and $endThismonth ";
         }
     }else if(  $timeset=='customize' && !empty($timeset) ) {
         $sqlwhere .= " and $time between $stime and $etime ";
     }else if($timeset == 'search_for_month') {  // �����·ݲ���
         $sqlwhere .= " and $time between $stime and $etime ";
     }
     return $sqlwhere;
 }