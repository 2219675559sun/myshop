<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>展示</title>
</head>
<body>
<div align="center">
    <h1>火车票管理系统</h1>
<form action="{{url('12306/index')}}">
    出发地：<input type="text" name="start" value="{{$start}}">--目的地：<input type="text" name="place" value="{{$place}}"><input type="submit" value="搜索">
</form>
    <table width="1000" border="1">
        <tr>
            <th>车次</th>
            <th>出发站||到达站</th>
            <th>出发时间||到达时间</th>
            <th>一等座</th>
            <th>二等座</th>
            <th>硬座</th>
            <th>无座</th>
            <th>价格</th>
            <th>操作</th>
        </tr>
        @foreach($data as $k=>$v)
        <tr>
            <td>{{$v->carnum}}</td>
            <td>{{$v->start}}||{{$v->place}}</td>
            <td>{{date('Y-m-d H:i:s',$v->add_time)}}||{{date('Y-m-d H:i:s',$v->over_time)}}</td>
            @if($v->number==0)  <td>无</td>
            @else
            <td>@if($v->number<=100){{$v->number}}@else 有 @endif </td>
            @endif
            <td>无</td>
            <td>无</td>
            <td>无</td>
            <td>{{$v->price}}</td>
            @if($v->number==0)
                <td>无票</td>
            @else
            <td><a href="">购买</a></td>
                @endif
        </tr>

            @endforeach

    </table>
    <div>当前访问{{$num}}次</div>
</div>
</body>
</html>
