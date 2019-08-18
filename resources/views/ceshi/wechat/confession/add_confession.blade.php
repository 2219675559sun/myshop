<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加表白</title>
</head>
<body>
<div align="center">
    <form action="{{url('confession/confession_do')}}" method="post">
        @csrf
        表白内容：<br><textarea name="conect" style="width:300px;height:100px;"></textarea> <br>
        是否匿名：<input type="radio" name="type" value="1">是
                    <input type="radio" name="type" value="2" checked>否 <br>
        要表白的人：<select name="openid" id="" style="width:200px;height:30px;">
            @foreach($data as $k=>$v)
            <option value="{{$v->openid}}">{{$v->nickname}}</option>
             @endforeach
        </select><br><br>
        <input type="submit" value="表白">
    </form>
</div>
</body>
</html>
