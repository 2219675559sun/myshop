<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>粉丝详情</title>
</head>
<body>
<div align="center">
    <h4><a href="{{url('liuyan/list')}}">查看我的留言</a></h4>
    <form action="">
        <table width="500" border="1">
            <tr>
                <th>Uid</th>
                <th>用户昵称</th>
                <th>操作</th>
            </tr>
            @foreach($list as $k=>$v)
            <tr>
                <td>{{$v->uid}}</td>
                <td>{{$v->name}}</td>
                <td>
                    <a href="{{url('liuyan/liuyan')}}?openid={{$v->openid}}">留言</a>&nbsp
                </td>
            </tr>
                @endforeach
        </table>
    </form>
</div>
</body>
</html>
