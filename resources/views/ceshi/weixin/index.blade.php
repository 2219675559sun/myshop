@extends('admin.layout.conmmen')
@section('body')
<div align="center">
    <h5><a href="{{url('weixin/user_list')}}">刷新用户列表</a></h5>
<table width="500" border="1">
    <tr>
        <th>编号</th>
        <th>openid</th>
        <th>昵称</th>
        <th>操作</th>
    </tr>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->id}}</td>
        <td>{{$v->openid}}</td>
        <td>{{$v->nickname}}</td>
        <td>
            <a href="{{url('weixin/index_list')}}?id={{$v->id}}"> 详情</a>
        </td>
    </tr>
        @endforeach
</table>
</div>
@endsection
