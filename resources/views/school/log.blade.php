<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
</head>
<body>
<div align="center">
    <h2>登录页面</h2>
<form action="{{url('leave/log_do')}}" method="post">
    @csrf
    用户名：<input type="text" name="name"><br>
    密码：<input type="password" name="pwd"> <br>
    <input type="submit" value="登录">
</form>
</div>
</body>
</html>
