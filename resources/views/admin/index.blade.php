@extends('admin.layout.conmmen')
@section('body')
    <form action="{{url('atrain12306')}}">
        <input type="text" name="goods_name" value="{{$name}}" class="layui-input-block" style="width:300px;" placeholder='请输入商品名称关键字'>
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
            <th>商品昵称</th>
            <th>商品图片</th>
            <th>商品价格</th>
            <th>是否上架</th>
            <th>是否新品</th>
            <th>商品描述</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $k=>$v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->goods_name}}</td>
            <td width="200"><img src="{{asset('storage'.'/'."$v->goods_pic")}}" width="80" height="80" alt=""></td>
            <td>{{$v->goods_price}}</td>
            <td>{{$v->is_up}}</td>
            <td>{{$v->is_new}}</td>
            <td>{{$v->goods_centent}}</td>
            <td>{{$v->add_time}}</td>
            <td>
                <a href="{{url('admin/update')}}?id={{$v->id}}">修改</a>||
                <a href="{{url('admin/delete')}}?id={{$v->id}}">删除</a>
            </td>
        </tr>
        @endforeach
        <tr align="center">
            <td colspan="8">
                {{$data->appends(['goods_name' => $name])->links()}}
            </td>

        </tr>

        </tbody>
    </table>
    <div align="right">当前共访问{{$num}}次</div>

@endsection
