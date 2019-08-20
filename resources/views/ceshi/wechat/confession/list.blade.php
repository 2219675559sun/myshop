<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我的表白</title>
</head>
<body>
<div align="center">
    <table width="300" border="1">
        <tr>
            <th>我的表白</th>
            <th>时间</th>
        </tr>
        @foreach($data as $k=>$v)
            <tr>
                <td>{{$v->center}}</td>
                <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
            </tr>
            @endforeach
    </table>
</div>
</body>
</html>
