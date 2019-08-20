<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>留言</title>
</head>
<body>
<div align="center">
    <form action="{{url('liuyan/liuyan_do')}}" method="post">
        @csrf
        <input type="hidden" name="openid" value="{{$openid}}">
        留言内容 <br>
        <textarea name="content" style="width:300px;height: 100px;"></textarea> <br>
        <input type="submit" value="发送留言">
    </form>
</div>
</body>
</html>
