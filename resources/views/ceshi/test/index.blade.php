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
    <h3>展示页面</h3>
<h5><a href="{{url('test/add')}}">添加</a></h5>
<form action="">
    <table>
        @foreach($data as $k=>$v)
        <tr>
            <td><input type="checkbox">{{$v}}</td>
        </tr>
            @endforeach
    </table>
</form>
</div>
</body>
</html>
