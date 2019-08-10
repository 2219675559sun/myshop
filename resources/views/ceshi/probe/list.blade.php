<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>详情页</title>
</head>
<body>
<div align="center">
<table width="800" border="1">
    <tr>
        <th>ID</th>
        <th>调研问题</th>
        <th>所有答案</th>

        <th>添加时间</th>
    </tr>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->q_id}}</td>
        <td>{{$v->question}}</td>
        <td>{{$v->desc}}</td>

        <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
    </tr>
    @endforeach
</table>
</div>
</body>
</html>
