@extends('admin.layout.conmmen')
@section('body')
    <form action="{{url('goods/index')}}">
        <input type="text" name="name" value="{{$name}}" class="layui-input-block" style="width:300px;" placeholder='请输入商品名称关键字'>
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
        <th>ID</th>
        <th>商品名称</th>
        <th>商品图片</th>
        <th>商品库存</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($res as $k=>$v)
    <tr>
        <td>{{$v->id}}</td>
        <td>{{$v->name}}</td>
        <td><img src="{{asset('storage'.'/'.$v->image)}}" alt=""></td>
        <td>{{$v->number}}</td>
        <td>{{$v->add_time}}</td>
        <td>
            <a href="{{url('goods/delete')}}?id={{$v->id}}">删除</a>||
            <a href="{{url('goods/update')}}?id={{$v->id}}">修改</a>

        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="8">{{ $res->appends(['name' => $name])->links() }}</td>

    </tr>
    </tbody>

</table>
<div>当前共访问{{$num}}次</div>
@endsection
