<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>竞猜列表</title>
</head>
<body>
<div align="center">
    <h3>竞赛列表</h3><p>前台展示</p>
<table>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->one}}V S{{$v->two}}</td>
        <td>
            @if(time()>$v->over_time)
            <a href="{{url('team/list')}}?id={{$v->id}}">查看结果</a>
            @else
            <a href="{{url('team/list_queue')}}?id={{$v->id}}">竞赛</a>
            @endif
        </td>
    </tr>
        @endforeach
</table>
</div>
</body>
</html>
