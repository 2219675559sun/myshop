<?php
namespace page;
class AjaxPage
{
    /**
     * 功能：用于数据的分页展示
     * 参数：$page ，表示当前页的页码
     * $msg_count ，表示数据总数量
     * $pagesize ，表示每页显示的数量
     * $url ，表示页码的超链中除了page参数之外的其它参数。
     * 例如：$url = "?c=$_GET[c]&a=$_GET[a]$tid=1";
     * 本分页函数中，实现分页主要靠地址栏中的page来传参。
     * 返回：返回表示分页的字符串。如果使用smarty模板技术，只需要将该字符串抛到模板页即可。
     */
    static function pager($page, $msg_count, $pagesize, $url = '?' , $page_str_div = '')
    {
        $page_count = ceil($msg_count / $pagesize);//总页数
        $nextpage = $page + 1;
        $lastpage = $page - 1;

        if ($page > $page_count) {
            $page = $page_count;
        }
        $pagestring = "<div class='pager'>";
        $pagestring .= "总数:$msg_count &nbsp;&nbsp;&nbsp;页数:$page/$page_count &nbsp;&nbsp;&nbsp;<a href='$url" . "&page=1'>首页</a>&nbsp;&nbsp;";

        if ($page > 1) {
            $pagestring .= "<a href='$url" . "&page=$lastpage'>上页</a>&nbsp;&nbsp;";
        } else {
            $pagestring .= "<a href='#'>上页</a>&nbsp;&nbsp;";
        }

        /*
        if($page<5) { $startpage=1;}
        if($page>=5 && $page<($page_count-5)) { $startpage=$page-4;}
        if($page>=($page_count-5) && $page>5) { $startpage=$page_count-9;}
        if($page_count<=10) { $startpage=1;}

        if($page<5){
            if($page_count>=10) $endpage=10;
            else $endpage=$page_count;
        }

        if($page>=($page_count-5)) $endpage=$page_count;
        if($page>=5 && $page<($page_count-5)) $endpage=$page+5;

        for($i=$startpage;$i<=$endpage;$i++){
            if($page == $i) $pagestring .=  "<a href='#' class='thispage'>$i</a> &nbsp;&nbsp;";
            else $pagestring .=  "<a href='$url" . "&page=$i'>$i</a> &nbsp;&nbsp;";
        }*/

        if ($page < $page_count) {
            $pagestring .= "<a href='$url" . "&page=$nextpage'>下页</a>&nbsp;&nbsp;";
        } else {
            $pagestring .= "<a href='#'>下页</a>&nbsp;&nbsp;";
        }

        $pagestring .= "<a href='$url" . "&page=$page_count'>末页</a>&nbsp;&nbsp;";
        $pagestring .= "</div>";
        $pagestring .= self::pagecss();
        return $pagestring;
    }

    /**
     * 功能：用于数据ajax分页展示
     * 参数：
     *      $page ，表示当前页的页码
     *      $msg_count ，表示数据总数量
     *      $pagesize ，表示每页显示的数量
     *      $url ，表示页码的超链中除了page参数之外的其它参数。
     *
     * 例如：$url = "?c=$_GET[c]&a=$_GET[a]$tid=1";
     * 本分页函数中，实现分页主要靠地址栏中的page来传参。
     * 返回：返回表示分页的字符串。如果使用smarty模板技术，只需要将该字符串抛到模板页即可。
     * 因为是ajax分页，所有分页上的超链都是javascript。
     */
    static function ajaxpager($page, $msg_count, $pagesize, $urlpath='', $divid='' )
    {
        $page_count = ceil($msg_count / $pagesize);
//        $nextpage = $page + 1;
//        $lastpage = $page - 1;

        if ($page > $page_count) {
            $page = $page_count;
        }
        $pagestring = '<ul>';
//        $pagestring = "<div class='pager'>";
//        $pagestring .= "总数:$msg_count &nbsp;&nbsp;&nbsp;页数:$page/$page_count &nbsp;&nbsp;&nbsp;<a href='javascript:gotopage(1);'>首页</a>&nbsp;&nbsp;";
//
//        if ($page > 1) {
//            $pagestring .= "<a href='javascript:gotopage($lastpage);'>上页</a>&nbsp;&nbsp;";
//        } else {
//            $pagestring .= "<a href='javascript:'>上页</a>&nbsp;&nbsp;";
//        }

//        if($page<5) { $startpage=1;}
//        if($page>=5 && $page<($page_count-5)) { $startpage=$page-4;}
//        if($page>=($page_count-5) && $page>5) { $startpage=$page_count-9;}
//        if($page_count<=10) { $startpage=1;}
//
//        if($page<5){
//            if($page_count>=10) $endpage=10;
//            else $endpage=$page_count;
//        }
//
//        if($page>=($page_count-5)) $endpage=$page_count;
//        if($page>=5 && $page<($page_count-5)) $endpage=$page+5;
//
//        for($i=$startpage;$i<=$endpage;$i++){
//            if($page == $i) $pagestring .=  "<a href='javascript:;' style='color:red' class='thispage'>$i</a> &nbsp;&nbsp;";
//            else $pagestring .=  "<a href='javascript:gotopage($i);'>$i</a> &nbsp;&nbsp;";
//        }
//
//        if ($page < $page_count) {
//            $pagestring .= "<a href='javascript:gotopage($nextpage);'>下页</a>&nbsp;&nbsp;";
//        } else {
//            $pagestring .= "<a href='javascript:'>下页</a>&nbsp;&nbsp;";
//        }
        $pagestring .= self::showPage( $page_count , $page );
//
//        $pagestring .= "<a href='javascript:gotopage($page_count);'>末页</a>&nbsp;&nbsp;";
        $pagestring .= "</ul>";

        $pagestring .= self::gotopagejs($urlpath, $divid, $page);
        $pagestring .= self::pagecss();
        return $pagestring;
    }

    //ajax分页中用到的js
    static function gotopagejs($urlpath, $divid)
    {
        $out = "\n<script type='text/javascript'>\n";
        $out .= "function gotopage(page) {\n";
        $out .= "\$.get('" . $urlpath . "' , {'page': page , 'r':new Date().getTime()} , function(msg){\$('#" . $divid . "').html(msg);
        });\n";
        $out .= "}\n";
        $out .= "</script>\n";
        return $out;
    }

    //分页类中运用到的css
    static function pagecss()
    {
        $out = "<style>\n";
        $out .= ".pager{margin:10px auto; text-align:center;width:100%}\n";
        $out .= ".pager li{;float:left;font-size:19px;margin-left:8px }\n";
        $out .= ".pager a. thispage{background:#FFE375}\n";
        $out .= ".pager a: hover{background:#F5F5F5; text-decoration:none;}\n";
        $out .= ".pager .thispage{color:red;border:none;margin-top:5px}\n";
        $out .= "</style>\n";
        return $out;
    }


    private static function showPage(  $total , $now ){

        $page_str = '<div class="pager" style="width:100%;text-align:center;margin:0 auto"><ul>';

        if( $now <= 5 ){
            $end = 9 ;
            if( $end > $total){
                $end = $total;
            }
            for( $i = 1 ; $i <= $end; $i ++ ){
                if( $i != $now ){
                    $page_str .= '<li><a href="javascript:;" class="page" p="'.$i.'">'  . $i . '</a></li>';
                }else{
                    $page_str .= '<li class="thispage"><a href="javascript:;" class="page" p="'.$i.'">'.$i.'</a></li>';
                }
            }
        }else{
            $page_str .=  '<li><a href="javascript:;" class="page" p="1">1</a></li>';

            $end = $now + 4;
            $start = $now - 4;
            if( $start - 1 != 1  ){
                $page_str .= '<li>...</li>';
            }
            if( $end > $total ){
                $end = $total;
            }
            for( $start ; $start < $now; $start ++ ){
                $page_str .= '<li><a href="javascript:;" class="page" p="'.$start.'">'  . $start . '</a></li>';
            }
            $page_str .= '<li class="thispage"><a href="javascript:;" class="page" p="'.$start.'">'.$start.'</a></li>';
            if( $end <= $total ){
                for( $i = $now+1; $i <= $end; $i ++ ){
                    $page_str .= '<li><a href="javascript:;" class="page" p="'.$i.'">'  . $i . '</a></li>';
                }
            }
        }
        if( $end < $total ){
            if( $end + 1 < $total  ){
                $page_str .= '<li>...</li>';
            }
            $page_str .= '<li><a href="javascript:;" class="page" p="'.$total.'">'  . $total . '</a></li>';
        }

        $page_str .= '</ul></div>';
        return $page_str;
    }
}

?>