<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>调研列表</title>
</head>
<body>
<div align="center">
    <h3>调研项目列表</h3>
    <h5><a href="{{url('probe/theme_add')}}">项目添加</a></h5>
<form action="">
    <table width="500" border="1">
        @foreach($data as $k=>$v)
        <tr>
            <th>{{$v->theme}}</th>
            <th>
                <a href="{{url('probe/http')}}?id={{$v->t_id}}">启用</a>&nbsp&nbsp&nbsp
                <a href="">删除</a>
            </th>
        </tr>
            @endforeach
    </table>
</form>
</div>
</body>
</html>
