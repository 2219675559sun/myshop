<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>计费详情</title>
</head>
<body>
<div align="center">
    <h2>收费信息</h2>
    <br>
    <br>
    <table>
        尊敬的  <span style="color:red;">{{$data->car}}</span> 车主 <br>
        停车：<span style="color:red;">{{$day}}</span>天
        <span style="color:red;">{{$h}}</span>小时<span style="color:red;">{{$i}}</span>分钟 <br>
        收费：<span style="color:red;">{{$price}}</span> 元 <br>
    </table>
</div>

</body>
</html>
