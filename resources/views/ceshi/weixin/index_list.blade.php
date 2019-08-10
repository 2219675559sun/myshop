<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>详情</title>
</head>
<body>
    <table width="1000" border="1">
        <tr>
            <th>编号</th>
            <th>openid</th>
            <th>昵称</th>
            <th>头像</th>
            <th>是否关注</th>
            <th>性别</th>
            <th>国家</th>
            <th>省份</th>
            <th>地区</th>
            <th>添加时间</th>
        </tr>
        <tr>
            <td>{{$data->id}}</td>
            <td>{{$data->openid}}</td>
            <td>{{$data->nickname}}</td>
            <td><img src="{{$data->headimgurl}}" width="100"  alt=""></td>
            <td align="center">{{$data->subscribe==1?'√':'×'}}</td>
            <td>{{$data->sex==1?'男':'女'}}</td>
            <td>{{$data->country}}</td>
            <td>{{$data->province}}</td>
            <td>{{$data->city}}</td>
            <td>{{date('Y-m-d H:i:s',$data->subscribe_time)}}</td>
        </tr>
    </table>
</body>
</html>
