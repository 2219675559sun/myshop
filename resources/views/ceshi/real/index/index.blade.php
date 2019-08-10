<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>车辆管理</title>
</head>
<body>
<div align="center">
    <h2>车辆管理系统</h2>
    <table>
    小区车位：{{$number}}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 剩余车位：{{$num}}<br>
        <br><br><br>
        @if($num==0)
            <button disabled>已经停满</button>
        @else
        <a href="{{url('car/enter')}}">车辆入库</a>     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="{{url('car/come')}}">车辆出库</a>
            @endif
    </table>
</div>
</body>
</html>
