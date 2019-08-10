<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>竞赛队列</title>
</head>
<body>
<div align="center"> <p>后台查看</p>
    <h3>比赛结果</h3>
<table>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->one}}VS{{$v->two}}</td>
        <td><a href="{{url('team/update_resule')}}?id={{$v->id}}">竞猜结果</a></td>
    </tr>
        @endforeach
</div>
</table>
</body>
</html>
