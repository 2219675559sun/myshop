<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>留言板</title>
</head>
<body>
<div align="center">
    <form action="{{url('leave/add_do')}}" method="post">
        @csrf
        <h4>留言板</h4>
        <h5>留言</h5>
        <input type="text" name="test" style="width:500px;height:50px;"><br>
        <input type="submit" value="留言">
    </form>
    <h4>留言列表</h4>当前页面浏览量：{{$num}}次

    <form action="{{url('leave/index')}}">
        姓名：<input type="text" name="name" value="{{$user_name}}"><input type="submit" value="搜索">
    </form>
    <table width="800" border="1">
        <tr>
            <td>编号</td>
            <td>留言内容</td>
            <td>姓名</td>
            <td>时间</td>
            <td>操作</td>
        </tr>
        @foreach($data as $k=>$v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->test}}</td>
            <td>{{$v->user_name}}</td>
            <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
            <td>
                @if($v->user_name==session('name') && time()-$v->add_time<900)
                <a href="{{url('leave/delete')}}?id={{$v->id}}">删除</a>
                    @endif
            </td>
        </tr>
            @endforeach
    </table>
</div>
</body>
</html>
