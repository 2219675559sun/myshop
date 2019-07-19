@extends('admin.layout.conmmen')
@section('body')
    <form action="{{url('admin/userList')}}">
        <input type="text" name="user" value="{{$user}}" class="layui-input-block" style="width:300px;" placeholder='请输入商品名称关键字'>
        <input type="submit" value="搜索" class="layui-btn layui-btn-radius layui-btn-normal">
    </form>

    <table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>id</th>
        <th>用户名</th>
        <th>邮箱</th>
        <th>管理员权限</th>
        <th>管理员状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->id}}</td>
        <td>{{$v->name}}</td>
        <td>{{$v->email}}</td>
        <td>{{$v->user}}</td>
        <td>{{$v->is_user}}</td>
        <td>

                @if($userid->user=='管理员')
                    @if($v->user=='普通会员')
                        <a href="{{url('admin/user_update')}}?id={{$v->id}}">修改</a>||
                        <a href="{{url('admin/user_delete')}}?id={{$v->id}}">删除</a>
                    @endif
                    @else
                @if($v->id!=$userid->id)

                    <a href="{{url('admin/user_update')}}?id={{$v->id}}">修改</a>||
                    <a href="{{url('admin/user_delete')}}?id={{$v->id}}">删除</a>

                @endif
                @endif
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="8" align="center"> {{$data->appends(['user' => $user])->links() }}</td>

    </tr>
    </tbody>
</table>
@endsection
