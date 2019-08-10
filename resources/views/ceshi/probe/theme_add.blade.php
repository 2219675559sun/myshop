<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>添加</title>
</head>
<body>
<div align="center">
    <h3>调研项目添加</h3>
    <h5><a href="{{url('probe/index')}}">调研项目列表</a></h5>
<form action="{{url('probe/theme_add_do')}}" method="post">
    @csrf
    <table>
        调研项目：<input type="text" name="theme" style="width:500px;height: 50px;"><br>
        <input type="submit" value="添加调研">
    </table>
</form>
</div>
</body>
</html>
